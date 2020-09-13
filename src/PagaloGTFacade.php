<?php

namespace ArielMejiaDev\PagaloGT;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ArielMejiaDev\PagaloGT\Skeleton\SkeletonClass
 */
class PagaloGTFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        static::clearResolvedInstance('pagalogt');
        return 'pagalogt';
    }
}
