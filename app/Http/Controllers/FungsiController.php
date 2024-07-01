<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fungsi;
use App\Models\Unit;
class FungsiController extends Controller
{
    public function index()
    {
        $fungsis=Fungsi::with('units')->orderBy('fungsi_id','ASC')->paginate(10);
        return view('backend.fungsi.index')->with('fungsis',$fungsis);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();
        return view('backend.fungsi.create')->with('units',$units);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'unit_id'=>'string|required|exists:units,unit_id',
            'fungsi_name'=>'string|required|max:30',
            
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        $status=Fungsi::create($data);
        // dd($status);
        if($status){
            session()->flash('success','Fungsi Berhasil Ditambahkan');
        }
        else{
            session()->flash('error','Gagal Ditambahkan, Terjadi Kesalahan');
        }
        return redirect()->route('fungsis.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $fungsi_id
     * @return \Illuminate\Http\Response
     */
    public function show($fungsi_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $fungsi_id
     * @return \Illuminate\Http\Response
     */
    public function edit($fungsi_id)
    {
        $fungsis=fungsi::findOrFail($fungsi_id);
        $units = Unit::all();
        return view('backend.fungsi.edit', compact('fungsis', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $fungsi_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fungsi_id)
    {
        $fungsis=Fungsi::findOrFail($fungsi_id);
        $this->validate($request,
        [
            'unit_id'=>'string|required|exists:units,unit_id',
            'fungsi_name'=>'string|required|max:30',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        
        $status=$fungsis->fill($data)->save();
        if($status){
            session()->flash('success','Fungsi Berhasil Diupdate');
        }
        else{
            session()->flash('error','Gagal Diupdate, Terjadi Kesalahan');
        }
        return redirect()->route('fungsis.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $fungsi_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($fungsi_id)
    {
        $delete=Fungsi::findorFail($fungsi_id);
        $status=$delete->delete();
        if($status){
            session()->flash('success','Fungsi Berhasil Dihapus');
        }
        else{
            session()->flash('error','Gagal Dihapus, Terjadi Kesalahan');
        }
        return redirect()->route('fungsis.index');
    }
}
