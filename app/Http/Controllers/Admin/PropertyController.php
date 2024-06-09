<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::paginate(10);
        return view('auth.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.properties.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PropertyRequest $request)
    {
        Property::create($request->all());
        return redirect()->route('skus.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $sku)
    {
        return view('auth.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $sku)
    {
        return view('auth.properties.form', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PropertyRequest $request, Property $sku)
    {
        $sku->update($request->all());
        return redirect()->route('skus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $sku)
    {
        $sku->delete();
        return redirect()->route('skus.index');
    }
}