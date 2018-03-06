<?php
namespace App\Http\Controllers\Admin\Distribution;

use App\Http\Controllers\Controller;
use App\Models\Distribution\CommissionCashSettings;
use App\Models\Distribution\CommissionLevel;
use App\Models\Distribution\ApplySetting;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * @var Store
     * */
    protected $store = null;

    public function __construct()
    {
        $this->store = StoreService::getCurrentStore();
    }

    public function basic(Request $request)
    {
        $input = $this->validate($request, [
            'apply_type' => ['integer', Rule::in(ApplySetting::APPLY_TYPE)],
            'info_status'  => ['integer', Rule::in(ApplySetting::INFO_STATUS)],
            'mobile_status' => ['integer', Rule::in(ApplySetting::MOBILE_STATUS)],
            'check_way'  => ['integer', Rule::in(ApplySetting::CHECK_WAY)],
            'level' => 'integer',
            'commission_days' => 'required|integer'
        ]);
        if(count($input) > 0){
            $input['store_id'] = $this->store->id;
            $setting = new ApplySetting();
            $setting->fill($input);
            $result = $setting->save();
            if($result){
                return \Response::ajax($setting);
            }else{
                return \Response::errorAjax('保存失败');
            }
        }else{
            return \Response::errorAjax('缺少必要参数');
        }
    }

    public function commission(Request $request)
    {
        $input = $this->validate($request, [
            'id'  => ['integer'],
            'name' => ['required', 'string'],
            'commission_days'  => ['required', 'integer'],
            'level' => ['required', 'integer'],
            'allocation' => ['required', 'integer', Rule::in(CommissionLevel::ALLOCATION)],
            'commission_status'  => ['required', 'integer', Rule::in(CommissionLevel::COMMISSION_STATUS)],
            'commission' => 'required|numeric|min:0',
            'father_commission' => 'required|numeric|min:0',
            'great_grand_father_commission' => 'required|numeric|min:0'
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

    public function cash(Request $request)
    {
        $input = $this->validate($request, [
            'min_cash_num' => 'required|numeric|min:0',
            'max_cash_num' => 'numeric|min:0'
        ]);

        if(count($input) > 0){
            $input['store_id'] = $this->store->id;
            $cashSetting = new CommissionCashSettings();
            $cashSetting->fill($input);
            $result = $cashSetting->save();
            if($result){
                return \Response::ajax($cashSetting);
            }else{
                return \Response::errorAjax('保存失败');
            }
        }else{
            return \Response::errorAjax('缺少必要参数');
        }
    }
}