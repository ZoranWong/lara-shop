<?php

namespace App\Http\Controllers\Admin\Merchandise;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Models\Merchandise;
use App\Http\Requests\Ajax\Merchandise as Request;
use App\Http\Controllers\Admin\BaseController as Controller;
use App\Models\Product;
use App\Models\Store;
use App\Renders\Form;
use App\Services\StoreService;
use Illuminate\Support\Facades\Input;

class MerchandiseController extends Controller
{
    //
    public function __construct(Page $page)
    {
        $this->page = $page;
        $page->setModel(Merchandise::class);
        parent::__construct(function (){
            return [];
        });
    }

    public function products($goodId)
    {
        if ($goodId) {
            $data = Product::where('merchandise_id',$goodId)->get()->toArray();
            return response()->ajax($data);
        }
        return response()->errorAjax('没有数据');
    }

    public function create(): BasePage
    {
        return $this->page->vueForm();
    }

    public function edit($id): BasePage
    {
        return $this->page->vueForm($id);
    }

    public function ajaxStore(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        app('request')['code'] = 'ZM-'.date('Ymdhis').str_random(4);
        $storeID = StoreService::getCurrentID();
        $storeID =  $storeID ? $storeID : $request['store_id'];
        app('request')['store_id'] = $storeID;
        if(!$request['store_id'] || !Store::find($request['store_id'])){
            return back()->withInput()->withErrors('店铺信息错误或者不存在');
        }
        $products = app('request')['products'];
        unset(app('request')['products']);
        $productsModels = [];
        $merchandiseData = Input::all();
        if($products){
            $merchandiseData['max_price'] = 0;
            $merchandiseData['min_price'] = 0;
            foreach ($products as &$product){
                if($merchandiseData['min_price'] == 0 || $merchandiseData['min_price'] > $product['sell_price']){
                    $merchandiseData['min_price'] = $product['sell_price'];
                }

                if($merchandiseData['max_price'] == 0 || $merchandiseData['max_price'] < $product['sell_price']){
                    $merchandiseData['max_price'] = $product['sell_price'];
                }
                $product['code'] = 'ZMP-'.date('Ymdhis').str_random(4);
                $productsModels[] = new Product($product);
            }
        }
        \DB::beginTransaction();
        try{
            $merchandise = Merchandise::create($merchandiseData);

            if(count($productsModels) > 0) {
                $merchandise->s($productsModels);
            }
            \DB::commit();
            return response()->ajax($merchandise);
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->errorAjax($exception->getMessage());
        }
    }

    public function ajaxUpdate(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        $products = app('request')['products'];
        unset(app('request')['products']);
        $productsModels = collect();
        $merchandiseData = Input::all();
        if($products){
            $merchandiseData['max_price'] = 0;
            $merchandiseData['min_price'] = 0;
            foreach ($products as &$product){
                if($merchandiseData['min_price'] == 0 || $merchandiseData['min_price'] > $product['sell_price']){
                    $merchandiseData['min_price'] = $product['sell_price'];
                }

                if($merchandiseData['max_price'] == 0 || $merchandiseData['max_price'] < $product['sell_price']){
                    $merchandiseData['max_price'] = $product['sell_price'];
                }
                $product['code'] = isset($product['code']) && !!$product['code'] ? $product['code'] : 'ZMP-'.date('Ymdhis').
                    str_random(4);
                $productsModels->push(new Product($product));
            }
        }
        \DB::beginTransaction();
        try{
            $merchandise = Merchandise::find($id);
            $merchandise->update($merchandiseData);

            if(count($productsModels) > 0) {
                $merchandise->saveProducts($productsModels, 'code');
            }
            \DB::commit();
            return response()->ajax($merchandise);
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->errorAjax($exception->getMessage());
        }
    }

    public function onShelves(string $ids)
    {
        $ids = explode(',', $ids);

        $count = Merchandise::where('status', Merchandise::STATUS['ON_SHELVES'])->whereIn('id', $ids)->count();

        if($count > 0){
            return response()->errorAjax(['message' => '上架商品中包含已经上架商品！']);
        }

        $result = Merchandise::whereIn('id', $ids)->update(['status'=> Merchandise::STATUS['ON_SHELVES']]);

        if($result > 0){
            return response()->ajax(['message' => '成功上架所选商品！']);
        }else{
            return response()->ajax(['message' => '上架失败！']);
        }
    }


    public function takenOff(string $ids)
    {
        $ids = explode(',', $ids);

        $count = Merchandise::where('status', Merchandise::STATUS['TAKEN_OFF'])->whereIn('id', $ids)->count();

        if($count > 0){
            return response()->errorAjax(['message' => '下架商品中包含已经下架商品！']);
        }

        $result = Merchandise::whereIn('id', $ids)->update(['status'=> Merchandise::STATUS['TAKEN_OFF']]);

        if($result > 0){
            return response()->ajax(['message' => '成功下架所选商品！']);
        }else{
            return response()->ajax(['message' => '下架失败！']);
        }
    }
}
