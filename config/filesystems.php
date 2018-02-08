<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 'qiniu'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'oss' => [
            'driver'     => 'oss',
            'access_id'  => env('OSS_ACCESS_ID','IsdaxhlR9kzdnGMQ'),
            'access_key' => env('OSS_ACCESS_KEY','BTNu7FgrQImHLhtMsVjm4J30Ttwmk2'),
            'bucket'     => env('OSS_BUCKET','zuizan'),
            //ECS访问的内网Endpoint oss-cn-hangzhou-internal.aliyuncs.com
            //外网Endpoint  oss-cn-hangzhou.aliyuncs.com
            'endpoint'   => env('OSS_ENDPOINT','oss-cn-hangzhou.aliyuncs.com'),
            //'prefix'     => env('OSS_PREFIX', 'v2'), // optional
            'url'        => env('OSS_URL','https://zuizan.oss-cn-hangzhou.aliyuncs.com'),
        ],
        'qiniu' => [
            'driver'  => 'qiniu',
            'domain' => env('QINIU_DOMAIN_DEFAULT', 'https://jouker.qiniudn.com/'),
            'access_key'=> env('QINIU_ACCESS_KEY', 'jcjRSvq37da4clZn4wx-LSDozGHH31I_Ls0yOFW3'),  //AccessKey
            'secret_key'=> env('QINIU_SECRET_KEY', 'Zrrl4ItH9bkInz4FwemX9h6J3CpVy7BLowDC2Eni'),  //SecretKey
            'bucket'    => env('QINIU_BUCKET', 'jouker'),  //Bucket名字
            'notify_url'=> env('QINIU_NOTIFY_URL', ''),  //持久化处理回调地址
            'access'    => env('QINIU_ACCESS', 'public')  //空间访问控制 public 或 private
        ],
    ],

];
