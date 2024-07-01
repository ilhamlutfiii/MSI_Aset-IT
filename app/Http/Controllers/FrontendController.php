<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Category;
use App\Models\Cart;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Newsletter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FrontendController extends Controller
{

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home()
    {
        $featured = Aset::where('status', 'active')->where('is_featured', 1);
        $asets = Aset::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();
        // return $category;
        return view('frontend.index')
            ->with('featured', $featured)
            ->with('aset_lists', $asets)
            ->with('category_lists', $category);
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function asetDetail($slug)
    {
        $aset_detail = Aset::getAsetBySlug($slug);
        // dd($aset_detail);
        return view('frontend.pages.aset_detail')->with('aset_detail', $aset_detail);
    }

    public function asetGrids()
    {
        $asets = Aset::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $asets->whereIn('cat_id', $cat_ids);
            // return $asets;
        }

        $recent_asets = Aset::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $asets = $asets->where('status', 'active')->paginate($_GET['show']);
        } else {
            $asets = $asets->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category


        return view('frontend.pages.aset-grids')->with('asets', $asets)->with('recent_asets', $recent_asets);
    }
    public function asetLists()
    {
        $asets = Aset::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $asets->whereIn('cat_id', $cat_ids)->paginate;
            // return $asets;
        }

        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $asets = $asets->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $asets = $asets->orderBy('price', 'ASC');
            }
        }

        $recent_asets = Aset::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $asets = $asets->where('status', 'active')->paginate($_GET['show']);
        } else {
            $asets = $asets->where('status', 'active')->paginate(3);
        }
        // Sort by name , price, category


        return view('frontend.pages.aset-lists')->with('asets', $asets)->with('recent_asets', $recent_asets);
    }
    public function asetFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }

        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        if (request()->is('aset-it.loc/aset-grids')) {
            return redirect()->route('aset-grids', $catURL . $showURL . $sortByURL);
        } else {
            return redirect()->route('aset-lists', $catURL . $showURL . $sortByURL);
        }
    }
    public function asetSearch(Request $request)
    {
        $recent_asets = Aset::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $asets = Aset::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('6');
        return view('frontend.pages.aset-grids')->with('asets', $asets)->with('recent_asets', $recent_asets);
    }

    public function asetCat(Request $request)
    {
        $asetsQuery = Category::getAsetByCat($request->slug); 
        $asets = $asetsQuery->cat_asets()->paginate(3);
        // return $request->slug;
        $recent_asets = Aset::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('aset-it.loc/aset-grids')) {
            return view('frontend.pages.aset-grids')->with('asets', $asets->asets)->with('recent_asets', $recent_asets);
        } else {
            return view('frontend.pages.aset-lists')->with('asets', $asets)->with('recent_asets', $recent_asets);
        }
    }

    public function asetSubCat(Request $request)
    {
        $asetsQuery = Category::getAsetBySubCat($request->sub_slug);
        $asets = $asetsQuery->sub_asets()->paginate(3);
        // return $asets;
        $recent_asets = Aset::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('aset-it.loc/aset-grids')) {
            return view('frontend.pages.aset-grids')->with('asets', $asets)->with('recent_asets', $recent_asets);
        } else {
            return view('frontend.pages.aset-lists')->with('asets', $asets)->with('recent_asets', $recent_asets);
        }
    }


    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['user_nid' => $data['user_nid'], 'password' => $data['password'], 'status' => 'active'])) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                Session::put('user', $user->user_nid);
                session()->flash('success', 'Berhasil Login');
                return redirect()->route('admin');
            } else {
                Session::put('user', $user->user_nid);
                session()->flash('success', 'Berhasil Login');
                return redirect()->route('home');
            }
        } else {
            session()->flash('error', 'User NID atau Password anda salah!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        session()->flash('success', 'Logout Berhasil');
        return back();
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }
}
