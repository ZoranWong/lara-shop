<?php
namespace App\Renders;
use App\Renders\Widgets\Card;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

class CardList implements Renderable
{
    /**
     * @var Collection
     * */
    protected $cards = null;

    public function __construct(array $cards)
    {
        $this->cards = collect($cards)->map(function (array $card){
            return new Card($card);
        });
    }

    public function render()
    {
        // TODO: Implement render() method.
        return $this->template();
    }

    protected function template() : string
    {
        // TODO: Implement __toString() method.
        return $this->cards->map(function (Card $card){
            return $card->render();
        })->implode('');
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->render();
    }
}