<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Models\ProductVariantOption;
use Illuminate\Support\Facades\Session;

class cartController extends Controller
{
    public function AllProducts()
    {

        // $products = Product::with('variantOptions.variants')->get();
        $products = ProductVariantOption::with('variants','product')->get();

        return view('frontend.all_products', compact('products'));
    }

    public function AddToCart(Request $request)
    {

        $product_id        = $request->product_id;
        $quantity          = $request->quantity;
        $price             = $request->price;
        $totalPrice        = $request->totalPrice;
        $variant_option_id = $request->variant_option_id;
        $variant_id        = $request->variant_id       ;

        $id = ProductVariantOption::where('id',$product_id)->pluck('product_id')->first();
        $productname = Product::where('id',$id)->pluck('product_name')->first();

        $cart = session()->get('cart', []);

            if (isset($cart[$product_id])) {

                return redirect()->back();
            }else {

                $cart[$product_id] = [

                    "id"                => $product_id,
                    "variant_id"        => $variant_id ?? 0,
                    "variant_option_id" => $variant_option_id ?? 0,
                    "product_name"      => $productname,
                    "quantity"          => $quantity,
                    "price"             => $price,
                    "total_price"       => $totalPrice,
                ];
            }
            session()->put('cart', $cart);

        return redirect()->back();

    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $count = count($cart);

        return response()->json(['count' => $count]);
    }



    public function Cart()
    {

        return view('frontend.cart');
    }

    public function UpdateCart(Request $request)
    {

        $product_id = $request->product_id;
        $quantity   = $request->quantity;
        $price      = $request->price;
        $totalPrice = $request->totalPrice;

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {

            $cart[$product_id]['quantity']    = $quantity;
            $cart[$product_id]['total_price'] = $totalPrice;
            session()->put('cart', $cart);

        }
    }

    public function DeleteCart(Request $request)
    {
        $id = $request->id;
        if(Session::has('cart')){

            Session::forget('cart.' . $id);

            return redirect()->back()->with('error','Product removed successfully');
        }
    }
}
