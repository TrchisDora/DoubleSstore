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
            return Redirect::to('login')->send();
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
                return redirect()->route('all.product', ['page' => session('current_page', 1)]);

            }
        } catch (\Exception $e) {
            Log::error('Có lỗi xảy ra trong quá trình thêm sản phẩm: '.$e->getMessage());
            Session::put('error', 'Có lỗi xảy ra trong quá trình thêm sản phẩm');
            return redirect()->route('all.product', ['page' => session('current_page', 1)]);
        }
    }
    
    public function all_product(Request $request)
    {
        $currentPage = $request->input('page', 1);
        session(['current_page' => $currentPage]);
    
        $query = Product::query()->with('categoryProduct');
        
        if ($request->has('category_id') && $request->category_id != 0) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('brand_id') && $request->brand_id != 0) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->has('product_status') && $request->product_status != '') {
            $query->where('product_status', $request->product_status);
        }
        if ($request->has('product_prominent') && $request->product_prominent != '') {
            $query->where('product_prominent', $request->product_prominent);
        }
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('categoryProduct', function ($query) use ($searchTerm) {
                      $query->where('meta_keywords', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
        
        // Áp dụng phân trang với các tham số lọc
        $all_product = $query->paginate(10)->appends(request()->query());
    
        $categories = CategoryProduct::all();
        $brands = BrandProduct::all();
        
        return view('AdminPages.Pages.Product.all_product', compact('all_product', 'categories', 'brands'));
    }
    
    
    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $productIds = $request->input('product_ids', []);

        if (empty($productIds)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một sản phẩm!');
        }

        switch ($action) {
            case '1': // Xóa các mục
                Product::destroy($productIds);
                return redirect()->back()->with('message', 'Đã xóa sản phẩm thành công!');

            
            case '2': // Hiện/Ẩn các mục
                foreach ($productIds as $id) {
                    $product = Product::find($id);
                    if ($product) {
                        $product->product_status = !$product->product_status; // Chuyển đổi trạng thái
                        $product->save();
                    }
                }
                return redirect()->back()->with('message', 'Đã cập nhật trạng thái sản phẩm thành công!');

            case '3': // Un/Nổi Bật các mục
                foreach ($productIds as $id) {
                    $product = Product::find($id);
                    if ($product) {
                        $product->product_prominent = !$product->product_prominent; // Chuyển đổi nổi bật
                        $product->save();
                    }
                }
                return redirect()->back()->with('message', 'Đã cập nhật tình trạng nổi bật của sản phẩm thành công!');
            case '4': // Xuất dữ liệu các mục
                // Logic xuất dữ liệu có thể ở đây (ví dụ: tạo file CSV)
                

            default:
                return redirect()->back()->with('error', 'Hành động không hợp lệ!');
        }
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
        
        // Xác thực dữ liệu
        $data = $request->validate([
            'product_name' => 'required|max:255',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|integer',
            'product_desc' => 'required',
            'product_status' => 'required|integer',
            'category_id' => 'required|integer', 
            'brand_id' => 'required|integer', 
            'product_image' => 'image|nullable'
        ]);
    
        // Tìm sản phẩm theo ID
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
            // Xóa hình ảnh cũ nếu tồn tại
            $oldImagePath = public_path('fontend/images/product/'. $product->product_image);
            if (is_file($oldImagePath)) {
                unlink($oldImagePath);
            }
    
            // Xử lý và lưu hình ảnh mới
            $file = $request->file('product_image');
            $filename = $this->XuLyAnh($file->getClientOriginalName(), $data['product_name']); // Tạo tên file mới
            $file->move(public_path('fontend/images/product'), $filename);
            $product->product_image = $filename; // Cập nhật tên hình ảnh trong cơ sở dữ liệu
        }

        
        // Lưu sản phẩm
        $product->save();
        Session::put('message', 'Cập nhật sản phẩm thành công');
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);
    }
    
    public function delete_product($product_id) {
        $this->AuthLogin();
        Product::destroy($product_id);
        Session::put('message', 'Xóa sản phẩm thành công');
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);

    }

    public function active_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message', 'Đã hiện');
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);

    }
    
    public function unactive_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message', 'Đã ẩn');
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);

    }
    
    public function active_prominent_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_prominent' => 1]);
        Session::put('message', 'Kích hoạt nổi bật');
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);

    } 
    
    public function unactive_prominent_product($product_id) {
        $this->AuthLogin();
        Product::where('product_id', $product_id)->update(['product_prominent' => 0]); 
        Session::put('message', 'Đã tắt nổi bật');
        return redirect()->route('all.product', ['page' => session('current_page', 1)]);

    }
    //end function admin page
    public function details_product($product_id)
{
    // Lấy danh mục sản phẩm
    $cate_product = CategoryProduct::where('category_status', 1)
        ->orderBy('category_id', 'desc')
        ->get();

    // Lấy thương hiệu sản phẩm
    $brand_product = BrandProduct::where('brand_status', 0)
        ->orderBy('brand_id', 'desc')
        ->get();

    // Lấy chi tiết sản phẩm
    $details_product = Product::with(['category', 'brand'])
        ->where('product_id', $product_id)
        ->get();

    //Kiểm tra nếu sản phẩm không tồn tại
    if (!$details_product) {
        abort(404, 'Product not found.');
    }

    foreach($details_product as $key => $value){
        $category_id = $value->category_id;
    }
    $related_product = Product::with(['category', 'brand'])
        ->where('category_id', $category_id)
        ->whereNotIn('product_id', [$product_id])
        ->get();

    // Truyền dữ liệu vào view
    return view('UserPages.Pages.details.show_details', compact('cate_product', 'brand_product', 'details_product', 'related_product'));


    }
}
