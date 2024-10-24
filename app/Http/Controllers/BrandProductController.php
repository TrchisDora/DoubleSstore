<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandProduct;
use Session;

class BrandProductController extends Controller
{
    public function add_brand_product()
    {
        return view('AdminPages.Pages.BrandProduct.add_brand_product'); // Tạo view cho thêm thương hiệu
    }

    public function save_brand_product(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'brand_product_name' => 'required|max:255',
            'brand_product_desc' => 'required',
            'brand_product_status' => 'required|integer'
        ]);

        // Tạo slug từ tên thương hiệu
        $brand_slug = $this->generateSlug($request->input('brand_product_name'));

        // Kiểm tra xem thương hiệu đã tồn tại chưa
        $existingBrand = BrandProduct::where('brand_slug', $brand_slug)->first();

        if ($existingBrand) {
            // Nếu thương hiệu đã tồn tại, trả về thông báo lỗi
            Session::put('error', 'Thêm thương hiệu sản phẩm không thành công');
            return redirect()->back();
        } else {
            // Tạo và lưu thương hiệu mới
            $brandProduct = new BrandProduct();
            $brandProduct->brand_name = $request->brand_product_name;
            $brandProduct->brand_slug = $brand_slug; // Sử dụng slug đã tạo
            $brandProduct->brand_desc = $request->brand_product_desc;
            $brandProduct->brand_status = $request->brand_product_status;
            $brandProduct->save();

            // Hiển thị thông báo khi thêm thành công
            Session::put('message', 'Thêm thương hiệu sản phẩm thành công');
            return redirect()->back();
        }
    }

    public function all_brand_product()
    {
        $all_brand_product = BrandProduct::paginate(10); 
        return view('AdminPages.Pages.BrandProduct.all_brand_product', compact('all_brand_product'));
    }

    // Hàm tạo slug từ tên thương hiệu
    private function generateSlug($name)
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[àáảãạâầấẩẫậ]/u', 'a', $slug);
        $slug = preg_replace('/[èéẻẽẹêềếểễệ]/u', 'e', $slug);
        $slug = preg_replace('/[ìíỉĩị]/u', 'i', $slug);
        $slug = preg_replace('/[òóỏõọôồốổỗộơờớởỡợ]/u', 'o', $slug);
        $slug = preg_replace('/[ùúủũụưừứửữự]/u', 'u', $slug);
        $slug = preg_replace('/[ỳýỷỹỵ]/u', 'y', $slug);
        $slug = preg_replace('/[đ]/u', 'd', $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }
}
