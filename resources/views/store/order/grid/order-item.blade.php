@foreach($orderItems as $item)
    <tr bgcolor="{{$color}}">
        <td style="text-align:left;">
            <img src="{{$item['merchandise_main_image_url']}}" style="width:80px;height:80px;border-radius: 15%;margin-left:50px;" onerror="">
            <span style="width:215px; height:80px;  position:absolute; padding-top:5px; text-align:center; font-size:13px; overflow:hidden;">
            <span style="width: 200px;height: 35px;line-height: 17px;overflow: hidden;position: absolute;left: 15px;cursor:pointer" title="{{$item['name']}}">
                {{$item['name']}}
            </span>
            <span style="height:30px;overflow:hidden;position: absolute;top: 40px;line-height:  15px;left: 20px;right: 7px; cursor:pointer" title="">
            </span>
        </span>
            <span style="position: absolute;margin-left: 225px;margin-top: 10px;text-align: center;width: 80px;height: 60px;padding-top: 17px;">
            ¥ {{$item['price']}}  (&nbsp;X {{$item['num']}}&nbsp;)
        </span>
        </td>
        <td style="vertical-align: middle">
            {{--退款处理项--}}
            {{--@switch($item['refund']['status'])--}}
                {{--@case ()--}}
            {{--@endswitch--}}
        </td>
        <td rowspan="1" style="vertical-align: middle">
            {{$item['nickname']}}}
            <br>
            {{--{{$item['receiver_mobile']}}--}}
        </td>
        <td rowspan="1" style="vertical-align: middle">2018-01-19 13:28:20</td>
        <td rowspan="1" style="vertical-align: middle">{{\App\Models\OrderItem::STATUS_ZH_CN[$item['status']]}}</td>
        <td rowspan="1" style="vertical-align: middle"> ¥ {{$item['total_fee']}}</td>
    </tr>
@endforeach