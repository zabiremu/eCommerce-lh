<?php

namespace App\Http\Controllers\Admin\SubCategory;

use stdClass;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data = DB::table('sub_categories')->leftJoin('categories', 'sub_categories.category_id', 'categories.id')->select('categories.id as category_id', 'categories.title as category_name', 'sub_categories.*')->orderBy('id', 'DESC')->simplePaginate(10);
        $info = new stdClass();
        $info->page_title = 'Create Sub Category';
        $info->all_data = 'All Sub Categories';
        $info->form_store = 'admin.subCategory.store';
        $info->form_edit = 'admin.subCategory.edit';
        $info->form_destroy = 'admin.subCategory.destroy';
        $categories = DB::table('categories')->where('status', 1)->orderBy('id', 'DESC')->get();
        return view('admin.category.sub-categories.index', compact('data', 'info', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required|string|max:80|unique:categories,title',
            'slug' => 'required|string|max:80|unique:categories,slug',
        ]);

        $expect_columns = json_decode('["_token"]', true);
        $row = SubCategory::insert($request->except($expect_columns));
        return redirect()->route('admin.subCategory.index')->with('success', 'Sub Category Successfully Created');
    }

    public function edit($id)
    {
        $data = DB::table('sub_categories')->leftJoin('categories', 'sub_categories.category_id', 'categories.id')->select('categories.id as category_id', 'categories.title as category_name', 'sub_categories.*')->orderBy('id', 'DESC')->simplePaginate(10);
        $info = new stdClass();
        $info->page_title = 'Create Sub Category';
        $info->all_data = 'All Sub Categories';
        $info->form_update = 'admin.subCategory.update';
        $info->form_edit = 'admin.subCategory.edit';
        $info->form_destroy = 'admin.subCategory.destroy';
        $row = SubCategory::where('id', $id)->first();
        $categories = Category::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('admin.category.sub-categories.index', compact('data', 'info', 'row', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80',
        ]);

        $expect_columns = json_decode('["_token","_method"]', true);
        $row = SubCategory::where('id', $id)->update($request->except($expect_columns));
        return redirect()->route('admin.subCategory.index')->with('success', 'Sub Category Successfully Updated');
    }

    public function destroy($id)
    {
        SubCategory::where('id', $id)->delete();
        return redirect()->route('admin.subCategory.index')->with('success', 'Sub Category Successfully Deleted');
    }
}
