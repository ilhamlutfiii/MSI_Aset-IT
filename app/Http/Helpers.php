<?php
use App\Models\Message;
use App\Models\Category;
use App\Models\Pinjam;
use App\Models\Wishlist;
use App\Models\Cart;
use App\User;
use Illuminate\Support\Facades\Auth;

class Helper{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    } 
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    } 
    
    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>
            
            <li>
            <a href="javascript:void(0);">Kategori<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('aset-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('aset-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('aset-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function AsetCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('asets')->orderBy('id','DESC')->get();
    }

    
    // Cart Count
    public static function cartCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('pinjam_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    


    public static function getAllAsetFromCart($user_id = '')
{
    if (Auth::check()) {
        if ($user_id == "") {
            $user_id = auth()->user()->id;
        }

        return Cart::with('aset')->where('user_id', $user_id)->where('pinjam_id', null)->get();
    } else {
        return []; // Mengembalikan array kosong jika pengguna tidak terautentikasi.
    }
}

    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('pinjam_id',null);
        }
        else{
            return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function getAllAsetFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('aset')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return [];
        }
    }

}

?>