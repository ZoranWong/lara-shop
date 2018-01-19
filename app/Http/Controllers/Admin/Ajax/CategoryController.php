<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Merchandise;
use Illuminate\Validation\Rule;
use App\Services\StoreService;

class CategoryController
{
    public function index()
    {
        $storeId = StoreService::getCurrentID();
        $data = Category::where('store_id',$storeId)->orderBy('is_default','desc')->orderBy('id','desc')->get()->toArray();
        foreach($data as &$v){
          $v['goods_num'] = Merchandise::where('category_id',$v['id'])->count();
        }
        return response()->ajax($data);
    }

    public function update(Request $request,$id)
    {
        $storeId      = StoreService::getCurrentID();
        $fileds = [
            'name'             => 'required|max:100',
            //'parent_id'        => 'required|max:50',
        ];
        $this->validate($request, $fileds);

        $data   = array_only($request->all(),array_keys($fileds));
        $result = Category::updateForStore($id,$data);

        return response()->ajax($result);
    }

    public function store(Request $request)
    {
        $storeId = StoreService::getCurrentID();
        $fileds = [
            'name'             => 'required|max:100',
            'parent_id'        => 'required|max:50',
        ];
        $this->validate($request, $fileds);

        $data   = array_only($request->all(),array_keys($fileds));

        $result = Category::createForStore($data);

        return response()->ajax($result);
    }

    public function show($id)
    {
        $activity = Category::findForStore($id);
        return response()->ajax($activity);
    }

    public function destroy(Request $request ,$id = 0)
    {
        $fileds = [
            'id' => 'required|array',
            'id.*' => 'integer',
        ];
        $this->validate($request, $fileds);
        $idList = $request->input('id');
        $count = Merchandise::whereIn('category_id',$idList)->count();
        if($count > 0){
          return response()->errorAjax($count);
        }
        if($id){
            array_push($idList, $id);
        }
        return response()->ajax(Category::deleteForStoreByIds($idList));
    }
}
