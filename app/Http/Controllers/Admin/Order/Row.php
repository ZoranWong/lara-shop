<?php
namespace App\Http\Controllers\Admin\Order;
class Row extends \App\Renders\Grid\Row
{
    protected $colors =[
        '#F8FBFC',
        '#EEEEEE'
    ];
    public function render()
    {
        $code = $this->data['code'];
        $color = $this->colors[$this->number%2];
        $id = $this->data['id'];
        $tr = view('store.order.grid.code-row',[
            'code'  => $code,
            'color' => $color,
            'id'    => $id
        ])->render();
        $tr .= view('store.order.grid.order-item',[
            'orderItems' => isset($this->data['order_items']) ? $this->data['order_items'] : [],
            'color' => $color,
            'order' => $this->data,
        ])->render();

        return $tr;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->render();
    }
}