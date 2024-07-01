<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\aset;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;
class CartController extends Controller
{
    protected $aset=null;
    public function __construct(Aset $aset){
        $this->aset=$aset;
    }

    public function addToCart(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            session()->flash('error','Invalid Asets');
            return back();
        }        
        $aset = Aset::where('slug', $request->slug)->first();
        // return $aset;
        if (empty($aset)) {
            session()->flash('error','Invalid Asets');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('pinjam_id',null)->where('aset_id', $aset->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            // return $already_cart->quantity;
            if ($already_cart->aset->stock < $already_cart->quantity || $already_cart->aset->stock <= 0) return back()->with('error','Stok tidak mencukupi!.');
            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->aset_id = $aset->id;
            $cart->quantity = 1;
            if ($cart->aset->stock < $cart->quantity || $cart->aset->stock <= 0) return back()->with('error','Stok tidak mencukupi!.');
            $cart->save();
            $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
        }
        session()->flash('success','Aset berhasil ditambahkan ke keranjang');
        return back();       
    }  

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $aset = Aset::where('slug', $request->slug)->first();
        if($aset->stock <$request->quant[1]){
            return back()->with('error','Stok habis!');
        }
        if ( ($request->quant[1] < 1) || empty($aset) ) {
            session()->flash('error','Invalid Asets');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('pinjam_id',null)->where('aset_id', $aset->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];

            if ($already_cart->aset->stock < $already_cart->quantity || $already_cart->aset->stock <= 0) return back()->with('error','Stok tidak mencukupi!.');

            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->aset_id = $aset->id;
            $cart->quantity = $request->quant[1];
            if ($cart->aset->stock < $cart->quantity || $cart->aset->stock <= 0) return back()->with('error','Stok tidak mencukupi!.');
            // return $cart;
            $cart->save();
        }
        session()->flash('success','Aset berhasil ditambahkan ke keranjang');
        return back();       
    } 
    
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            session()->flash('success','Aset yang dipilih berhasil dihapus');
            return back();  
        }
        session()->flash('error','Error please try again');
        return back();       
    }     

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    if($cart->aset->stock < $quant){
                        session()->flash('error','Stok Habis!');
                        return back();
                    }
                    $cart->quantity = ($cart->aset->stock > $quant) ? $quant  : $cart->aset->stock;
                    // return $cart;
                    
                    if ($cart->aset->stock <=0) continue;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Keranjang berhasil diupdate!';
                }else{
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }    
    }
}
