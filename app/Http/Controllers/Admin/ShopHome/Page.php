<?php
namespace App\Http\Controllers\Admin\ShopHome;

use App\Http\Controllers\Admin\Common\BasePage;
use App\Models\Order;
use App\Models\OrderCount;
use App\Renders\Facades\SectionContent;
use App\Renders\Layout\Column;
use App\Renders\Layout\Content;
use App\Renders\Layout\Row;
use App\Renders\Widgets\Card;
use App\Services\StoreService;

class Page extends BasePage
{
    /**
     * @var array $cards
     * */
    protected $cards = [];
    /**
     * @var array $task
     * */
    protected $task = [];

    /**
     * @var Row
     * */
    protected $cardBox = null;

    /**
     * @var Row
     * */
    protected $taskBox = null;

    /**
     * @var Row
     * */
    protected $wxAuthBox = null;

    /**
     * @var Row
     * */
    protected $managerBox = null;
    /**
     * @var Row
     * */
    protected $taskAndWxAuthBox = null;

    public function __construct()
    {

        $this->content = SectionContent::content(function (Content $content){
            $this->css = new Css();
            $this->js = new JavaScript();
            return $content->row(function (Row $row) {
                $this->cardBox = &$row;
            })->row(function (Row $row){
                $this->taskAndWxAuthBox = &$row;
            });
        });

        parent::__construct();
    }

    /**
     * @var array $cards
     * @return Page
     * */
    public function cards(array $cards = null) : Page
    {
        if($cards){
            $this->cards = $cards;
        }
        foreach ($this->cards as $card){
            $this->cardBox->column(['md' => 3, 'sm' => 6, 'xs' => 6], new Card($card));
        }
        return $this;
    }

    /**
     * @var array $cards
     * @return Page
     * */
    public function taskAndWxAuth(array $task = null) : Page
    {
        if($task){
            $this->task = $task;
        }
        $this->taskAndWxAuthBox->column(['md'=>4, 'sm' => 12], function(Column $column){
            $column->row(function (Row $row) {
                $row->column(['md'=> 12, 'sm' => 12], new Task($this->task));
            });
            $column->row(function (Row $row){
                $row->column(['md'=>12, 'sm' => 12], new WxAuthQrCode());
            });
        });
        return $this;
    }

    public function managerBox(array $data = []) : Page
    {
        $this->taskAndWxAuthBox->column(['md' => 8, 'sm' => 12], function (Column $column) use($data){
            $column->row(function (Row $row) use($data){
                $row->height(100);
                $row->column(12, view('shop.home.manager_card', $data));
            });
        });

        return $this;
    }
}