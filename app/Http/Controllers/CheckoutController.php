<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;           
use App\Models\CategoryProduct;  
use App\Models\BrandProduct;
use App\Models\customer; 
use App\Models\Shipping;
use App\Models\payment;
use Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;


class CheckoutController extends Controller
{
    public function login_checkout(){
       // Lấy danh mục sản phẩm
       $cate_product = CategoryProduct::where('category_status', 1)->orderBy('category_id', 'desc')->get();

       // Lấy thương hiệu sản phẩm
       $brand_product = BrandProduct::where('brand_status', 0)->orderBy('brand_id', 'desc')->get();

       // Truyền dữ liệu vào view
       return view('UserPages.Pages.checkout.login_checkout', compact('cate_product', 'brand_product'));
    }
    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = customer::insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect('/checkout');
    
    }
    public function checkout(){
        // Lấy danh mục sản phẩm
        $cate_product = CategoryProduct::where('category_status', 1)->orderBy('category_id', 'desc')->get();

        // Lấy thương hiệu sản phẩm
        $brand_product = BrandProduct::where('brand_status', 0)->orderBy('brand_id', 'desc')->get();

        return view('UserPages.Pages.checkout.show_checkout', compact('cate_product', 'brand_product'));
    }
    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_method'] = $request->shipping_method;
        $data['shipping_address'] = $request->shipping_address;

        $shipping_id = Shipping::insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        
        return Redirect('/payment');
    
    }
    public function payment(){
        // Lấy danh mục sản phẩm
        $cate_product = CategoryProduct::where('category_status', 1)->orderBy('category_id', 'desc')->get();

        // Lấy thương hiệu sản phẩm
        $brand_product = BrandProduct::where('brand_status', 0)->orderBy('brand_id', 'desc')->get();

        return view('UserPages.Pages.checkout.payment', compact('cate_product', 'brand_product'));

    }
    public function logout_checkout(){
        Session::flush();
        return Redirect('/login-checkout');
    }
    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = Customer::where('customer_email', $email)
                  ->where('customer_password', $password)
                  ->first();
                  
        if($result){
            Session::put('customer_id',$result->customer_id);
            return Redirect::to('/checkout');
        }else{
            return Redirect::to('/login-checkout');
        }
        
    }
    public function order_place(Request $request){
        $data = array();
        $data['payment_method'] = $request->payment_method;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = payment::insertGetId($data);

        $order_data = array();
        $order_data['customer_id'] = $request->payment_method;
        $order_data['shipping_id'] = 'Đang chờ xử lý';
        $payment_id = payment::insertGetId($data);

        Session::put('shipping_id',$shipping_id);
        
        return Redirect('/payment');
    }
}