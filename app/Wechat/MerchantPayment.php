<?php
namespace App\Wechat;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @property $openid
 * @property $partner_trade_no // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
 *@property  $check_name, // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
 *@property  $re_user_name // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
 *@property $amount, // 企业付款金额，单位为分
 *@property $desc, // 企业付款操作说明信息。必填
 * */
class MerchantPayment implements Arrayable, \ArrayAccess, \IteratorAggregate
{
    private $array;

    public function __construct(array $array = [])
    {
        $this->array = $array;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->array[$name];
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        return $this->array[$name] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->array);
    }

    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->array[] = $value;
        } else {
            $this->array[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
        return $this->array;
    }
}