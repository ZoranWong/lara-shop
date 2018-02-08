<?php
namespace App\Http\Controllers\Admin\GroupCoupon;

use App\Models\GroupCoupon;
use App\Models\Product;
use App\Renders\Facades\SectionContent;
use App\Renders\Form;
use Illuminate\Contracts\Support\Renderable;

class Editor extends Form implements Renderable
{
    protected $view = 'store.group_coupon.editor';

    protected $id = null;
    protected $title = '创建团购活动';
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
        //SectionContent::jsLoad(asset('/bower_components/bootstrap-validator/dist/validator.js'));
        parent::__construct(GroupCoupon::class, function (){

        });
    }

    public function render()
    {
        $groupCoupon = GroupCoupon::with(['merchandise.products'])->find($this->id);
        $products = null;
        if($groupCoupon && $groupCoupon['merchandise']['products']){
            $products = [];
            $products_array = [];
            foreach ($groupCoupon->products_array as $item){
                $products_array[$item['id']] = $item;
            }
            $groupCoupon->merchandise->products->map(function (Product $product) use (&$products_array, &$products){
                $tmp['sku'] = "";
                foreach ($product->spec_array as $item){
                    $tmp['sku'] .= $item['name'].":".$item['value'].';';
                }

                $tmp['stock_num'] = $product->stock_num;
                $tmp['leader_price'] = isset($products_array[$product->id]['leader_price']) ?
                    sprintf('%.2f', $products_array[$product->id]['leader_price']) : null;
                $tmp['price'] = sprintf('%.2f', $products_array[$product->id]['price']);
                $tmp['sell_price'] = sprintf('%.2f', $product->sell_price);
                $tmp['id'] = $product->id;
                $products[] = $tmp;
            });
        }

        if($groupCoupon){
            $groupCoupon['merchandise']['price'] = sprintf('%.2f', $groupCoupon->price);
            $groupCoupon['merchandise']['sell_price'] = sprintf('%.2f', $groupCoupon['merchandise']['sell_price']);
        }
        //$groupCoupon['merchandise']['products'] = $products;
        // TODO: Implement render() method.
        return view($this->view)->with([
            'id' => $this->id,
            'title' => $this->title,
            'groupCoupon' => $groupCoupon ? $groupCoupon : null,
            'products' => json_encode($products),
            'merchandise' => $groupCoupon ? $groupCoupon['merchandise'] : 'null'
        ]);
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->render()->render();
    }
}