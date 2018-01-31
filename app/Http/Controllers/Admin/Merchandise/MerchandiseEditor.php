<?php
namespace App\Http\Controllers\Admin\Merchandise;

use App\Models\Category;
use App\Models\Merchandise;
use App\Models\Store;
use App\Renders\Facades\SectionContent;
use App\Renders\Widgets\Widget;
use App\Services\StoreService;
use Illuminate\Contracts\Support\Renderable;

class MerchandiseEditor extends Widget implements Renderable
{
    protected $merchandise = null;
    protected $view = 'store.merchandise.form';

    public function __construct($merchandise ,$attributes = [])
    {
        $this->merchandise = $merchandise;
        parent::__construct($attributes);
        SectionContent::jsLoad(['','']);
    }

    public function render()
    {
        // TODO: Implement render() method.
        if($this->merchandise){
            $this->merchandise['images'] = $this->merchandise['images'] ? $this->merchandise['images']: [];
            if($this->merchandise['images']){
                $images = [];
                foreach ($this->merchandise['images'] as $url){
                    $images[] = ['url' => $url];
                }
                $this->merchandise['images'] = $images;
            }
            $this->merchandise['sell_price'] = (string)$this->merchandise['sell_price'];
        }
        return view($this->view)->with([
            'merchandise' => $this->merchandise,
            'categories' =>  Category::all(),
            'host' => \Request::getSchemeAndHttpHost(),
            'storeId' => StoreService::getCurrentID(),
            'stores'  => Store::where('status', Store::STATUS['PASS'])->get(['id', 'name']),
            'method'  => $this->merchandise ? "put" : "post",
            'url'     => $this->merchandise ? "/ajax/merchandise/{$this->merchandise['id']}" : '/ajax/merchandise'
        ]);
    }
}