<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Order, App\Http\Models\OrdersItem, App\Http\Models\Product, App\Http\Models\Stock, App\Http\Models\Variant;
use Auth;
use Symfony\Component\Console\Input\Input;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCart(){
        $order = $this->getUserOrder();
        $items = $order->getItems;
        $shipping = $this->getShippingValue($order->id);
        //return $shipping;
        $data = ['order' => $order, 'items' => $items, 'shipping' => $shipping];
        return view('cart', $data);
    }

    public function getUserOrder(){
        $order = Order::where('status', '0')->count();
        if($order == "0"):
            $order = new Order;
            $order->user_id = Auth::id();
            $order->save();
        else:
            $order = Order::where('status', '0')->where('user_id', Auth::id())->first();
        endif;
        return $order;
    }

    public function getShippingValue($order_id){
        $order = Order::find($order_id);
        $shipping_method = config('cms.shipping_method');

        if($shipping_method == "0"):
            $price = '0.00';
        endif;

        if($shipping_method == "1"):
            $price = config('cms.shipping_default_value');
        endif;

        if($shipping_method == "3"):
            if($order->getSutotal() >=config('cms.shipping_amount_min')):
                $price = '0.00';
            else:
                $price = config('cms.shipping_default_value');
            endif;        
        endif;
        $order->subtotal = $order->getSubtotal();
        $order->delivery = $price;
        $order->total = $order->getSubtotal() + $price;
        $order->save();

        return $price;
    }

    public function postCartAdd(Request $request, $id){
        if(is_null($request->input('stock'))):
            return back()->with('message','Seleccione una opción del producto')->with('typealert','danger');
        else:
            $stock = Stock::where('id', $request->input('stock'))->count();
            if($stock == "0"):
                return back()->with('message','La opción seleccionada no esta disponible.')->with('typealert','danger');
            else:
                $stock = Stock::find($request->input('stock'));
                if($stock->product_id != $id):
                    return back()->with('message','No podemos agregar este producto al carrito')->with('typealert','danger');
                else:
                    $order = $this->getUserOrder();
                    $product = Product::find($id);
                    
                    if($request->input('quantity') < 1):
                        return back()->with('message','Es necesario ingresar la cantidad que desea ordenar de este producto')->with('typealert','danger'); 
                    else:
                        if($stock->limited == "0"):
                            if($request->input('quantity') > $stock->quantity):
                                return back()->with('message','No disponemos de esa cantidad en inventario de este producto')->with('typealert','danger');
                            endif; 
                        endif;
                        if(count(collect($stock->getVariants)) > "0"):
                            if($request->input('variant')):
                                return back()->with('message','Seleccione todas las opciones del producto')->with('typealert','danger');
                            endif;
                        endif;

                        if(!is_null($request->input('variant'))):
                            $variant = Variant::where('id', $request->input('variant'))->count();
                            if($variant == "0"):
                                return back()->with('message','Selección no encontrada')->with('typealert','danger');
                            else:
                                $variant = Variant::find($request->input('variant'));
                                if($variant->stock_id != $stock->id):
                                    return back()->with('message','Selección no valida')->with('typealert','danger');
                                endif;
                            endif;
                        endif; 
                        
                        $query = OrdersItem::where('order_id', $order->id)->where('product_id', $product->id)->count();
                        if($query == 0):
                            $oitem = new OrdersItem;
                            $price =  $this->getCalculatePrice($product->in_discount, $product->discount, $stock->price);
                            $total = $price * $request->input('quantity');
                            if($request->input('variant')):
                                $variant = Variant::find($request->input('variant'));
                                $variant_label = '/'.$variant->name;
                            else:
                                $variant_label ='';
                            endif;
                            $label = $product->name.'/'.$stock->name.$variant_label;
                            $oitem->user_id = Auth::id();
                            $oitem->order_id = $order->id;
                            $oitem->product_id = $id;
                            $oitem->stock_id = $request->input('stock');
                            $oitem->variant_id = $request->input('variant');
                            $oitem->label_item = $label;
                            $oitem->quantity= $request->input('quantity');
                            $oitem->discount_status= $product->in_discount;
                            $oitem->discount= $product->discount;
                            $oitem->discount_until_date= $product->discount_until_date;
                            $oitem->price_initial = $stock->price;
                            $oitem->price_unit = $price;
                            $oitem->total = $total;
                
                            if($oitem->save()):
                                return back()->with('message','Producto agregado al carrito de compras')->with('typealert','success');
                            endif;
                        else:
                            return back()->with('message','Este producto ya esta en su carrito de compra')->with('typealert','danger');
                        endif;
                    endif;
                endif;
            endif;
        endif;
    }

    public function postCartItemQuantityUpdate($id, Request $request){
        $order = $this->getUserOrder();
        $oitem = OrdersItem::find($id);
        $stock = Stock::find($oitem->stock_id);
        //$product = Product::find($oitem->product_id);
        if($order->id != $oitem->order_id):
            return back()->with('message','No podemos actualizar la cantidad de este producto')->with('typealert','danger');
        else:
            if($stock->limited == "0"):
                if($request->input('quantity') > $stock->quantity):
                    return back()->with('message','La cantidad ingresada supera al inventario')->with('typealert','danger');
                endif;
            endif;

            $total = $oitem->price_unit * $request->input('quantity');
            $oitem->quantity = $request->input('quantity');
            $oitem->total = $total;

            if($oitem->save()):
                return back()->with('message','Cantidad actualizada con éxito')->with('typealert','success');
            endif;
        endif;
    }

    public function getCartItemDelete($id){
        $oitem = OrdersItem::find($id);
        if($oitem->delete()):
            return back()->with('message','Producto eliminado del carrito con éxito')->with('typealert','success');
        endif;
    }
    
    public function getCalculatePrice($in_discount, $discount, $price){
        $final_price = $price;
        if($in_discount == "1"):
            $discount_value = '0.'.$discount;
            $discount_calc = $price * $discount_value;
            $final_price = $price - $discount_calc;
        endif;
        return $final_price;
    }

}
