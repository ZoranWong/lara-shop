<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2018/3/6
 * Time: 下午2:20
 */

namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\Distribution\Member;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @var Store
     * */
    protected $store = null;

    public function __construct()
    {
        $this->store = StoreService::getCurrentStore();
    }


    public function membersList(Request $request)
    {
        $queryParams = $request->all();
        $name    = array_get($queryParams,'full_name');
        $mobile    = array_get($queryParams,'mobile');
        $nickname = array_get($queryParams,'nickname');
        $father_nickname = array_get($queryParams,'father_nickname');
        $levelId = array_get($queryParams, 'level_id');
        $join_time_start    = array_get($queryParams,'join_time_start');
        $join_time_end    = array_get($queryParams,'join_time_end');
        $apply_status    = array_get($queryParams,'apply_status');
        $sort   = array_get($queryParams,'sort','id');
        $order  = array_get($queryParams,'order','DESC');
        $offset = array_get($queryParams,'offset',0);
        $limit  = array_get($queryParams,'limit',10);
        $storeId = $this->store->id;

        $where = [];
        if( $name ) {
            $where[] = ['full_name', 'like', '%'. htmlspecialchars($name) . '%'];
        }
        if( $mobile ) {
            $where[] = ['mobile', 'like', '%'. $mobile . '%'];
        }
        if( $join_time_start ) {
            $where[] = ['join_time', '>', strtotime($join_time_start)];
        }
        if( $join_time_end ) {
            $where[] = ['join_time', '<', strtotime($join_time_end)];
        }
        if( $levelId ) {
            $where[] = ['level_id', $levelId];
        }
        $modelObj = Member::with('commissionLevel')
            ->where($where)->where('store_id', $storeId);
        if( $nickname ) {   //昵称搜索
            $fansId = User::where([
                ['nickname','like','%'. htmlspecialchars($nickname) . '%']
            ])->pluck('id');
            $modelObj->whereIn('user_id', $fansId);
        }
        if( $father_nickname ) {   //推荐人搜索
            $fansId = User::where([
                ['nickname','like','%'. htmlspecialchars($father_nickname) . '%'],
            ])->pluck('id');
            $modelObj->whereIn('father_id', $fansId);
        }
        if( isset($apply_status) ) {
            $applyStatusList = explode(',', $apply_status);
            $modelObj->whereIn('apply_status', $applyStatusList);
        }

        $fatherId = 'father_id';
        $grandFatherId = 'grand_father_id';
        $greatGrandFatherId = 'great_grand_father_id';

        $data['total'] = $modelObj ->count();
        $data['rows'] = $modelObj->orderBy($sort, $order)->offset($offset)
            ->limit($limit)->get()->map(function (Member $item) use ( $storeId, $fatherId, $grandFatherId, $greatGrandFatherId) {
                $item->levelName = $item->level->name;
                $fans = $item->user_id;
                unset($item->level);
                //销售额：自购及下级的佣金状态为已结算+未结算的订单的不含邮费的金额
                $fansIdList = Member::where('store_id', $storeId)
                    ->where('user_id', '>', 0)
                    ->where('user_id', $item->user_id)
                    ->orWhere('father_id', $item->user_id)
                    ->orWhere('grand_father_id', $item->user_id)
                    ->orWhere('great_grand_father_id', $item->user_id)
                    ->pluck('user_id');

                $result = Order::whereIn('buy_user_id', $fansIdList)
                    ->select(\DB::raw('SUM(payment_fee) as totalPrice, SUM(refunded_fee) as refundPrice'))
                    ->first();

                //  下级人数
                $lower = Member::where('store_id', $storeId)
                    ->where(function(Builder $q) use ($fans, $fatherId, $grandFatherId, $greatGrandFatherId){
                    $q->orWhere($fatherId, $fans)
                        ->orWhere($grandFatherId, $fans)
                        ->orWhere($greatGrandFatherId, $fans);
                })->select(\DB::raw('COUNT(id) as lower'))->first();

                //  下级人数 按照层级对应展示
                $item->lower = $lower->lower;
                $salesAmount = ($result->totalPrice > $result->refundPrice) ? $result->totalPrice - $result->refundPrice : 0;
                $item->sales_amount = "¥ " . number_format($salesAmount, 2);
                return $item;
            });
        $data['params'] = $request->fullUrl();
        $data['rows'] = Member::setUserDetailTo($data['rows']);
        return \Response::ajax($data);
    }


    public function update (Request $request,$id)
    {
        try{
            $result = Member::where('user_id', $id)
                ->first();
            if(!$result) {
                return \Response::errorAjax('该分销商不存在', 404);
            }
            $fields = [
                'full_name'   => 'required|max:255',
                'wechat'      => 'required|max:255|regex:/^[a-zA-Z\d_]{5,}$/',
                'mobile'      => 'required|mobile',
                'is_active'   => 'nullable|between:0,1',
                'select'      => 'nullable|between:0,1',
                'ancestor_id' => 'nullable|numeric'
            ];
            $message = array(
                "required"     => ":attribute 不能为空",
                "between"      => ":attribute 数值必须在 :min 和 :max 之间",
                "numeric"      => ":attribute 数值必须是数字",
                "mobile"       => ":attribute 字段必须为11位数字的合法手机号",
                "regex"        => ":attribute 不合法"
            );

            $attributes = array(
                "full_name" => '姓名',
                'wechat' => '微信号',
                'mobile' => '手机号',
            );
            $data = $this->validate($request, $fields, $message, $attributes);

            $result->full_name = $data['full_name'];
            $result->wechat = $data['wechat'];
            $result->mobile = $data['mobile'];
            if(isset($data['is_active'])){
                $result->is_active = $data['is_active'];
            }
            if(isset($data['select'])){ // 变更上级
                if($result->father_id) {
                    $father = Member::where('user_id', $result->father_id)->first();
                    if($father && $father->user_id){
                        $father->total_subordinate_num = $father->total_subordinate_num - 1;
                        $father->referrals = $father->referrals - 1;
                        $father->save();
                    }
                }
                if($result->grand_father_id) {
                    $gfather = Member::where('user_id', $result->grand_father_id)->first();
                    if($gfather && $gfather->user_id){
                        $gfather->total_subordinate_num = $gfather->total_subordinate_num - 1;
                        $gfather->referrals = $gfather->referrals - 1;
                        $gfather->save();
                    }
                }
                if($result->great_grand_father_id){
                    $ggfather = Member::where('user_id', $result->great_grand_father_id)->first();
                    if($ggfather && $ggfather->user_id){
                        $ggfather->total_subordinate_num = $ggfather->total_subordinate_num - 1;
                        $ggfather->referrals = $ggfather->referrals - 1;
                        $ggfather->save();
                    }
                }
                $isHasChilds = Member::where('father_id', $id)->first();
                if($isHasChilds) {  // 存在下级,抛出异常错误信息
                    return \Response::errorAjax("存在下级分销商，不能进行分销商等级变更",406);
                }
                //不存在,正常执行
                if($data['select']== 1 && $data['ancestor_id']) {  // 变更指定上级
                    $ancestorObj = Member::where('user_id', $data['ancestor_id'])->first();
                    if(!$ancestorObj) {  // 不存在指定上级,抛出异常错误信息
                        return \Response::errorAjax("指定上级分销商不存在",404);
                    }
                    $ancestorObj->total_subordinate_num += 1;
                    $ancestorObj->referrals += 1;
                    $ancestorObj->save();
                    if($ancestorObj->father_id) {
                        $faObj = Member::where('user_id', $ancestorObj->father_id)->first();
                        if($faObj){
                            $faObj->total_subordinate_num += 1;
                            $faObj->referrals += 1;
                            $faObj->save();
                        }
                    }
                    if($ancestorObj->grand_father_id) {
                        $gfObj = Member::where('user_id', $ancestorObj->grand_father_id)->first();
                        if($gfObj){
                            $gfObj->total_subordinate_num += 1;
                            $gfObj->referrals += 1;
                            $gfObj->save();
                        }
                    }

                    $result->father_id = $data['ancestor_id'];
                    $result->grand_father_id = $ancestorObj->father_id;
                    $result->great_grand_father_id = $ancestorObj->grand_father_id;
                    $result->depth = $ancestorObj->depth + 1;
                    $result->path = $ancestorObj->path . '-' . $id;

                } else if($data['select'] == 0) {  // 变更到总部
                    $result->father_id = 0;
                    $result->grand_father_id = 0;
                    $result->great_grand_father_id = 0;
                    $result->depth = 1;
                    $result->path = $id;

                }
            }
            $result->save();
            return \Response::ajax($result);
        } catch (\Exception $e) {
            return \Response::errorAjax($e->getMessage());
        }
    }

    // 分销商批量操作
    public function batch(Request $request)
    {
        $fansIdList = $request->input('user_id');

        $storeId = $request->input('store_id', null);

        $apply_status = $request->input('status');

        $result = Member::where('store_id', $storeId)
            ->whereIn('user_id', $fansIdList)
            ->select(['father_id','grand_father_id','great_grand_father_id'])
            ->get();
        $idList = [];
        $res = $result->flatMap(function ($item) use ($idList) {
            array_push($idList, $item->father_id, $item->grand_father_id, $item->great_grand_father_id);
            return $idList;
        });
        $res = array_count_values($res->all());
        if($res) {
            foreach($res as $key => $value) {
                Member::where('store_id', $storeId)
                    ->where('user_id', $key)
                    ->increment('total_subordinate_num', $value);
            }
        }
        $currentTime = time();
        $data = ['apply_status' => $apply_status,'join_time' => $currentTime];

        $returnValue = Member::whereIn('user_id', $fansIdList)->update($data);

        return \Response::ajax($returnValue);
    }
}