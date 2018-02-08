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

        return   $driver->path($path);
    }
}


if(! function_exists('uniqueCode')){
    function uniqueCode($prefix = '')
    {
        return $prefix.date('Ymdhis').sprintf('%06d', rand(0, 999999));
    }
}