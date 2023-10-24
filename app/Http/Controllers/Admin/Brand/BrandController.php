<?php

namespace App\Http\Controllers\Admin\Brand;

use stdClass;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Brand::orderBy('id', 'DESC')->simplePaginate(10);
        $info = new stdClass();
        $info->page_title = 'Create Brand';
        $info->all_data = 'All Brands';
        $info->form_store = 'admin.brand.store';
        $info->form_edit = 'admin.brand.edit';
        $info->form_destroy = 'admin.brand.destroy';
        return view('admin.brand.index', compact('data', 'info'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:80|unique:Brands,title',
            'slug' => 'required|string|max:80|unique:Brands,slug',
            // 'logo' => 'required|image,mimes:jpeg,png,jpg,webp'
        ]);

        $expect_columns = json_decode('["_token","logo"]', true);
        $row = Brand::insert($request->except($expect_columns));
        return redirect()->route('admin.brand.index')->with('success', 'Brand Successfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Brand::orderBy('id', 'DESC')->simplePaginate(10);
        $info = new stdClass();
        $info->page_title = 'Create Brand';
        $info->all_data = 'All Brands';
        $info->form_update = 'admin.brand.update';
        $info->form_edit = 'admin.brand.edit';
        $info->form_destroy = 'admin.brand.destroy';
        $row = Brand::where('id', $id)->first();
        return view('admin.brand.index', compact('data', 'info', 'row'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80',
        ]);

        $expect_columns = json_decode('["_token","_method"]', true);
        $row = Brand::where('id', $id)->update($request->except($expect_columns));
        return redirect()->route('admin.brand.index')->with('success', 'Brand Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Brand::where('id', $id)->delete();
        return redirect()->route('admin.brand.index')->with('success', 'Brand Successfully Deleted');
    }
}
