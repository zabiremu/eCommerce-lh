<?php

namespace App\Http\Controllers\Admin\ChildCategory;

use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ChildCategoryController extends Controller
{
    public function index()
    {
        $data = DB::table('child_categories')->leftJoin('sub_categories', 'child_categories.sub_category_id', 'sub_categories.id')->leftJoin('categories', 'child_categories.category_id', 'categories.id')->select('categories.id as category_id', 'categories.title as category_name', 'sub_categories.id as sub_category_id', 'sub_categories.title as sub_category_name', 'child_categories.*')->orderBy('id', 'DESC')->get();
        // dd($data);
        $info = new stdClass();
        $info->page_title = 'Create Child Category';
        $info->all_data = 'All Child Categories';
        $info->form_store = 'admin.childCategory.store';
        $info->form_edit = 'admin.childCategory.edit';
        $info->form_destroy = 'admin.childCategory.destroy';
        $subCategories = DB::table('sub_categories')->where('sub_categories.status', 1)->leftJoin('categories', 'sub_categories.category_id', 'categories.id')->select('categories.id as category_id', 'categories.title as category_name', 'sub_categories.*')->orderBy('id', 'DESC')->get();
        // dd($subCategories);
        return view('admin.category.child-categories.index', compact('data', 'info', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required|integer',
            'title' => 'required|string|max:80|unique:categories,title',
            'slug' => 'required|string|max:80|unique:categories,slug',
        ]);

        $category = DB::table('sub_categories')->where('id', $request->sub_category_id)->first();
        $expect_columns = json_decode('["_token"]', true);
        $dataToInsert = $request->except($expect_columns);
        $dataToInsert['category_id'] = $category->category_id;
        $row =  DB::table('child_categories')->insertGetId($dataToInsert);
        return redirect()->route('admin.childCategory.index')->with('success', 'Child Category Successfully Created');
    }

    public function edit($id)
    {
        $data = DB::table('child_categories')->leftJoin('sub_categories', 'child_categories.sub_category_id', 'sub_categories.id')->leftJoin('categories', 'child_categories.category_id', 'categories.id')->select('categories.id as category_id', 'categories.title as category_name', 'sub_categories.id as sub_category_id', 'sub_categories.title as sub_category_name', 'child_categories.*')->orderBy('id', 'DESC')->get();
        $info = new stdClass();
        $info->page_title = 'Create Child Category';
        $info->all_data = 'All Child Categories';
        $info->form_update = 'admin.childCategory.update';
        $info->form_edit = 'admin.childCategory.edit';
        $info->form_destroy = 'admin.childCategory.destroy';
        $row = DB::table('child_categories')->where('id', $id)->first();
        $subCategories = DB::table('sub_categories')->where('sub_categories.status', 1)->leftJoin('categories', 'sub_categories.category_id', 'categories.id')->select('categories.id as category_id', 'categories.title as category_name', 'sub_categories.*')->orderBy('id', 'DESC')->get();
        return view('admin.category.child-categories.index', compact('data', 'info', 'row', 'subCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sub_category_id' => 'required|integer',
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80',
        ]);

        $category = DB::table('sub_categories')->where('id', $request->sub_category_id)->first();
        $expect_columns = json_decode('["_token","_method"]', true);
        $dataToInsert = $request->except($expect_columns);
        $dataToInsert['category_id'] = $category->category_id;
        $row =  DB::table('child_categories')->where('id', $id)->update($dataToInsert);
        return redirect()->route('admin.childCategory.index')->with('success', 'Child Category Successfully Updated');
    }

    public function destroy($id)
    {
        DB::table('child_categories')->where('id', $id)->delete();
        return redirect()->route('admin.childCategory.index')->with('success', 'Child Category Successfully Deleted');
    }
}
