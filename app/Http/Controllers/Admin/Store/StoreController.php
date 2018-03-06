<?php

namespace App\Http\Controllers\Admin\Store;

use App\Models\Store;
use App\Models\StoreOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    //
    public function __construct(Page $page, \Closure $callback = null)
    {
        $this->page = $page;
        $page->setModel(Store::class);
        parent::__construct(function (){
            return [
                ['with' => ['owner.user', 'managers.user']]
            ];
        });
    }
    /**
     * 同意申请
     * @param int $id
     * @return Response
     * */
    public function agree(int $id)
    {
       $store = Store::find($id);
       if($store){
           $store->status = Store::STATUS['PASS'];
           $store->save();
           return \Response::ajax([
               'message' => '店铺申请已通过'
           ]);
       }else{
           return back()->withInput()->withErrors('不存在相应的店铺申请');
       }
    }

    /**
     * 拒绝
     * @param int $id
     * @return Response
     * */
    public function refuse(int $id)
    {
        $store = Store::find($id);
        if($store){
            $store->status = Store::STATUS['REFUSE'];
            $store->save();
            return \Response::ajax([
                'message' => '已拒绝店铺申请'
            ]);
        }else{
            return back()->withInput()->withErrors('不存在相应的店铺申请');
        }
    }
}
