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
use Illuminate\Support\Collection;
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

    public function products($merchandiseId)
    {
        if ($merchandiseId) {
            $data = Product::where('merchandise_id',$merchandiseId)->get()->toArray();
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
        $storeID = StoreService::getCurrentID();
        $storeID =  $storeID ? $storeID : $request['store_id'];
        app('request')['store_id'] = $storeID;
        $store = Store::find($request['store_id']);
        if(!$request['store_id'] || !$store){
            return back()->withInput()->withErrors('店铺信息错误或者不存在');
        }
        $products = app('request')['products'];
        unset(app('request')['products']);
        $productsModels = collect();
        $merchandiseData = Input::all();
        $merchandiseData['store_code'] = $store['code'];
        if($products){
            $this->fetchProducts($products, $merchandiseData, $productsModels);
        }
        \DB::beginTransaction();
        try{
            $merchandise = Merchandise::create($merchandiseData);

            if(count($productsModels) > 0) {
                $merchandise->saveProducts($productsModels);
            }
            \DB::commit();
            return response()->ajax($merchandise);
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->errorAjax($exception->getMessage());
        }
    }

    protected function fetchProducts(array $products,array &$data, Collection &$productsModels){

        if(is_array( $products ) && !empty($products)){
            $priceArray = [];
            foreach ($products as $key => $product) {
                $product['code'] = isset($product['code']) && !!$product['code'] ? $product['code'] :
                    null;
                $productsModels->push(new Product($product));
                $productsModels->push(new Product($product));
                array_push($priceArray, $product['sell_price'] ? $product['sell_price'] : 0);
            }

            $data['spec_array']     =   $this->buildSelectedSku($products);
            $data['max_price']      =   max($priceArray);
            $data['min_price']      =   min($priceArray);
        } else {
            $data['max_price']      =   $data['sell_price'];
            $data['min_price']      =   $data['sell_price'];
        }
    }

    protected function buildSelectedSku($products){
        $result = [];
        foreach ($products as $product){
            if($product['spec_array']){
                foreach ($product['spec_array'] as $item){
                    $id = $item['id'];
                    if(!isset($result[$id]) || $result[$id] == null){
                        $result[$item['id']] = [];
                    }

                    $result[$id]['name'] = $item['name'];
                    $result[$id]['id'] = $item['id'];
                    if(!isset($result[$id]['value']) || $result[$id]['value'] == null)
                        $result[$id]['value'] = [];
                    $result[$id]['value'][$item['tip']] = $item['value'];
                }
            }
        }
        $tmp = [];
        foreach ($result as $item){
            $tmp[] = $item;
        }
        $result = $tmp;
        return $result;
    }

    public function ajaxUpdate(Request $request, int $id): \Symfony\Component\HttpFoundation\Response
    {
        $products = app('request')['products'];
        unset(app('request')['products']);
        $productsModels = collect();
        $merchandiseData = Input::all();
        if($products){
            $this->fetchProducts($products, $merchandiseData, $productsModels);
        }
        \DB::beginTransaction();
        try{
            $merchandise = Merchandise::find($id);
            $merchandise->update($merchandiseData);

            $merchandise->saveProducts($productsModels, 'code');
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

    public function ajaxList(\Illuminate\Http\Request $request)
    {
        $storeId = StoreService::getCurrentID();
        $query = Merchandise::with('products');
        if($storeId)
            $query->where('store_id', $storeId);
        $merchandises = $query->where('status', $request->input('status', Merchandise::STATUS['ON_SHELVES']))->paginate();
        $merchandises->map(function (Merchandise $merchandise){
            $merchandise->products->map(function (Product $product){
                $sku = collect($product->spec_array)->map(function ($item){
                    return "{$item['name']}:{$item['value']}";
                });
                $product['sku'] = implode(",", $sku->all());
            });
        });
        return response()->ajax($merchandises);
    }
}
