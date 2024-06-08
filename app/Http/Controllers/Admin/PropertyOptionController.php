<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyOption;
use Illuminate\Http\Request;

class PropertyOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Property $property)
    {
        $properties = Property::get();
        $propertyOptions = PropertyOption::paginate(10);
        return view('auth.property_options.index', compact('propertyOptions', 'property'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Property $property)
    {
        return view('auth.property_options.form', compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Property $property)
    {
        $params = $request->all();
        $params['property_id'] = $request->property->id;

        PropertyOption::create($params);
        return redirect()->route('property-options.index', $property);
    }

    /**
     * Display the specified resource.
     */
    public function show(PropertyOption $propertyOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyOption $propertyOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyOption $propertyOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyOption $propertyOption)
    {
        //
    }
}
