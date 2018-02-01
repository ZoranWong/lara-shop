<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Merchandise;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class ShoppingCartController extends Controller
{
    //

    public function list()
    {
        $query = ShoppingCart::with(['merchandise', 'product']);
        return response()->api($this->buildList($query));
    }

    public function setNum(int $id, int $num){
        if($num > 0){
            $shoppingCart = ShoppingCart::find($id);
            if($shoppingCart){
                $shoppingCart->num += $num;
                $result = $shoppingCart->save();
                if($result){
                    return response()->api('购买数量修改成功');
                }else{
                    return response()->errorApi('购买数量修改失败');
                }

            }else{
                return response()->errorApi('购物车没有对于的产品');
            }

        }else{
            return response()->errorApi('购买数量必须大于0');
        }
    }

    public function add(Request $request)
    {
        $merchandiseId = $request->input('merchandise_id', null);
        $productId = $request->input('product_id', null);
        $num = $request->input('num', null);

        $data['buyer_user_id'] = $this->user()->id;
        if($num <= 0){
            return response()->errorApi('请填写购买数量！');
        }
        if(!$merchandiseId)
        {
            return response()->errorApi('此商品不存在！');
        }

        $where['merchandise_id'] = $merchandiseId;
        if($productId){
            $where['product_id'] = $productId;
        }
        $merchandise = Merchandise::find($merchandiseId);
        if(!$merchandise){
            return response()->errorApi('购买产品不存在！');
        }

        if($merchandise->products()->count() > 0 && !$productId){
            return response()->errorApi('请选择规格产品！');
        }
        $price = $merchandise->sell_price;
        $product = null;
        if($productId)
        {
            $product = $merchandise->products()->find($productId);
            if(!$product){
                return response()->errorApi('购买的规格产品不存在');
            }elseif ($product->stock_num < $num){
                return response()->errorApi('规格产品库存不足');
            }
        }
        $shoppingCart = ShoppingCart::searchBy($where)->first();
        if($shoppingCart){
            if($merchandise->stock_num < $num){
                return response()->errorApi('商品库存不足');
            }
            $shoppingCart->num += $num;
            $shoppingCart->total_fee += $shoppingCart->price * $num;
            $result = $shoppingCart->save();
            if(!$result){
                return response()->errorApi('购物车商品添加失败');
            }else{
                return response()->api($shoppingCart);
            }

        }



        $data['store_id'] = $merchandise->store_id;
        $data['store_code'] = $merchandise->store_code;
        $data['name'] = $merchandise->name;
        $data['merchandise_main_image_url'] = $merchandise->main_image_url;
        if($product){
            $data['product_id']   = $productId;
            $data['product_code'] = $product['code'];
            if($product['spec_array']){
                $data['sku_properties_name'] = '';
                foreach ($product['spec_array'] as $item){
                    $data['sku_properties_name'] .= "{$item['name']}:{$item['value']};";
                }
            }
            $price = $product['sell_price'];
        }
        $totalFee = $price * $num;
        $data['merchandise_id']   = $merchandise['id'];
        $data['merchandise_code'] = $merchandise['code'];
        $data['price'] = $price;
        $data['num'] = $num;
        $data['total_fee'] = $totalFee;
        $shoppingCart = ShoppingCart::create($data);
        return response()->api($shoppingCart);
    }

    public function remove($ids)
    {
        $ids = explode(',', $ids);
        \DB::beginTransaction();
        try{
            ShoppingCart::destroy($ids);
            \DB::commit();
            return response()->api('删除成功');
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->errorApi('删除失败');
        }
    }
}
