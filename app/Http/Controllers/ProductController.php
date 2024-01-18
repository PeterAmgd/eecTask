<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->search;
        // dd($searchTerm);
        $products = $this->productService->searchProducts($searchTerm);

        if ($request->wantsJson()) {
            return ProductResource::collection($products);
        }

        return view('products.index')->with('products', $products);
    }
    public function search(Request $request)
    {
        $searchTerm = $request->search;
        $products = $this->productService->searchProducts($searchTerm);

        return response()->json(['products' => $products]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->all();

        $image_path = '';

        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('products', 'public');
        }
        $product = $this->productService->createProduct($data, $image_path);


        if (!$product) {
            return redirect()->back()->with('error', __('product.error_creating'));
        }
        return redirect()->route('products.index')->with('success', __('product.success_creating'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return response()->json([
            'product' => $product,
            'pharmacies' => $product->pharmacies,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit')->with('product', $product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::delete($product->image);
            }
            // Store image
            $image_path = $request->file('image')->store('products', 'public');
            // Save to Database
            $product->image = $image_path;
        }
        $product = $this->productService->updateProduct($data, $product,$product->image);

        if (!$product->save()) {
            return redirect()->back()->with('error', __('product.error_updating'));
        }
        return redirect()->route('products.index')->with('success', __('product.success_updating'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // return dd($product);
        if ($product->image) {
            Storage::delete($product->image);
        }
        $product = $this->productService->deleteProduct($product);

        return response()->json([
            'success' => true
        ]);
    }

    public function attachProduct(Request $request, Product $product)
    {
        $pharmaciesWithPrices = $request->pharmaciesWithPrices;
        $product = $this->productService->attachProduct($product, $pharmaciesWithPrices);

        return response()->json([
            'success' => true
        ]);
    }
}
