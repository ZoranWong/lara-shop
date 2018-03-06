<?php

namespace App\Http\Controllers\Admin\GroupCoupon;

use App\Models\GroupCoupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController as Controller;

class GroupCouponController extends Controller
{
    //
    public function __construct(Page $page)
    {
        $this->page = $page;
        $page->setModel(GroupCoupon::class);
        parent::__construct(function (){
            return [

            ];
        });
    }

    public function ajaxStore(Request $request)
    {
        $data = $request->all();
        $data['min_price'] = 0;
        $data['max_price'] = 0;
        $data['min_leader_price'] = 0 ;
        $data['max_leader_price']  = 0;
        if(isset($data['products_array'])){
            foreach ($data['products_array'] as $item){
                if($item['price'] < $data['min_price'] || $data['min_price'] == 0){
                    $data['min_price'] = $item['price'];
                }
                if($item['price'] > $data['max_price'] ){
                    $data['max_price'] = $item['price'];
                }

                if(isset($data['leader_prefer']) && $data['leader_prefer'] && isset($item['leader_price']) && $item['leader_price'] < $data['min_leader_price'] || $data['min_leader_price'] == 0){
                    $data['min_leader_price'] = $item['leader_price'];
                }

                if(isset($data['leader_prefer']) && $data['leader_prefer'] && isset($item['leader_price']) && $item['leader_price'] > $data['max_leader_price'] ){
                    $data['max_leader_price'] = $item['leader_price'];
                }
            }
        }else{
            $data['products_array'] = [];
        }
        $groupCoupon = GroupCoupon::create($data);
        return \Response::ajax($groupCoupon);
    }

    public function ajaxUpdate($id , Request $request)
    {
        $data = $request->all();
        $data['min_price'] = 0;
        $data['max_price'] = 0;
        $data['min_leader_price'] = 0 ;
        $data['max_leader_price']  = 0;
        if(isset($data['products_array'])){
            foreach ($data['products_array'] as $item){
                if($item['price'] < $data['min_price'] || $data['min_price'] == 0){
                    $data['min_price'] = $item['price'];
                }
                if($item['price'] > $data['max_price'] ){
                    $data['max_price'] = $item['price'];
                }

                if(isset($data['leader_prefer']) && $data['leader_prefer'] && isset($item['leader_price']) && $item['leader_price'] < $data['min_leader_price'] || $data['min_leader_price'] == 0){
                    $data['min_leader_price'] = $item['leader_price'];
                }

                if(isset($data['leader_prefer']) && $data['leader_prefer'] && isset($item['leader_price']) && $item['leader_price'] > $data['max_leader_price'] ){
                    $data['max_leader_price'] = $item['leader_price'];
                }
            }
        }else{
            $data['products_array'] = [];
        }
        $groupCoupon = GroupCoupon::find($id);
        $groupCoupon->update($data);
        return \Response::ajax($groupCoupon);
    }
}
