<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\ProductVariantOption;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variantOptions.variants')->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);


       $product = Product::create([
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'price'        => $request->price,
            'quantity'     => $request->quantity,
        ]);

        $id = $product['id'] ;

        return redirect()->route('products.add_product_variant', ['id' => $product['id']])->with('message', 'Product created successfully.');
    }


    public function AddProductVariants(string $id)
    {
        $product  = Product::findOrFail($id);

        return view('products.add_product_variants', compact('product'));
    }

    public function SaveProductVariants(Request $request, string $id)
    {

        $product  = Product::findOrFail($id);
        $count    = $request->row_cnt;

        if($count != null){

            for($i=0; $i<=$count; $i++){

                $name      = 'variant_name_'.$i;
                $desc      = 'description_'.$i;

                $variant_name  =  $request->$name;
                $description   =  $request->$desc;

                if($variant_name != null && $description!= null) {

                    ProductVariant::insert([

                        'product_id'   => $id,
                        'variant_name' => $variant_name,
                        'description'  => $description,
                    ]);

                }

            }
        }


        return redirect()->back();

        // return redirect()->route('products.add_product_variant_option', ['id' => $product['id']])->with('message', 'Product created successfully.');

    }

    public function AddProductVariantOption(string $id)
    {
        $product  = Product::findOrFail($id);

        return view('products.add_product_variant_option', compact('product'));
    }

    public function SaveProductVariantOption(Request $request, string $id)
    {
        $product  = Product::findOrFail($id);

        $count    = $request->row_cnt;

        if($count != null){

            for($i=0; $i<=$count; $i++){

                $variant_id = 'variant_id_'.$i;
                $option     = 'variant_option_'.$i;
                $desc       = 'description_'.$i;

                $product_variant_id =  $request->$variant_id;
                $variant_option     =  $request->$option;
                $description        =  $request->$desc;

                if($variant_option != null && $description!= null) {

                    ProductVariantOption::insert([

                        'product_id'         => $id,
                        'product_variant_id' => $product_variant_id,
                        'variant_option'     => $variant_option,
                        'description'        => $description,
                    ]);

                }

            }
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product           = Product::findOrFail($id);
        $product_variants  = ProductVariant::where('product_id',$id)->get();
        $variant_options   = ProductVariantOption::where('product_id',$id)->get();

        return view('products.edit', compact('product','product_variants','variant_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        $product->update($request->all());

        return redirect()->route('products.index')->with('message', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function DeleteProduct($id)
    {
        $product = Product::where('id',$id)->delete();

        $product_variants = ProductVariant::where('product_id',$id)->delete();
        $variant_options  = ProductVariantOption::where('product_id',$id)->delete();

        return redirect()->back()->with('message', 'Product deleted successfully.');
    }

    public function DeleteProductVariant($id)
    {

        $product_variants = ProductVariant::where('id',$id)->delete();

        $variant_options  = ProductVariantOption::where('product_variant_id',$id)->delete();

        return redirect()->back()->with('message', 'Product Variant deleted successfully.');
    }

    public function DeleteProductVariantOption($id)
    {
        $variant_options  = ProductVariantOption::where('id',$id)->delete();

        return redirect()->back()->with('message', 'Variant Option deleted successfully.');
    }
}
