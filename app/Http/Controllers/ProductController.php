<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-product|edit-product|delete-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('products.index', [
            'products' => Product::latest()->paginate(3),
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'permissions' => Permission::get(),
        ]);

    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->all());
        return redirect()->route('products.index')
            ->withSuccess('New product is added successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->back()
            ->withSuccess('Product is updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->withSuccess('Product is deleted successfully.');
    }
}
