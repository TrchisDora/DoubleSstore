<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;           
use App\Models\CategoryProduct;  
use App\Models\BrandProduct;  
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;


session_start();

class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;
        $quanlity = $request->qty;
        $product_info = Product::where('product_id', $productId)->first();
    
        $data['id'] = $product_info->product_id;
        $data['qty'] = $product_info->product_quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(10);
        return Redirect::to('/show-cart');
    }
        public function show_cart(){
        // Lấy danh mục sản phẩm
        $cate_product = CategoryProduct::where('category_status', 1)->orderBy('category_id', 'desc')->get();

        // Lấy thương hiệu sản phẩm
        $brand_product = BrandProduct::where('brand_status', 0)->orderBy('brand_id', 'desc')->get();

        return view('UserPages.Pages.cart.show_cart', compact('cate_product', 'brand_product'));
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}