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
        return  Storage::cloud()->path($path);
    }
}