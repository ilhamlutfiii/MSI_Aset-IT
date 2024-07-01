<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    protected $aset=null;
    public function __construct(Aset $aset){
        $this->aset=$aset;
    }

    public function wishlist(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            session()->flash('error','Invalid asets');
            return back();
        }        
        $aset = Aset::where('slug', $request->slug)->first();
        // return $aset;
        if (empty($aset)) {
            session()->flash('error','Invalid asets');
            return back();
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('aset_id', $aset->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            session()->flash('error','Sudah ditambahkan di wishlist');
            return back();
        }else{
            
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->aset_id = $aset->id;
            $wishlist->quantity = 1;
            if ($wishlist->aset->stock < $wishlist->quantity || $wishlist->aset->stock <= 0) return back()->with('error','Stok tidak mencukupi!.');
            $wishlist->save();
        }
        session()->flash('success','Aset berhasil ditambahkan ke wishlist');
        return back();       
    }  
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            session()->flash('success','Wishlist berhasil dihapus');
            return back();  
        }
        session()->flash('error','Error please try again');
        return back();       
    }     
}
