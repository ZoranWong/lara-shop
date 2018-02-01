<?php

namespace App\Http\Controllers\Admin\Common;

use App\Renders\Facades\SectionContent;
use Symfony\Component\HttpFoundation\Response;

trait ModelForm
{
    /**
     * Display a listing of the resource.
     *
     * @return BasePage
     */
    public function index() : BasePage
    {
        $css = <<<CSS
.grid-row-checkbox{
    position: relative !important;
    opacity: inherit !important;
}
CSS;

        SectionContent::css($css);
        return $this->page->table();
    }

    protected function conditions()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return BasePage
     */
    public function create() : BasePage
    {
        return $this->page->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store() : \Symfony\Component\HttpFoundation\Response
    {
        return $this->page->form()->store();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id) : \Symfony\Component\HttpFoundation\Response
    {
        //
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Page
     */
    public function edit($id) : BasePage
    {
        return $this->page->edit($id);
    }

    /**
     * Update the specified resource in storage.
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update($id) : \Symfony\Component\HttpFoundation\Response
    {
        return $this->page->form()->update($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id) : \Symfony\Component\HttpFoundation\Response
    {
        //
        if ($this->page->form()->destroy($id)) {
            return response()->json([
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ]);
        }
    }
}