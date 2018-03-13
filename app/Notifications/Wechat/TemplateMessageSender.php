<?php

namespace App\Notifications\Wechat;

use App\Channels\Messages\WechatTemplateMessage;
use App\Channels\WxMessageTemplateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class TemplateMessageSender extends Notification
{
    use Queueable;

    /**
     * @var WechatTemplateMessage
     * */
    protected $templateMessage = null;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->templateMessage = new WechatTemplateMessage();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WxMessageTemplateChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  Notifiable  $notifiable
     * @param string $driver
     * @return WechatTemplateMessage
     */
    public function toWxMsgTemplate(Notifiable $notifiable, string $driver = 'wechat')
    {
        return $this->templateMessage->setTo($notifiable->routeNotificationFor($driver));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
