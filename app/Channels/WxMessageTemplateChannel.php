<?php
namespace App\Channels;

use App\Notifications\Wechat\TemplateMessageSender;
use EasyWeChat\MiniProgram\TemplateMessage\Client;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class WxMessageTemplateChannel
{

    /**
     * @var Client
     * */
    protected $templateMessageClient = null;

    /**
     * Create a new mail channel instance.
     *
     * @param  Client  $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->templateMessageClient = $client;

    }

    /**
     * 发送给定通知
     * @param  Notifiable  $notifiable
     * @param  TemplateMessageSender $notification
     * @return void
     * @throws
     */
    public function send(Notifiable $notifiable, TemplateMessageSender $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('wechat')) {
            return;
        }
        $data = $notification->toWxMsgTemplate($notifiable);

        // 将通知发送给 $notifiable 实例
        $this->templateMessageClient->send($data);
        return ;
    }
}