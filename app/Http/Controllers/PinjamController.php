<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Pinjam;
use App\Models\AsetReview;
use App\User;
use Helper;
use Illuminate\Support\Facades\PDF;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Notifications\StatusNotification;


class PinjamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pinjams = Pinjam::with('asets')->orderBy('id', 'DESC')->paginate(10);
        return view('backend.pinjam.index')->with('pinjams', $pinjams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. Cek Data Cart
        $cartItems = Cart::where('user_id', auth()->user()->id)
            ->where('pinjam_id', null)
            ->get();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Keranjang Belanja Kosong!');
            return back();
        }

        DB::beginTransaction(); // Mulai transaksi

        try {
            foreach ($cartItems as $cartItem) {
                // 2. Membuat entri pinjam untuk setiap aset dalam keranjang
                $pinjamEntry = Pinjam::create([
                    'pinjam_number' => 'ASET-' . strtoupper(Str::random(10)),
                    'user_id' => $request->user()->id,
                    'aset_id' => $cartItem->aset->id,
                    'quantity' => $cartItem->quantity,
                    'status' => "Baru",
                    'photoStatus' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Mengurangi stok aset sesuai dengan jumlah yang dipinjam
                $aset = $cartItem->aset;
                $aset->stock -= $cartItem->quantity;
                $aset->save();

                // 3. Memperbarui cart untuk menandai aset sudah dipinjam
                $cartItem->pinjam_id = $pinjamEntry->id; // Set pinjam_id dengan ID pinjam yang baru dibuat
                $cartItem->save();
            }

            DB::commit(); // Commit transaksi

            if ($pinjamEntry)
                $users = User::where('role', 'admin')->first();
            $details = [
                'title' => 'Ada Peminjaman Baru',
                'actionURL' => route('pinjam.show', $pinjamEntry->id),
                'fas' => 'fa-file-alt'
            ];
            Notification::send($users, new StatusNotification($details));

            session()->flash('success', 'Aset berhasil dipinjam dan stok aset telah diperbarui!');
            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan
            session()->flash('error', 'Gagal membuat pinjam. Error: ' . $e->getMessage()); // Menampilkan pesan kesalahan yang spesifik
            return back();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Ambil data peminjaman berdasarkan pinjamId
        $pinjam = Pinjam::findOrFail($id);

        // Kirim data pinjam dan reviews ke view
        return view('backend.pinjam.show', compact('pinjam'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pinjam = Pinjam::find($id);
        return view('backend.pinjam.edit')->with('pinjam', $pinjam);
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
        $pinjam = Pinjam::find($id);

        $this->validate($request, [
            'status' => 'required|in:Baru,Diproses,Siap Diambil,Telah Diambil,Dibatalkan,Dikembalikan,Cek Kondisi Aset,Selesai',
        ]);

        // Mengambil data status dan foto
        $data = $request->only('status');
        $photoStatusName = null;


        // Memproses foto status jika ada
        if ($request->hasFile('photoStatus')) {
            $photoStatus = $request->file('photoStatus');
            $photoStatusName = time() . '.' . $photoStatus->getClientOriginalExtension();
            $photoStatus->move(public_path('photoStatus'), $photoStatusName);
        }

        // Jika status adalah 'Cek Kondisi Aset' dan aman, maka set status 'Selesai'
        if ($request->status == 'Cek Kondisi Aset' && $request->has('is_asset_safe') && $request->is_asset_safe == true) {
            $data['status'] = 'Selesai';
        }

        // Memasukkan nama foto status ke dalam data jika ada
        if ($photoStatusName) {
            $data['photoStatus'] = $photoStatusName;
        }

        // Memperbarui data peminjaman dengan data yang telah disiapkan
        $status = $pinjam->update($data);

        // Memberikan pesan sesuai dengan status pembaruan
        if ($status) {
            session()->flash('success', 'Peminjaman berhasil diupdate');
        } else {
            session()->flash('error', 'Error updating Pinjam');
        }

        return redirect()->route('pinjam.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pinjam = Pinjam::findOrFail($id);
        $pinjam->status = 'Dibatalkan';
        $pinjam->keterangan = $request->reason;
        $pinjam->save();

        $aset = $pinjam->asets;
        if ($aset) {
            $aset->stock += $pinjam->quantity;
            $aset->save();
        }
    
        return redirect()->route('pinjam.index')->with('success', 'Peminjaman berhasil dibatalkan dengan alasan: ' . $request->reason);
    }
    

    public function return($id)
    {
        $pinjam = Pinjam::findOrFail($id);

        // Periksa jika status pinjam sudah Selesai, tidak perlu proses lebih lanjut
        if ($pinjam->status == 'Selesai') {
            session()->flash('error', 'Pinjaman ini sudah dikembalikan.');
            return redirect()->back();
        }

        // Update status pinjaman menjadi Dikembalikan
        $pinjam->status = 'Dikembalikan';
        $pinjam->save();


        $aset = $pinjam->asets; // Asumsikan relasi ini ada
        if ($aset) {
            $aset->stock += $pinjam->quantity; // Kembalikan stok
            $aset->save();
        }

        session()->flash('success', 'Pinjaman berhasil dikembalikan dan stok aset telah diperbarui');
        return redirect()->back();
    }



    public function pinjamTrack()
    {
        return view('frontend.pages.pinjamanku');
    }
}
