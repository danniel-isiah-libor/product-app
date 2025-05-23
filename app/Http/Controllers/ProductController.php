<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('updated_at', 'desc')->paginate(5);

        return view('dashboard', [
            'products' => $products,
        ]);
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
        $form = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|max:255|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'is_active' => 'string|nullable',
        ]);

        if ($form['is_active'] === 'on') {
            $form['is_active'] = true;
        }

        Product::create($form);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) // Product::where('id', 1)->first();
    {
        return view('products.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
