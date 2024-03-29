<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Medicine::find($request->medicines_id);
        $cart = new Cart();
        $cart->medicines_id = $request->medicines_id;
        $cart->user_id = Auth::id();
        $cart->quantity = $request->quantity;
        $cart->save();
        return redirect()->route('landing.medicine');
    }

    public function index(){
        $carts = Cart::where('user_id' , Auth::id())->get();
        return view('carts.cart' , compact('carts'));
    }

    public function updateQuantity(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = Cart::find($id);
        $cart->quantity = $validatedData['quantity'];
        $cart->save();

        return redirect()->back()->with('success', 'Item quantity updated!');
    }

    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function order(Request $request){
        $cart = Cart::where('user_id' , Auth::id())->get();
        $total = 0 ;
        foreach ($cart as $x){
            $total +=  $x->medicines->price * $x->quantity;
        }


        $order = new Order();
        if ($request->hasFile('bukti_trf')) {
            // simpan gambar jika ada
            $image = $request->file('bukti_trf');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('bukti_trf'), $imageName);
            $order->bukti_trf = $imageName;
        }
        $order->user_id = Auth::id();
        $order->status = 'sudah di bayar';
        $order->total = $total;

        $order->save();

        foreach ($cart as $x){
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->medicines_id = $x->medicines_id;
            $orderItem->quantity = $x->quantity;
            $orderItem->save();

            $x->delete();
        }

        return redirect()->back();


    }

    public function orderList(){
        $orders  = Order::where('user_id' , Auth::id())->get();
        return view('carts.order' , compact('orders'));
    }
}
