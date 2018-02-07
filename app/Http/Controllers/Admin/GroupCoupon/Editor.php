<?php
namespace App\Http\Controllers\Admin\GroupCoupon;

use App\Models\GroupCoupon;
use App\Renders\Facades\SectionContent;
use App\Renders\Form;
use Illuminate\Contracts\Support\Renderable;

class Editor extends Form implements Renderable
{
    protected $view = 'store.group_coupon.editor';

    protected $id = null;
    protected $title = '创建团购活动';
    public function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
        //SectionContent::jsLoad(asset('/bower_components/bootstrap-validator/dist/validator.js'));
        parent::__construct(GroupCoupon::class, function (){

        });
    }

    public function render()
    {
        // TODO: Implement render() method.
        return view($this->view)->with([
            'id' => $this->id,
            'title' => $this->title
        ]);
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->render()->render();
    }
}