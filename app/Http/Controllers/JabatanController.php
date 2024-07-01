<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
class JabatanController extends Controller
{
    public function index()
    {
        $jabatans=Jabatan::orderBy('jabatan_id','ASC')->paginate(10);
        return view('backend.jabatan.index')->with('jabatans',$jabatans);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.jabatan.create');
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
            'jabatan_name'=>'string|required|max:30',
            
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        $status=jabatan::create($data);
        // dd($status);
        if($status){
            session()->flash('success','Berhasil Tambah Jabatan');
        }
        else{
            session()->flash('error','Error occurred while adding Jabatan');
        }
        return redirect()->route('jabatans.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $jabatan_id
     * @return \Illuminate\Http\Response
     */
    public function show($jabatan_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $jabatan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($jabatan_id)
    {
        $jabatans=Jabatan::findOrFail($jabatan_id);
        return view('backend.jabatan.edit')->with('jabatan',$jabatans);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jabatan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $jabatan_id)
    {
        $jabatan=jabatan::findOrFail($jabatan_id);
        $this->validate($request,
        [
            'jabatan_name'=>'string|required|max:30',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        
        $status=$jabatan->fill($data)->save();
        if($status){
            session()->flash('success','Successfully updated');
        }
        else{
            session()->flash('error','Error occured while updating');
        }
        return redirect()->route('jabatans.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $jabatan_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($jabatan_id)
    {
        $delete=Jabatan::findorFail($jabatan_id);
        $status=$delete->delete();
        if($status){
            session()->flash('success','Jabatan Successfully deleted');
        }
        else{
            session()->flash('error','There is an error while deleting Jabatans');
        }
        return redirect()->route('jabatans.index');
    }
}
