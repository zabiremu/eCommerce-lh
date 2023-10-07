<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use stdClass;

class CategoryController extends Controller
{
    public function index()
    {
        $data = DB::table('categories')->latest()->get();
        $info = new stdClass();
        $info->page_title = 'Create Category';
        $info->all_data = 'All Categories';
        return view('admin.category.category.index', compact('data', 'info'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:80|unique:categories,category_name',
            'category_slug' => 'required|string|max:80|unique:categories,category_slug',
        ]);

        $expect_columns = json_decode('["_token"]', true);
        $row = DB::table('categories')->insert($request->except($expect_columns));
        return redirect()->route('admin.category.index')->with('success', 'Category Successfully Created');
    }
}
