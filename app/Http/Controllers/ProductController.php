<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;           
use App\Models\CategoryProduct;  
use App\Models\BrandProduct;  

use Session;
class ProductController extends Controller
{
    
    public function add_product()
    {
        $cate_product = CategoryProduct::all(); // Lấy tất cả danh mục sản phẩm
        $brand_product = BrandProduct::all(); // Lấy tất cả thương hiệu sản phẩm
        return view('AdminPages.Pages.Product.add_product', compact('cate_product', 'brand_product'));
    }
    
    public function save_product(Request $request)
{
    // Xác thực dữ liệu đầu vào
    $data = $request->validate([
        'product_name' => 'required|max:255',
        'product_quantity' => 'required|integer',
        'product_slug' => 'required|max:255',
        'product_price' => 'required|numeric',
        'product_image' => 'required|image',
        'category_id' => 'required|integer',
        'brand_id' => 'required|integer',
        'product_desc' => 'required',
        'product_content' => 'required',
        'product_status' => 'required|integer',
    ]);

    // Kiểm tra xem tên sản phẩm đã tồn tại chưa
    $existingProduct = Product::where('product_name', $data['product_name'])->first();

    if ($existingProduct) {
        // Nếu tên sản phẩm đã tồn tại, trả về thông báo lỗi
        Session::put('error', 'Thêm sản phẩm không thành công, sản phẩm đã tồn tại');
        return redirect()->back();
    } else {
        // Tạo một đối tượng Product mới và lưu vào cơ sở dữ liệu
        $product = new Product();
        $product->product_name = $data['product_name'];
        $product->product_quantity = $data['product_quantity'];
        $product->product_sold = 0; // Giá trị mặc định cho product_sold
        $product->product_slug = $data['product_slug']; // Có thể thay bằng slug được tạo tự động
        $product->product_price = $data['product_price'];
        $product->category_id = $data['category_id'];
        $product->brand_id = $data['brand_id'];
        $product->product_desc = $data['product_desc'];
        $product->product_content = $data['product_content'];
        $product->product_status = $data['product_status'];

        // Nếu có upload ảnh
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/product'), $image_name);
            $product->product_image = $image_name;
        }

        // Tạo slug từ tên sản phẩm
        $product->product_slug = $this->generateSlug($data['product_name']);
        $product->save();

        // Hiển thị thông báo khi thêm thành công
        Session::put('message', 'Thêm sản phẩm thành công');
        return redirect()->to('all-product');
    }
}

private function generateSlug($name)
{
    // Kiểm tra xem $name có phải là chuỗi hợp lệ không
    if (!is_string($name) || empty($name)) {
        throw new InvalidArgumentException('Invalid name provided for slug generation.');
    }

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

}
