<?php

namespace App\Http\Controllers;


use App\Classes\Basket;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use DemeterChain\B;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function basket()
    {
        $order = (new Basket())->getOrder();
        return view('basket', compact('order'));
    }

    public function basketConfirm(Request $request)
    {
        $email = Auth::check() ? Auth::user()->email : $request->email;
        if ((new Basket())->saveOrder($request->name, $request->phone, $email)) {
            session()->flash('success', __('basket.you_order_confirmed'));
        } else {
            session()->flash('warning', __('basket.you_cant_order_more'));
        }

        Order::eraseOrderSum();

        return redirect()->route('index');
    }

    public function basketPlace()
    {
        $basket = new Basket();
        $order = $basket->getOrder();
        if (!$basket->countAvailable()) {
            session()->flash('warning', __('basket.you_cant_order_more'));
            return redirect()->route('basket');
        }
        return view('order', compact('order'));
    }

    public function add(Request $request, $skuId)
    {
        try {
            $sku = Sku::findOrFail($skuId);
            $basket = new Basket();
            if ($basket->addSku($sku)) {
                return redirect()->route('basket')->with('success', 'Product added to basket!');
            } else {
                return redirect()->route('basket')->with('error', 'Product is not available!');
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->route('basket')->with('error', 'SKU not found');
        }
    }

    public function remove(Request $request, $skuId)
    {
        try {
            $sku = Sku::findOrFail($skuId);
            $basket = new Basket();
            $basket->removeProduct($sku->product);
            return redirect()->route('basket')->with('success', 'Product removed from basket!');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('basket')->with('error', 'SKU not found');
        }
    }

}
