<?php
namespace App\Http\Controllers\Admin\Home\Store;

use App\Renders\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WxAuthQrCode extends Widget implements Renderable
{
    protected $view = "store.home.wx_auth_qrcode";

    public function render()
    {
        // TODO: Implement render() method.
        return view($this->view);
    }
}