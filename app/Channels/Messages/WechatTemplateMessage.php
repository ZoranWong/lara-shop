<?php
namespace App\Channels\Messages;

class WechatTemplateMessage
{
    /**
     * @var string
     * */
    protected $to = null;

    /**
     * @var string
     * */
    protected $templateId = null;

    /**
     * @var array
     * */
    protected $data = [];

    /**
     * @var string
     * */
    protected $authId = null;

    /**
     * @var string
     * */
    protected $from = null;

    /**
     * @param string $templateId
     * @return WechatTemplateMessage
     * */
    public function setTemplateId(string $templateId) : WechatTemplateMessage
    {
        $this->templateId = $templateId;
        return $this;
    }


    /**
     * @param string $authId
     * @return WechatTemplateMessage
     * */
    public function setAuthId(string $authId)
    {
        $this->authId = $authId;
        return $this;
    }

    /**
     * @param array $data
     * @return WechatTemplateMessage
     * */
    public function setMessageData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $to
     * @return WechatTemplateMessage
     * */
    public function setTo(string $to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param string $from
     * @return WechatTemplateMessage
     * */
    public function setFrom(string $from) : WechatTemplateMessage
    {
        $this->from = $from;
        return $this;
    }


    public function format()
    {
        return [
            'touser' => $this->to,
            'template_id' => $this->templateId,
            'url' => 'https://easywechat.org',
            'data' => $this->data
        ];
    }
}