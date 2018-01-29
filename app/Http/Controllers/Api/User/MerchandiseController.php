<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class MerchandiseController extends Controller
{
    //

    public function list(Request $request)
    {
        $categoryId = $request->input('category_id', null);
        $search = $request->input('search', null);
        $query = Merchandise::newModelInstance();
        if($search){
            $query = $query->search($search);
            $query->where('status', array_search('ON_SHELVES', Merchandise::STATUS_SYNC_SEARCH));
        }else{
            $query->where('status', Merchandise::STATUS['ON_SHELVES']);
        }
        if($categoryId){
            $query->where('category_id', $categoryId);
        }
        return response()->api($this->buildList($query, $search));
    }

    public function detail($id)
    {
        $merchandise = Merchandise::where('status', Merchandise::STATUS['ON_SHELVES'])->find($id);
        return response()->api($merchandise);
    }
}