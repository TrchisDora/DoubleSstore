<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct; 
use App\Models\Slider;
use App\Exports\ExcelExports;
use App\Imports\ExcelImports;
use Excel;
use Session;
use Illuminate\Support\Facades\Log;
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
            $data = $request->validate([
                'category_name' => 'required|max:255',
                'category_desc' => 'required',
                'meta_keywords' => 'required',
                'category_status' => 'required|integer',
                'category_icon_admin' => 'image|nullable',
                'category_icon_user' => 'image|nullable',
            ]);
            $slug = $this->XuLyTen($data['category_name']); // Gọi phương thức XuLyTen
            $existingCategory = CategoryProduct::where('category_name', $data['category_name'])->first();
            
            if ($existingCategory) {
                Session::put('error', 'Thêm danh mục sản phẩm không thành công, danh mục đã tồn tại');
                return redirect()->back();
            } else {
                $categoryProduct = new CategoryProduct();
                $categoryProduct->category_name = $data['category_name'];
                $categoryProduct->category_desc = $data['category_desc'];
                $categoryProduct->meta_keywords = $data['meta_keywords'];
                $categoryProduct->category_status = $data['category_status'];
                $categoryProduct->slug_category_product = $slug;
                
                // Upload image for Admin icon
                if ($request->hasFile('category_icon_admin')) {
                    $file = $request->file('category_icon_admin');
                    // Tạo tên hình ảnh theo slug
                    $filename = $this->XuLyAnh($file->getClientOriginalName(), $data['category_name']);
                    $file->move('public/backend/images/icons', $filename);
                    $categoryProduct->category_icon_admin = $filename;
                }

                // Upload image for User icon
                if ($request->hasFile('category_icon_user')) {
                    $file = $request->file('category_icon_user');
                    // Tạo tên hình ảnh theo slug
                    $filename = $this->XuLyAnh($file->getClientOriginalName(), $data['category_name']);
                    $file->move('public/fontend/images/icons', $filename);
                    $categoryProduct->category_icon_user = $filename;
                }


                $categoryProduct->save();
                Session::put('message', 'Thêm danh mục sản phẩm thành công');
                return redirect()->back();
            }
    }
    public function edit_category_product($category_product_id) {
        $this->AuthLogin();
        $edit_category_product = CategoryProduct::find($category_product_id);
        return view('AdminPages.Pages.CategoryProduct.edit_category_product', compact('edit_category_product'));
    }

    public function update_category_product(Request $request, $id) {
      
            $data = $request->validate([
                'category_name' => 'required|max:255',
                'category_desc' => 'required',
                'meta_keywords' => 'required',
                'category_status' => 'required|integer',
                'category_icon_admin' => 'image|nullable',
                'category_icon_user' => 'image|nullable',
            ]);
    
            $categoryProduct = CategoryProduct::findOrFail($id);
            $categoryProduct->category_name = $data['category_name'];
            $categoryProduct->category_desc = $data['category_desc'];
            $categoryProduct->meta_keywords = $data['meta_keywords'];
            $categoryProduct->category_status = $data['category_status'];
            $categoryProduct->slug_category_product = $this->XuLyTen($data['category_name']); // Tạo slug từ tên danh mục
    
            // Cập nhật hình ảnh Admin nếu có
            if ($request->hasFile('category_icon_admin')) {
                // Xóa hình ảnh cũ
                if (file_exists(public_path('backend/images/icons/' . $categoryProduct->category_icon_admin))) {
                    unlink(public_path('backend/images/icons/' . $categoryProduct->category_icon_admin));
                }
                // Tải hình ảnh mới lên
                $file = $request->file('category_icon_admin');
                $filename = $this->XuLyAnh($file->getClientOriginalName(), $data['category_name']);
                $file->move(public_path('backend/images/icons'), $filename);
                $categoryProduct->category_icon_admin = $filename;
            }
    
            // Cập nhật hình ảnh User nếu có
            if ($request->hasFile('category_icon_user')) {
                // Xóa hình ảnh cũ
                if (file_exists(public_path('fontend/images/icons/' . $categoryProduct->category_icon_user))) {
                    unlink(public_path('fontend/images/icons/' . $categoryProduct->category_icon_user));
                }
                // Tải hình ảnh mới lên
                $file = $request->file('category_icon_user');
                $filename = $this->XuLyAnh($file->getClientOriginalName(), $data['category_name']);
                $file->move(public_path('fontend/images/icons'), $filename);
                $categoryProduct->category_icon_user = $filename;
            }
    
            // Lưu danh mục sản phẩm
            $categoryProduct->save();
            Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
            return redirect()->back();

    }
    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $categoryIds = $request->input('category_ids',[]);

        if (empty( $categoryIds)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm!');
        }

        switch ($action) {
            case '1': // Xóa các mục
                CategoryProduct::destroy( $categoryIds);
                return redirect()->back()->with('message', 'Đã xóa sản phẩm thành công!');
  
                
            case '2': // Hiện/Ẩn các mục
                foreach ($categoryIds as $id) {
                    $category = CategoryProduct::find($id);
                        if ($category) {
                            $category->category_status = !$category->category_status; 
                            $category->save();
                        }
                }
                return redirect()->back()->with('message', 'Đã cập nhật trạng thái sản phẩm thành công!');
                    
 
            case '3': // Xuất dữ liệu các mục
                // Logic xuất dữ liệu có thể ở đây (ví dụ: tạo file CSV)
                return response()->download($filePath); // Giả sử bạn đã tạo file cần tải về

            default:
                return redirect()->back()->with('error', 'Hành động không hợp lệ!');
        }
    }
    public function unactive_category_product($category_product_id) {
        $this->AuthLogin();
        CategoryProduct::where('category_id', $category_product_id)->update(['category_status' => 0]); 
        Session::put('message', 'Đã ẩn');
        return Redirect::to('all-category-product');
    }

    public function active_category_product($category_product_id) {
        $this->AuthLogin();
        CategoryProduct::where('category_id', $category_product_id)->update(['category_status' => 1]); 
        Session::put('message', 'Đã hiện thị');
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
