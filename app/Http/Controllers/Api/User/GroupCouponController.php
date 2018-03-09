<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Group;
use App\Models\GroupCoupon;
use App\Models\GroupOrder;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Response;

class GroupCouponController extends Controller
{
    //
    /**
     * @throws 
     * */
    public function open($id, Request $request, OrderController $orderController) : Response
    {
        $groupCoupon = GroupCoupon::find($id);
        if(!$groupCoupon){
            return \Response::errorApi('不存在此团购活动');
        }
        if(!$this->limitValidate($groupCoupon, $request->input('num', 0))){
            return \Response::errorApi('超过限购数量');
        }
        \DB::beginTransaction();
        try{
            $order = $orderController->createOrderFromRequest($request->all());
            if($order){
                $time = time();
                $group = new Group();
                $this->createGroup($group, $groupCoupon, $time);
                $groupOrder = new GroupOrder();
                $this->createGroupOrder($group, $groupOrder, $order);
            }else{
                return \Response::errorApi('团购订单创建失败');
            }
            \DB::commit();
            return \Response::api($group);
        }catch (\Exception $exception){
            \DB::rollBack();
            return \Response::errorApi('团购订单创建失败');
        }
    }

    protected function createGroup(Group &$group, GroupCoupon &$groupCoupon, int $time)
    {
        $group->group_coupon_code = $groupCoupon->code;
        $group->leader_user_id = $this->user()->id;
        $group->cancel = null;
        $group->opened_at = $time;
        $group->auto_cancel_at = $this->groupAutoCancelTime();
        $group->remaining_num = $groupCoupon->member_num;
        $group->status = Group::STATUS['OPENING'];
        $group->oldStatus = null;
        $groupCoupon->groups()->save($group);
    }

    protected function createGroupOrder(Group &$group, GroupOrder &$groupOrder, Order &$order)
    {
        $groupOrder->group_code = $group->code;
        $groupOrder->group_coupon_code = $group->group_coupon_code;
        $groupOrder->group_coupon_id = $group->group_coupon_id;
        $groupOrder->order_code = $order->code;
        $groupOrder->order_id = $order->id;
        $groupOrder->oldStatus = null;
        $groupOrder->status = GroupOrder::STATUS['WAIT_PAY'];
        $groupOrder->buyer_user_id = $this->user()->id;
        $groupOrder->auto_cancel_at = $this->groupOrderAutoCancelTime();
        $groupOrder->cancel = null;
        $group->groupOrders()->save($groupOrder);
    }

    protected function groupOrderAutoCancelTime() : int
    {
        $time = time();
        return $time + config('group.order.expires_at');
    }

    protected function groupAutoCancelTime() : int
    {
        $time = time();
        return $time + config('group.expires_at');
    }


    public function join($groupId, Request $request) : Response
    {
        $group = Group::with('groupCoupon')->find($groupId);
        if(!$group){
            return \Response::errorApi('超过限购数量');
        }else{
            if($this->limitValidate($group->groupCoupon, $request->input('num', 0))){
                return \Response::errorApi('');
            }
            return \Response::api();
        }
    }

    protected function limitValidate(GroupCoupon $groupCoupon, int $num) : bool
    {
        $groupCoupon['order_num'] = $num;
        $groupCoupon->groupOrders()->whereIn('status', [GroupOrder::STATUS['PATCHING'],
            GroupOrder::STATUS['PATCHED'], GroupOrder::STATUS['SEND'], GroupOrder::STATUS['COMPLETE']])
            ->with('order')->get()->map(function (GroupOrder $groupOrder) use(&$groupCoupon){
                $groupCoupon['order_num'] += $groupOrder->order->num;
            });
        if($groupCoupon['order_num'] > $groupCoupon->buy_limit_num){
            return false;
        }
        return true;
    }
}
