<?php
namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\Distribution\CommissionLevel;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommissionController extends Controller
{
    /**
     * @var Store
     * */
    protected $store = null;

    public function __construct()
    {
        $this->store = StoreService::getCurrentStore();
    }

    public function commissionSetting()
    {

    }

    //分销等级编辑
    public function distributionCommissionLevelEdit(Request $request)
    {
        $storeId = StoreService::getCurrentID();
        $where['store_id'] = $storeId;
        $queryParams = $request->all();
        $id = array_get($queryParams, 'id');
        if( $id ){
            $data = CommissionLevel::where('store_id', $storeId)
				->where('id', $id)
				->get(['level', 'commission_status']);
            return \Response::ajax($data);
        } else {
            return \Response::ajax([
				'level' => CommissionLevel::where('store_id', $storeId)->max('level') + 1,
				'commission_status' => 0
			]);
        }
    }

    public function levels(int $storeId)
    {
        $levels = CommissionLevel::whereStoreId($storeId)->get(['level', 'name']);

        return \Response::ajax($levels);
    }

    public function saveCommissionLevel(Request $request)
    {
        $input = $this->validate($request, [
            'id'  => ['integer'],
            'name' => [
				'required', 
				'string', 
				Rule::unique('commission_level', 'name')
				],
            'level' => ['required', 'integer'],
            'upgrade_type' => [
				'required', 
				'integer'
				],
            'reach_amount' => 'numeric|min:0',
            'allocation'  => [ 
				'integer', 
				Rule::in(CommissionLevel::ALLOCATION)
				],
            'commission_status' => [
				'integer', 
				Rule::in(CommissionLevel::COMMISSION_STATUS)
				],
            'commission' => [
				'required',
				'numeric',
				'min:0'
				],
            'father_commission' => [
				'required',
				'numeric',
				'min:0'
				],
            'great_grand_father_commission' => [
				'required',
				'numeric',
				'min:0'
				]
        ]);
        if(count($input) > 0){
            $input['store_id'] = $this->store->id;
            $level = new CommissionLevel();
            $level->fill($input);
            $result = $level->save();
            if($result){
                return \Response::ajax($level);
            }else{
                return \Response::errorAjax('保存失败');
            }
        }else{
            return \Response::errorAjax('缺少必要参数');
        }
    }

    public function commissionLevelList(Request $request)
    {
        $list = CommissionLevel::all();

        return \Response::ajax($list);
    }
}
