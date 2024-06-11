<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkuRequest;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $skus = $product->skus()->paginate(10);
        return view('auth.skus.index', compact('skus', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('auth.skus.form', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkuRequest $request, Product $product)
    {
        $params = $request->all();
        $params['product_id'] = $request->product->id;
        $skus = Sku::create($params);
        $skus->propertyOptions()->sync($request->property_id);
        return redirect()->route('skus.index', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product, Sku $skus)
    {
        return view('auth.skus.show', compact('product', 'skus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Sku $skus)
    {
        return view('auth.skus.form', compact('product', 'skus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, Sku $skus)
    {
        $params = $request->all();
        $params['product_id'] = $request->product->id;
        $skus->update($params);
        $skus->propertyOptions()->sync($request->property_id);
        return redirect()->route('skus.index', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Sku $sku)
    {
        $sku->delete();
        return redirect()->route('skus.index', $product);
    }
}
