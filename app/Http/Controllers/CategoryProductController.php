<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct; // Import model CategoryProduct
use App\Models\Slider;
use App\Exports\ExcelExports;
use App\Imports\ExcelImports;
use Excel;
use Session;
use Illuminate\Support\Facades\Redirect;

class CategoryProductController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_category_product() {
        $this->AuthLogin();
        return view('AdminPages.Pages.add_category_product');
    }

    public function all_category_product() {
        $this->AuthLogin();
        $all_category_product = CategoryProduct::paginate(2); // Sử dụng model
        return view('admin.all_category_product', compact('all_category_product'));
    }

    public function save_category_product(Request $request) {
        $this->AuthLogin();
        $data = $request->only(['meta_keywords',
        'category_name',
        'slug_category_product',
        'category_desc',
        'category_status']);
        CategoryProduct::create($data); // Sử dụng model
        Session::put('message', 'Thêm danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function unactive_category_product($category_product_id) {
        $this->AuthLogin();
        CategoryProduct::where('category_id', $category_product_id)->update(['category_status' => 1]); // Sử dụng model
        Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function active_category_product($category_product_id) {
        $this->AuthLogin();
        CategoryProduct::where('category_id', $category_product_id)->update(['category_status' => 0]); // Sử dụng model
        Session::put('message', 'Kích hoạt danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function edit_category_product($category_product_id) {
        $this->AuthLogin();
        $edit_category_product = CategoryProduct::findOrFail($category_product_id); // Sử dụng model
        return view('admin.edit_category_product', compact('edit_category_product'));
    }

    public function update_category_product(Request $request, $category_product_id) {
        $this->AuthLogin();
        $data = $request->only(['category_name', 'meta_keywords', 'slug_category_product', 'category_desc']);
        CategoryProduct::where('category_id', $category_product_id)->update($data); // Sử dụng model
        Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function delete_category_product($category_product_id) {
        $this->AuthLogin();
        CategoryProduct::destroy($category_product_id); // Sử dụng model
        Session::put('message', 'Xóa danh mục sản phẩm thành công');
        return Redirect::to('all-category-product');
    }

    public function show_category_home(Request $request, $slug_category_product) {
        // slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        $cate_product = CategoryProduct::where('category_status', '0')->orderBy('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderBy('brand_id', 'desc')->get();
        $category_by_id = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('tbl_category_product.slug_category_product', $slug_category_product)
            ->paginate(6);

        $category_name = CategoryProduct::where('slug_category_product', $slug_category_product)->limit(1)->get();

        // SEO
        $meta_desc = $category_name->first()->category_desc ?? '';
        $meta_keywords = $category_name->first()->meta_keywords ?? '';
        $meta_title = $category_name->first()->category_name ?? '';
        $url_canonical = $request->url();

        return view('pages.category.show_category', compact('cate_product', 'brand_product', 'category_by_id', 'category_name', 'meta_desc', 'meta_keywords', 'meta_title', 'url_canonical', 'slider'));
    }

    public function export_csv() {
        return Excel::download(new ExcelExports(), 'category_product.xlsx');
    }

    public function import_csv(Request $request) {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ExcelImports, $path);
        return back();
    }
}
