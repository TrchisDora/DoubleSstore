<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BrandProduct;
use Session;
use Illuminate\Support\Facades\Redirect;

class BrandProductController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    // Thêm thương hiệu sản phẩm
    public function add_brand_product()
    {
        $this->AuthLogin();
        return view('AdminPages.Pages.BrandProduct.add_brand_product');
    }

    // Lưu thương hiệu sản phẩm mới
    public function save_brand_product(Request $request)
    {
        $request->validate([
            'brand_product_name' => 'required|max:255',
            'brand_product_desc' => 'required',
            'brand_product_status' => 'required|integer'
        ]);

        $brand_slug = $this->XuLyTen($request->input('brand_product_name'));

        $existingBrand = BrandProduct::where('brand_slug', $brand_slug)->first();

        if ($existingBrand) {
            Session::put('error', 'Thêm thương hiệu sản phẩm không thành công');
            return redirect()->back();
        } else {
            BrandProduct::create([
                'brand_name' => $request->brand_product_name,
                'brand_slug' => $brand_slug,
                'brand_desc' => $request->brand_product_desc,
                'brand_status' => $request->brand_product_status
            ]);

            Session::put('message', 'Thêm thương hiệu sản phẩm thành công');
            return redirect()->back();
        }
    }

    // Hiển thị danh sách thương hiệu sản phẩm
    public function all_brand_product()
    {
        $this->AuthLogin();
        $all_brand_product = BrandProduct::paginate(10);
        return view('AdminPages.Pages.BrandProduct.all_brand_product', compact('all_brand_product'));
    }

    // Kích hoạt thương hiệu sản phẩm
    public function active_brand_product($id)
    {
        BrandProduct::where('brand_id', $id)->update(['brand_status' => 0]);
        Session::put('message', 'Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    // Không kích hoạt thương hiệu sản phẩm
    public function unactive_brand_product($id)
    {
        BrandProduct::where('brand_id', $id)->update(['brand_status' => 1]);
        Session::put('message', 'Không kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    // Sửa thương hiệu sản phẩm
    public function edit_brand_product($id)
    {
        $edit_brand_product = BrandProduct::findOrFail($id);
        return view('AdminPages.Pages.BrandProduct.edit_brand_product', compact('edit_brand_product'));
    }

    // Cập nhật thương hiệu sản phẩm
    public function update_brand_product(Request $request, $id)
    {
        $data = $request->only(['brand_product_name', 'brand_product_desc']);
        $data['brand_slug'] = $this->XuLyTen($data['brand_product_name']);
        
        $brand = BrandProduct::findOrFail($id);
        $brand->update($data);

        Session::put('message', 'Cập nhật thương hiệu sản phẩm thành công');
        return redirect()->route('all.brand.product');
    }

    // Xóa thương hiệu sản phẩm
    public function delete_brand_product($id)
    {
        BrandProduct::destroy($id);
        Session::put('message', 'Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
}
