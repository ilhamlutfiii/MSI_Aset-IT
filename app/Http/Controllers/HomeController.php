<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Pinjam;
use App\Models\AsetReview;
use App\Models\Aset;
use App\Models\Maintenance;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        $pinjams = Pinjam::with('users')
            ->where('user_id', auth()->user()->id)
            ->paginate(10);

        return view('user.index')->with('pinjams', $pinjams);
    }

    public function profile()
    {
        $profile = Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        // return $request->all();
        $user = User::findOrFail($id);
        $data = $request->all();
        $status = $user->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Successfully updated your profile');
        } else {
            session()->flash('error', 'Please try again!');
        }
        return redirect()->back();
    }

    // pinjam
    public function pinjamIndex()
    {
        $pinjams = Pinjam::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(10);
        return view('user.pinjam.index')->with('pinjams', $pinjams);
    }

    public function userpinjamDelete($id)
    {
        $pinjam = Pinjam::find($id);
        if ($pinjam) {
            $quantities = $pinjam->quantity; // Simpan jumlah yang dipinjam sebelum dihapus
            $status = $pinjam->delete();
            if ($status) {
                // Tambahkan stok aset sesuai dengan jumlah yang dipinjam sebelumnya
                $aset = $pinjam->asets;
                $aset->stock += $quantities;
                $aset->save();

                session()->flash('success', 'Pinjaman berhasil dibatalkan dan stok aset telah diperbarui.');
            } else {
                session()->flash('error', 'Gagal melakukan pembatalan.');
            }
            return redirect()->route('user.pinjam.index');
        } else {
            session()->flash('error', 'Peminjaman tidak ditemukan.');
            return redirect()->withErrors('error');
        }
    }


    public function pinjamShow($id)
    {
        $pinjam = Pinjam::find($id);
        // return $pinjam;
        return view('user.pinjam.show')->with('pinjam', $pinjam);
    }
    // Aset Review
    public function asetReviewIndex()
    {
        $reviews = AsetReview::getAllUserReview();
        return view('user.review.index')->with('reviews', $reviews);
    }

    public function asetReviewEdit($id)
    {
        $review = AsetReview::with(['asets', 'pinjams'])->find($id);
        // return $review;
        return view('user.review.edit')->with('review', $review);
    }

    public function asetReviewShow($id)
    {
        $reviews = AsetReview::with(['asets', 'user_info', 'pinjams'])->find($id);

        return view('user.review.show')->with('reviews', $reviews);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asetReviewUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1',
            'photoStatus' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk foto
            'review' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);

        $review = AsetReview::findOrFail($id);

        // Update data review
        $review->rate = $request->rate;
        $review->review = $request->review;
        $review->status = $request->status;

        // Update foto jika diunggah
        if ($request->hasFile('photoStatus')) {
            $this->validate($request, [
                'photoStatus' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $photoStatus = $request->file('photoStatus');
            $photoStatusName = time() . '.' . $photoStatus->getClientOriginalExtension();
            $photoStatus->move(public_path('photoStatus'), $photoStatusName);

            $review->pinjams->photoStatus = $photoStatusName;
            $review->pinjams->save();
        }

        $status = $review->save();

        if ($status) {
            session()->flash('success', 'Review berhasil diupdate');
        } else {
            session()->flash('error', 'Ada yang salah! Silakan coba lagi!!');
        }

        return redirect()->route('user.asetreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function asetReviewDelete($id)
    {
        $review = AsetReview::find($id);
        $status = $review->delete();
        if ($status) {
            session()->flash('success', 'Review berhasil dihapus');
        } else {
            session()->flash('error', 'Ada yang salah! Silakan coba lagi');
        }
        return redirect()->route('user.asetreview.index');
    }

    public function bantuanIndex()
    {
        $pinjams = Pinjam::orderBy('id', 'DESC')->where('user_id', auth()->user()->id)->paginate(10);

        return view('user.bantuan.index')->with('pinjams', $pinjams);
    }

    public function bantuanShow($id)
    {
        $pinjam = Pinjam::find($id);
        $aset_id = $pinjam->aset_id;

        $main = Maintenance::where('aset_id', $aset_id)->first();
        return view('user.bantuan.show', compact('pinjam', 'main'));
    }

    public function bantuanKontak()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('user.bantuan.kontak', compact('users'));
    }

    public function bantuanStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'main_id' => 'required',
            'pinjam_id' => 'required',
            'ket_main' => 'required',
            'mainPhoto' => 'image'
        ]);

        $pinjam = Pinjam::where('aset_id', $request->aset_id)->where('user_id', $request->user_id)->first();
        $maintenance = Maintenance::where('aset_id', $request->aset_id)->first();

        if (!$pinjam) {
            return redirect()->route('user.bantuan.index')->with('error', 'Data pinjam tidak ditemukan.');
        }

        if (!$maintenance) {
            return redirect()->route('user.bantuan.index')->with('error', 'Data maintenance tidak ditemukan.');
        }


        $pinjam->main_id = $request->main_id;
        $pinjam->save();

        $maintenance->pinjam_id = $request->pinjam_id;
        $maintenance->ket_main = $request->ket_main;
        $maintenance->mainStatus = $request->input('mainStatus', 'Repair');

        if ($request->hasFile('mainPhoto')) {
            $mainPhoto = $request->file('mainPhoto');
            $mainPhotoName = time() . '.' . $mainPhoto->getClientOriginalExtension();
            $mainPhoto->move(public_path('mainPhoto'), $mainPhotoName);
            $maintenance->mainPhoto = $mainPhotoName;
        }

        if ($maintenance->save()) {
            return redirect()->route('user.bantuan.index')->with('success', 'Bantuan sudah ditambahkan.');
        } else {
            return redirect()->route('user.bantuan.index')->with('error', 'Gagal menyimpan bantuan.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function changePassword()
    {
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('user')->with('success', 'Password successfully changed');
    }
}
