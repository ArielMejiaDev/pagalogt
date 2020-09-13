<?php

namespace ArielMejiaDev\PagaloGT;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PagaloGT
{
    private $client;
    private $company;
    private $products;
    private $card;
    private $url;
    private $retryTimes = 3;
    private $retrySleep = 500;

    const APPROVE_REASON_CODE = 100;
    const APPROVE_DECISION = "ACCEPT";
    private $responseDecision;
    private $responseReasonCode;

    public function __construct()
    {
        $this->company = [
            'key_secret'=> config('pagalogt.production.key_secret'),
            'key_public'=> config('pagalogt.production.key_public'),
            'idenEmpresa'=> config('pagalogt.production.iden_empresa'),
        ];
        $this->products = Collection::make([]);
        $this->url = 'https://app.pagalocard.com/api/v1/integracion/' . config('pagalogt.production.token');
    }

    public function cybersourceCodeResolver()
    {
        if (! config('pagalogt.use_cybersource')) {
            return 'ASDF32RDSF23DSFA32';
        }
        return request()->deviceFingerprintID;
    }

    public function setClient($name, $lastname, $email, $currency = 'GTQ', $phone = null, $country = 'Guatemala', $state = 'Guatemala', $city = 'Guatemala', $postalCode = null, $address = null)
    {
        $this->client = [
            'firstName'=>mb_convert_encoding($name, 'HTML-ENTITIES'),
            'lastName'=>mb_convert_encoding($lastname, 'HTML-ENTITIES'),
            'street1'=> $address ?? '',
            'phone'=> $phone ?? '',
            'country'=> $country,
            'city'=> $city,
            'state'=> $state,
            'currency'=> $currency,
            'postalCode'=> $postalCode ?? '',
            'email'=> $email,
            'ipAddress'=> request()->ip(),
            'Total'=> $this->total(),
            'fecha_transaccion'=> now(),
            'deviceFingerprintID' => $this->cybersourceCodeResolver(),
        ];
        return $this;
    }

    public function add($quantity, $description, $price, $type = null, $id = null)
    {
        $this->products->push(collect([
            'id_producto' => $id,
            'cantidad' => $quantity,
            'tipo' => $type,
            'nombre' => $description,
            'precio' => $price,
            'Subtotal' => $quantity * $price,
        ]));
        return $this;
    }

    private function total()
    {
        return $this->products->sum('precio');
    }

    public function setCard($nameCard, $accountNumber, $expirationMonth, $expirationYear, $cvvCard)
    {
        $this->card = [
            'nameCard'=> mb_convert_encoding($nameCard, 'HTML-ENTITIES'),
            'accountNumber'=> $accountNumber,
            'expirationMonth'=> $expirationMonth,
            'expirationYear'=> $expirationYear,
            'CVVCard'=> $cvvCard,
        ];
        return $this;
    }

    public function withTestCard($name = 'John Doe')
    {
        $this->setCard($name, 4000000000000416, 12, now()->year, 123);
        return $this;
    }

    public function withTestCredentials()
    {
        $this->company = [
            'key_secret'=> config('pagalogt.test.key_secret'),
            'key_public'=> config('pagalogt.test.key_public'),
            'idenEmpresa'=> config('pagalogt.test.iden_empresa'),
        ];
        $this->url = 'https://app.pagalocard.com/api/v1/integracion/' . config('pagalogt.test.token');
        return $this;
    }

    public function pay()
    {
        $data = [
            'empresa' => json_encode($this->company),
            'cliente' => json_encode($this->client),
            'detalle' => json_encode($this->products),
            'tarjetaPagalo' => json_encode($this->card),
        ];

        $ch = curl_init($this->url);
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //Execute the request
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
