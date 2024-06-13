<?php

namespace App\Classes;

use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Basket
{
    protected $order;

    /**
     * Basket constructor.
     * @param  bool  $createOrder
     */
    public function __construct($createOrder = false)
    {

        $orderId = session('orderId');

        if (is_null($orderId) && $createOrder) {
            $data = [];
            if (Auth::check()) {
                $data['user_id'] = Auth::id();
            }

            $this->order = Order::create($data);
            session(['orderId' => $this->order->id]);
        } else {
            $this->order = Order::findOrFail($orderId);
        }
    }
//    public function __construct($createOrder = false)
//    {
//        $orderId = session('orderId');
//
//        if (is_null($orderId) && $createOrder) {
//            // Создаем новый заказ, если он не найден в сессии и нужно создать новый
//            $this->order = Order::create(['user_id' => Auth::id()]);
//            session(['orderId' => $this->order->id]);
//        } elseif (!is_null($orderId)) {
//            // Находим заказ по ID из сессии
//            $this->order = Order::find($orderId);
//        }
//
//        // Если заказ все еще null, создаем новый заказ
//        if (is_null($this->order)) {
//            $this->order = Order::create(['user_id' => Auth::id()]);
//            session(['orderId' => $this->order->id]);
//        }
//    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function countAvailable($updateCount = false)
    {
        foreach ($this->order->products as $orderProduct)
        {
            if ($orderProduct->count < $this->getPivotRow($orderProduct)->count) {
                return false;
            }
            if ($updateCount) {
                $orderProduct->count -= $this->getPivotRow($orderProduct)->count;
            }
        }

        if ($updateCount) {
            $this->order->products->map->save();
        }

        return true;
    }

    public function saveOrder($name, $phone, $email)
    {
        if (!$this->countAvailable(true)) {
            return false;
        }
        Mail::to($email)->send(new OrderCreated($name, $this->getOrder()));
        return $this->order->saveOrder($name, $phone);
    }

    protected function getPivotRow($product)
    {
        return $this->order->products()->where('product_id', $product->id)->first()->pivot;
    }

    public function removeProduct(Product $product)
    {
        if ($this->order->products->contains($product->id)) {
            $pivotRow = $this->getPivotRow($product);
            if ($pivotRow->count < 2) {
                $this->order->products()->detach($product->id);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }

        Order::changeFullSum(-$product->price);
    }

    public function addSku(Sku $skus)
    {
        if ($this->order->skus->contains($skus)) {
            $pivotRow = $this->order->skus->where('id', $skus->id)->first();
            if ($pivotRow->countInOrder >= $skus->count) {
                return false;
            }
            $pivotRow->countInOrder++;
        } else {
            if ($skus->count == 0) {
                return false;
            }
            $skus->countInOrder = 1;
            $this->order->skus->push($skus);
        }

        return true;
    }
}
