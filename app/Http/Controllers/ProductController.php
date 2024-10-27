<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;           
use App\Models\CategoryProduct;  
use App\Models\BrandProduct;  
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_product()
    {
        $this->AuthLogin();
        $cate_product = CategoryProduct::all(); 
        $brand_product = BrandProduct::all(); 
        return view('AdminPages.Pages.Product.add_product', compact('cate_product', 'brand_product'));
    }
    
    public function save_product(Request $request)
    {
        try {
            $data = $request->validate([
                'product_name' => 'required|max:255',
                'product_quantity' => 'required|integer',
                'product_price' => 'required|numeric',
                'product_image' => 'required|image',
                'category_id' => 'required|integer',
                'brand_id' => 'required|integer',
                'product_desc' => 'required',
                'product_content' => 'required',
                'product_status' => 'required|integer',
                'product_prominent' => 'required|integer',
            ]);

            // Tạo slug từ tên sản phẩm
            $slug = $this->XuLyTen($data['product_name']); // Gọi phương thức XuLyTen
            $existingProduct = Product::where('product_name', $data['product_name'])->first();

            if ($existingProduct) {
                Session::put('error', 'Thêm sản phẩm không thành công, sản phẩm đã tồn tại');
                return redirect()->back();
            } else {
                $product = new Product();
                $product->product_name = $data['product_name'];
                $product->product_quantity = $data['product_quantity'];
                $product->product_sold = 0;
                $product->product_slug = $slug; 
                $product->product_price = $data['product_price'];
                $product->category_id = $data['category_id'];
                $product->brand_id = $data['brand_id'];
                $product->product_desc = $data['product_desc'];
                $product->product_content = $data['product_content'];
                $product->product_status = $data['product_status'];
                $product->product_prominent = $data['product_prominent'];
                
                if ($request->hasFile('product_image')) {
                    $image = $request->file('product_image');
                    // Gọi phương thức XuLyAnh
                    $image_name = $this->XuLyAnh($image->getClientOriginalName(), $product->product_name);
                    $image->move(public_path('fontend/images/product'), $image_name);
                    $product->product_image = $image_name;
                }
                
                $product->save();
                Session::put('message', 'Thêm sản phẩm thành công');
                return redirect()->to('all-product');
            }
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra trong quá trình thêm sản phẩm: '.$e->getMessage());
            Session::put('error', 'Có lỗi xảy ra trong quá trình thêm sản phẩm');
            return redirect()->back();
        }
    }
    
    public function all_product(Request $request)
    {
        // Lưu trang hiện tại vào session
        $currentPage = $request->input('page', 1);
        session(['current_page' => $currentPage]);

        $all_product = Product::paginate(10); 
        return view('AdminPages.Pages.Product.all_product', compact('all_product'));
    }

    public function edit_product($id) {
        $this->AuthLogin();
        $product = Product::findOrFail($id);
        $categories = CategoryProduct::all();
        $brands = BrandProduct::all();
        return view('AdminPages.Pages.Product.edit_product', compact('product', 'categories', 'brands'));
    }
    
    public function update_product(Request $request, $id) {
        $this->AuthLogin();
        
        $data = $request->validate([
            'product_name' => 'required|max:255',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|integer',
            'product_desc' => 'required',
            'product_status' => 'required|integer',
            'category_id' => 'required|integer', 
            'brand_id' => 'required|integer', 
            'product_image' => 'image'
        ]);

        $product = Product::findOrFail($id);
        $product->product_name = $data['product_name'];
        $product->product_slug = $this->XuLyTen($data['product_name']); 
        $product->product_price = $data['product_price'];
        $product->product_quantity = $data['product_quantity'];
        $product->product_desc = $data['product_desc'];
        $product->product_status = $data['product_status'];
        $product->category_id = $data['category_id'];
        $product->brand_id = $data['brand_id'];

        // Cập nhật hình ảnh nếu có
        if ($request->hasFile('product_image')) {
            // Xóa hình ảnh cũ
            if (file_exists(public_path('fontend/images/product/' . $product->product_image))) {
                unlink(public_path('fontend/images/product/' . $product->product_image));
            }
            $file = $request->file('product_image');
            $filename = $this->XuLyAnh($file->getClientOriginalName(), $data['product_name']);
            $file->move(public_path('fontend/images/product'), $filename);
            $product->product_image = $filename;
        }

        $product->save();
        Session::put('message', 'Cập nhật sản phẩm thành công');

        // Chuyển hướng về trang đã lưu trong session
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);
    }
    
    public function delete_product($product_id) {
        $this->AuthLogin();
        Product::destroy($product_id);
        Session::put('message', 'Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function active_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    
    public function unactive_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }
    
    public function active_prominent_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_prominent' => 1]);
        Session::put('message', 'Kích hoạt sản phẩm nổi bật thành công');
        return Redirect::to('all-product');
    } 
    
    public function unactive_prominent_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_prominent' => 0]); 
        Session::put('message', 'Không kích hoạt sản phẩm nổi bật thành công');
        return Redirect::to('all-product');
    }
    public function filterProducts(Request $request)
{
    $query = Product::query();

    // Lọc theo loại
    if ($request->filled('category_id') && $request->category_id != 0) {
        $query->where('category_id', $request->category_id);
    }

    // Lọc sản phẩm nổi bật
    if ($request->filled('prominent')) {
        $query->where('product_prominent', 1);
    }

    // Lọc sản phẩm đang hiển thị
    if ($request->filled('status')) {
        $query->where('product_status', 1);
    }

    $all_product = $query->paginate(10);
    $categories = CategoryProduct::all();

    return view('AdminPages.Pages.Product.all_product', compact('all_product', 'categories'));
}
}
