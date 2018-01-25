<?php

namespace App\Http\Controllers\Admin\Merchandise;

use App\Models\Specification;
use App\Http\Requests\Ajax\Specification as Request;
use App\Http\Controllers\Controller;

class SpecificationController extends Controller
{
    //

    public function index()
    {
        $list = Specification::all();
        return response()->ajax($list);
    }

    public function store(Request $request)
    {
        $data = Specification::create($request->all());
        return response()->ajax($data);
    }

    public function update(Request $request, $id)
    {
        $data = Specification::updateById($id, $request->all());
        return response()->ajax($data);
    }
}
