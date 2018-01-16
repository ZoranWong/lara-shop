<?php
namespace App\Http\Controllers\Api;

use App\Http\Requests\GuiderRequest;
use App\Http\Requests\TravellerRequest;
use App\Models\StoreOwner;
use App\Models\Token;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class WechatAuthController extends Controller
{

    use AuthenticatesWechat;
    /**
     * 旅游定制师登录个人店铺接口
     * */
    public function guiderLogin(GuiderRequest $request, MiniProgram $miniProgram) : Response
    {
        $code       = $request->input('code', null);
        $session    = $miniProgram->auth->session($code);
        $openId     = $session['open_id'];
        $sessionKey = $session['session_key'];
        $expireIn   = $session['expire_in'];
        $storeOwner = StoreOwner::findByOpenId($openId);
        if(!$storeOwner){
            return response()->errorApi('微信登录失败！');
        }else{
            $user = $this->guard()->user();
            $storeOwner = $storeOwner ?? new StoreOwner();
            $storeOwner['open_id']     = $openId;
            $storeOwner['session_key'] = $sessionKey;
            $storeOwner['expire_in']   = $expireIn;
            $user->storeOwner()->save($storeOwner);
            $token  = bcrypt($openId, ['open_id' => $openId, 'session_key' => $sessionKey, 'expire_in' => $expireIn]);
            Token::create([
                'user_id' => $user['id'],
                'token' => $token,
                'expire_in' => $expireIn
            ]);
        }
        return response()->api(['token' => $token]);
    }

    public function travellerLogin(TravellerRequest $request, MiniProgram $miniProgram)
    {
        $code       = $request->input('code', null);
        $session    = $miniProgram->auth->session($code);
        $openId     = $session['open_id'];
        $sessionKey = $session['session_key'];
        $expireIn   = $session['expire_in'];
        $result = $this->guard()->attempt(['open_id' => $openId]);
        if(!$result){
            return response()->errorApi('微信登录失败！');
        }else{
            $token  = bcrypt($openId, ['open_id' => $openId, 'session_key' => $sessionKey, 'expire_in' => $expireIn]);
        }
        return response()->api(['token' => $token]);
    }

    public function logout()
    {

    }
}