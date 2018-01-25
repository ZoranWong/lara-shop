<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Stevenyangecho\UEditor\Controller;
use App\Http\Requests\Ajax\IamgeUload as Request;
use zgldh\QiniuStorage\QiniuAdapter;

class FileController extends Controller
{

    /**
     * 头像图片上传
     *
     * @param  Request  $request
     * @return Response
     */
    public function userAvatar(Request $request)
    {
        $imageDir = 'user/avatar/' . date('Ym');
        $imageUrl = $this->uploadImage($request->file('image'),$imageDir);

        return response()->ajax($imageUrl);
    }

    /**
     * 产品图片上传
     *
     * @param  Request  $request
     * @return Response
     */
    public function merchandiseImage(Request $request)
    {
        $imageDir = 'merchandise/images/' . date('Ym');
        $imageUrl = $this->uploadImage($request->file('image'),$imageDir);

        return response()->ajax($imageUrl);
    }

    private function uploadImage(UploadedFile $file,$imageDir)
    {
        $path = $file->store($imageDir, config('filesystems.cloud'));
        $imageUrl  = getImageUrl($path);
        return $imageUrl;
    }
}