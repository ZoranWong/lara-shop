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


if(! function_exists('dbTransaction')){

    /**
     * db transaction
     * @param Closure $commit
     * @param Closure $error
     * @return Mixed
     * @throws
     * */
    function dbTransaction(Closure $commit, Closure $error = null)
    {
        DB::beginTransaction();
        try{
            $result = $commit();
            DB::commit();
            return $result;
        }catch (Exception $exception){
            DB::rollBack();
            if($error){
                return $error($exception);
            }else{
                throw $exception;
            }
        }
    }
}

if(!function_exists('dayStart')){
    function dayStart( $day = null, $timeStrap = false ){
        if(is_numeric($day)){
            $dateTime = 86400;
            $date =  date('Y-m-d h:m:s', strtotime(date('Y-m-d 00:00:00')) - $dateTime * $day);
        }elseif (is_string($day) && preg_match( '/^\d{4}-\d{2}-\d{2}$/', $day)){
            $date = $day.' 00:00:00';
        }else{
            $date = date('Y-m-d').' 00:00:00';
        }
        return $timeStrap ? $date : strtotime($date);
    }
}

if(!function_exists('dayEnd')){
    function dayEnd( $day = null, $timeStrap = false ){
        if(is_numeric($day)){
            $dateTime = 86400;
            $date = date('Y-m-d h:m:s', strtotime(date('Y-m-d 23:59:59')) - $dateTime * $day);
        }elseif (is_string($day) && preg_match( '/^\d{4}-\d{2}-\d{2}$/', $day)){
            $date = $day.' 23:59:59';
        }else{
            $date = date('Y-m-d').' 23:59:59';
        }
        return $timeStrap ? $date : strtotime($date);
    }
}