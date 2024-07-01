<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Aset;
use App\Models\MaintenanceLog;
use Illuminate\Support\Facades\App;

class MaintenanceController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maintenances = Maintenance::with('asets')->paginate(10);
        return view('backend.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $asets = Aset::all();
        return view('backend.maintenance.create', compact('asets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required',
            'mainStatus' => 'required|in:Diperbaiki,Sedang Diproses,Maintenance,Selesai,Repair',
            'mainPhoto' => 'image|mimes:jpeg,png,jpg,gif'
        ]);

        $maintenance = Maintenance::where('aset_id', $request->aset_id)->first();

        if (!$maintenance) {
            return redirect()->route('maintenance.index')->with('error', 'Data maintenance tidak ditemukan.');
        }

        $maintenance->mainStatus = $request->mainStatus;
        if ($request->hasFile('mainPhoto')) {
            $mainPhoto = $request->file('mainPhoto');
            $mainPhotoName = time() . '.' . $mainPhoto->getClientOriginalExtension();
            $mainPhoto->move(public_path('mainPhoto'), $mainPhotoName);
            $maintenance->mainPhoto = $mainPhotoName;
        }

        if ($maintenance->save()) {
            // Tambahkan log history hanya jika mainStatus adalah "Selesai"
            if ($request->mainStatus == 'Selesai') {
                $log = new MaintenanceLog();
                $log->maintenance_id = $maintenance->id;
                $log->aset_id = $maintenance->aset_id;
                $log->status = $request->mainStatus;
                $log->mainPhoto = $mainPhotoName;
                $log->ket_main = ($maintenance->ket_main == NULL) ? 'Maintenance Rutin' : $maintenance->ket_main;
                $log->save();
            }

            return redirect()->route('maintenance.index')->with('success', 'Maintenance berhasil disimpan.');
        } else {
            return redirect()->route('maintenance.index')->with('error', 'Gagal menyimpan maintenance.');
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
        $maintenances = Maintenance::with('asets')->where('aset_id', $id)->first();
        return view('backend.maintenance.show', compact('maintenances'));
    }

    public function indexLog($id)
    {
        $logs = MaintenanceLog::with('maintenances')->where('maintenance_id', $id)->paginate(10);
        return view('backend.maintenance.indexLog', compact('logs'));
    }


    public function destroy($id)
    {
        $delete = Aset::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            session()->flash('success', 'Aset Berhasil Dihapus');
        } else {
            session()->flash('error', 'Gagal Dihapus, Terjadi Kesalahan');
        }
        return redirect()->route('aset.create');
    }
}
