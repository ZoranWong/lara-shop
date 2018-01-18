<?php
namespace App\Http\Controllers\Admin\Home\Manager;

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
     * @var Row
     * */
    protected $cardBox = null;

    public function __construct()
    {

        $this->content = SectionContent::content(function (Content $content){
            return $content->row(function (Row $row) {
                $this->cardBox = &$row;
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
}