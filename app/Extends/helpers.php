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
        $domain = config('filesystems.disks.oss.url');
        $prefix = config('filesystems.disks.oss.prefix');
        $url = $domain .'/' ;
        if($prefix){
            $url = $url . $prefix . '/';
        }
        return  $url . $path;
    }
}