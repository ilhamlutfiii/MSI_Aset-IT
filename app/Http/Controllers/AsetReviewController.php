<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\aset;
use App\Models\pinjam;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatusNotification;
use App\User;
use App\Models\AsetReview;

class AsetReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = AsetReview::getAllReview();

        return view('backend.review.index')->with('reviews', $reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Tambahkan use statement


    public function store(Request $request)
{
    $this->validate($request, [
        'rate' => 'required|numeric|min:1',
    ]);

    $aset_info = Aset::getAsetBySlug($request->slug);

    $data = $request->except('photoStatus'); // Ambil semua data kecuali photoStatus
    $data['aset_id'] = $aset_info->id;
    $data['pinjam_id'] = $request->id_pinjam;
    $data['user_id'] = $request->user()->id;
    $data['status'] = 'active';

    $photoStatusName = null; // Inisialisasi $photoStatusName

    if ($request->hasFile('photoStatus')) {
        $photoStatus = $request->file('photoStatus');
        $photoStatusName = time() . '.' . $photoStatus->getClientOriginalExtension();
        $photoStatus->move(public_path('photoStatus'), $photoStatusName);
    }

    if ($photoStatusName) {
        $data['photoStatus'] = $photoStatusName;
    }

    $status = AsetReview::create($data);

    $pinjam = Pinjam::find($request->id_pinjam);
    $pinjam->status = 'Cek Kondisi Aset';

    if ($photoStatusName) {
        $pinjam->photoStatus = $photoStatusName;
    }

    $pinjam->save();

    // Mengirim notifikasi
    $reviews = AsetReview::with(['asets', 'user_info', 'pinjams'])->find($status->id); // Menggunakan $status->id untuk ID review yang baru dibuat
    $user = User::where('role', 'admin')->get();
    $details = [
        'title' => 'Rating Aset Baru!',
        'actionURL' => route('review.show', $reviews->id),
        'fas' => 'fa-star'
    ];
    Notification::send($user, new StatusNotification($details));

    if ($status) {
        session()->flash('success', 'Terima Kasih Atas Feedbacknya');
    } else {
        session()->flash('error', 'Gagal, Silakan Coba Lagi!!');
    }

    return redirect()->back();
}




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reviews = AsetReview::with(['asets', 'user_info', 'pinjams'])->find($id);

        return view('backend.review.show', compact('reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = asetReview::find($id);
        // return $review;
        return view('backend.review.edit')->with('review', $review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $review = asetReview::find($id);
        if ($review) {
            $data = $request->all();
            $status = $review->fill($data)->update();
            if ($status) {
                session()->flash('success', 'Review Successfully updated');
            } else {
                session()->flash('error', 'Something went wrong! Please try again!!');
            }
        } else {
            session()->flash('error', 'Review not found!!');
        }

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = asetReview::find($id);
        $status = $review->delete();
        if ($status) {
            session()->flash('success', 'Successfully deleted review');
        } else {
            session()->flash('error', 'Something went wrong! Try again');
        }
        return redirect()->route('review.index');
    }
}
