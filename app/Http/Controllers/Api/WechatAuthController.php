<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserLogin;
use App\Http\Requests\GuiderRequest;
use App\Http\Requests\TravellerRequest;
use App\Models\MiniProgramUser;
use App\Models\Role;
use App\Models\StoreManager;
use App\Models\StoreOwner;
use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use Illuminate\Http\Response;
use App\Http\Requests\Api\StoreManagerLogin;
use App\Http\Requests\Api\StoreOwnerLogin;
class WechatAuthController extends Controller
{

    use AuthenticatesWechat;
    /**
     * 旅游定制师登录个人店铺接口
     * */
    public function storeOwnerLogin(StoreOwnerLogin $request, MiniProgram $miniProgram) : Response
    {
        $code       = $request->input('code', null);
        $nickname   = $request->input('nickname', null);
        $sex        = User::SEX[$request->input('sex', 0)];
        $headImageUrl = $request->input('avatar', null);
        $mobile     = $request->input('mobile', null);
        $session    = $miniProgram->auth->session($code);
        $token = $miniProgram->auth->getAccessToken();
        $openId     = $session['open_id'];
        $sessionKey = $session['session_key'];
        $expireIn   = $session['expire_in'];
        $storeOwner = StoreOwner::findByOpenId($openId);
        \DB::beginTransaction();
        try{
            if(!$storeOwner){
                $user = User::create([
                    'nickname' => $nickname,
                    'sex'      => $sex,
                    'head_image_url' => $headImageUrl,
                    'mobile'    => $mobile,
                    'password'  => bcrypt($mobile)
                ]);
                $role = Role::where('name', 'store.owner')->first(['id']);
                $user->roles()->sync([$role['id']]);
                $storeOwner =  new StoreOwner();
                $storeOwner['open_id']     = $openId;
                $storeOwner['session_key'] = $sessionKey;
                $storeOwner['expire_in']   = $expireIn;
                $user->owner()->save($storeOwner);
            }else{
                $user = $storeOwner->user;
                $storeOwner['open_id']     = $openId;
                $storeOwner['session_key'] = $sessionKey;
                $storeOwner['expire_in']   = $expireIn;
                $storeOwner->save();

            }
            Token::create([
                'user_id' => $user['id'],
                'token' => $token,
                'expire_in' => $expireIn
            ]);
            return response()->api(['token' => $token, 'expire_in' => $expireIn]);
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function travellerLogin(UserLogin $request, MiniProgram $miniProgram)
    {
        $code       = $request->input('code', null);
        $nickname   = $request->input('nickname', null);
        $sex        = User::SEX[$request->input('sex', 0)];
        $headImageUrl = $request->input('avatar', null);
        $mobile     = $request->input('mobile', null);
        $session    = $miniProgram->auth->session($code);
        $token = $miniProgram->auth->getAccessToken();
        $openId     = $session['open_id'];
        $sessionKey = $session['session_key'];
        $expireIn   = $session['expire_in'];
        $miniProgramUser = MiniProgramUser::findByOpenId($openId);
        \DB::beginTransaction();
        try{
            if(!$miniProgramUser){
                $user = User::create([
                    'nickname' => $nickname,
                    'sex'      => $sex,
                    'head_image_url' => $headImageUrl,
                    'mobile'    => $mobile,
                    'password'  => bcrypt($mobile)
                ]);
                $role = Role::where('name', 'store.owner')->first(['id']);
                $user->roles()->sync([$role['id']]);
                $miniProgramUser =  new MiniProgramUser();
                $miniProgramUser['open_id']     = $openId;
                $miniProgramUser['session_key'] = $sessionKey;
                $miniProgramUser['expire_in']   = $expireIn;
                $user->owner()->save($miniProgramUser);
            }else{
                $user = $miniProgramUser->user;
                $miniProgramUser['open_id']     = $openId;
                $miniProgramUser['session_key'] = $sessionKey;
                $miniProgramUser['expire_in']   = $expireIn;
                $miniProgramUser->save();
            }
            Token::create([
                'user_id' => $user['id'],
                'token' => $token,
                'expire_in' => $expireIn
            ]);
            return response()->api(['token' => $token, 'expire_in' => $expireIn]);
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function logout()
    {

    }
}