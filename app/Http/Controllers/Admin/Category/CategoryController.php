<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $data = DB::table('categories')->get();
        return view('admin.category.category.index', compact('data'));
    }
}
