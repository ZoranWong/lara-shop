<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserLogin;
use App\Models\MiniProgramUser;
use App\Models\Role;
use App\Models\User;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use Illuminate\Http\Response;
use App\Http\Requests\Api\StoreOwnerLogin;
class WechatAuthController extends Controller
{
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
        $openId     = $session['open_id'];
        $sessionKey = $session['session_key'];
        $expireIn   = time() + config('auth.token.ttl');
        $storeOwner = MiniProgramUser::findByOpenId($openId);
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
                $storeOwner =  new MiniProgramUser();
                $storeOwner['open_id']     = $openId;
                $storeOwner['session_key'] = $sessionKey;
                $storeOwner['expire_in']   = $expireIn;
                $user->miniProgramUser()->save($storeOwner);
            }else{
                $user = $storeOwner->user;
                $storeOwner['open_id']     = $openId;
                $storeOwner['session_key'] = $sessionKey;
                $storeOwner['expire_in']   = $expireIn;
                $storeOwner->save();
            }
            \Auth::guard()->login($user);
            $token = $user->getToken();
            return \Response::api(['token' => $token, 'expire_in' => $expireIn]);
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function userLogin(UserLogin $request, MiniProgram $miniProgram)
    {
        $code       = $request->input('code', null);
        $nickname   = $request->input('nickname', null);
        $sex        = User::SEX[$request->input('sex', 0)];
        $headImageUrl = $request->input('avatar', null);
        $mobile     = $request->input('mobile', null);
        $session    = $miniProgram->auth->session($code);
        $openId     = $session['open_id'];
        $sessionKey = $session['session_key'];
        $expireIn   = time() + config('auth.token.ttl');
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
                $role = Role::where('name', 'user')->first(['id']);
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
            \Auth::guard()->login($user);
            $token = $user->getToken();
            return \Response::api(['token' => $token, 'expire_in' => $expireIn]);
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    public function logout()
    {

    }
}