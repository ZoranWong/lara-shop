<?php
if (! function_exists('getImageUrl')) {
    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param  string  $path
     * @return string
     */
    function getImageUrl($path)
    {
        $driver = Storage::cloud();
        if(!$driver->getDriver()->getAdapter()->getPathPrefix()){
            $cloud = config('filesystems.cloud');
            $driver->getDriver()->getAdapter()->setPathPrefix(config("filesystems.disks.{$cloud}.domain"));
        }
        return   $driver->path($path);
    }
}


if(! function_exists('uniqueCode')){
    function uniqueCode($prefix = '')
    {
        return $prefix.date('Ymdhis').sprintf('%06d', rand(0, 999999));
    }
}