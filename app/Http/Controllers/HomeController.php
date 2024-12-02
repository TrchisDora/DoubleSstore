<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\BrandProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh mục sản phẩm
        $cate_product = CategoryProduct::where('category_status', 1)->orderBy('category_id', 'desc')->get();

        // Lấy thương hiệu sản phẩm
        $brand_product = BrandProduct::where('brand_status', 0)->orderBy('brand_id', 'desc')->get();

        // Lấy danh sách sản phẩm
        $product = Product::where('product_status', 0)->orderBy('product_id', 'desc')->limit(6)->get();

        // Truyền dữ liệu vào view
        return view('UserPages.Pages.home', compact('cate_product', 'brand_product', 'product'));
    }
}
