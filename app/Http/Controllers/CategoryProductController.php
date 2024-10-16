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
        return view('AdminPages.Pages.CategoryProduct.add_category_product');
    }

    public function all_category_product() {
        $this->AuthLogin();
        $all_category_product = CategoryProduct::paginate(5); // Sử dụng model
        return view('AdminPages.Pages.CategoryProduct.all_category_product', compact('all_category_product'));
    }

    public function save_category_product(Request $request) {
        // Xác thực dữ liệu đầu vào
        $data = $request->validate([
            'category_name' => 'required|max:255',
            'category_desc' => 'required',
            'category_product_keywords' => 'required',
            'category_product_status' => 'required|integer'
        ]);

        // Tạo một đối tượng CategoryProduct mới và lưu vào cơ sở dữ liệu
        $categoryProduct = new CategoryProduct();
        $categoryProduct->category_name = $data['category_name'];
        $categoryProduct->category_desc = $data['category_desc'];
        $categoryProduct->meta_keywords = $data['category_product_keywords'];
        $categoryProduct->category_status = $data['category_product_status'];

        // Tạo slug từ tên danh mục
        $categoryProduct->slug_category_product = $this->generateSlug($data['category_name']);
        $categoryProduct->save();

        // Hiển thị thông báo khi thêm thành công
        Session::put('message', 'Thêm danh mục sản phẩm thành công');
        return redirect()->back();
    }
    private function generateSlug($name)
    {
        // Chuyển chuỗi về chữ thường
        $slug = strtolower(trim($name));
    
        // Loại bỏ dấu trong tiếng Việt
        $slug = preg_replace('/[àáảãạâầấẩẫậ]/u', 'a', $slug);
        $slug = preg_replace('/[èéẻẽẹêềếểễệ]/u', 'e', $slug);
        $slug = preg_replace('/[ìíỉĩị]/u', 'i', $slug);
        $slug = preg_replace('/[òóỏõọôồốổỗộơờớởỡợ]/u', 'o', $slug);
        $slug = preg_replace('/[ùúủũụưừứửữự]/u', 'u', $slug);
        $slug = preg_replace('/[ỳýỷỹỵ]/u', 'y', $slug);
        $slug = preg_replace('/[đ]/u', 'd', $slug);
    
        // Giữ lại chữ cái, số, khoảng trắng và dấu gạch nối
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        // Thay thế nhiều khoảng trắng và dấu gạch nối thành một dấu gạch nối
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-'); // Loại bỏ dấu gạch nối ở đầu và cuối
    
        return $slug; // Trả về slug
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
        return view('AdminPages.Pages.CategoryProduct.edit_category_product', compact('edit_category_product'));
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
