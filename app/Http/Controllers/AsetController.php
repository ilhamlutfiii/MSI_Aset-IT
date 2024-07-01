<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\Category;
use App\Models\Maintenance;
use Illuminate\Support\Str;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asets=Aset::getAllAset();
        // return $asets;
        return view('backend.aset.index')->with('asets',$asets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.aset.create')->with('categories',$category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'required|string|unique:asets,title',
            'summary'=>'required|string',
            'description'=>'required|string',
            'photo'=>'required|string',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'required|exists:categories,id',
            'status'=>'required|in:active,inactive',
            'rentang'=>"required|numeric",
            'ganti'=>"required|numeric",
        ], [
            'title.required' => 'Nama Aset Wajib Diisi!.',
            'title.unique' => 'Nama aset sudah ada dalam database.',
            'summary.required'=>'Ringkasan Wajib Diisi!',
            'description'=>'Deskripsi Wajib Diisi!',
            'photo'=>'Foto Wajib Diisi!',
            'stock'=>"Stok Wajib Diisi!",
            'cat_id.required' => 'Mohon Pilih Kategori.',
            'child_cat_id'=>'Mohon Pilih Sub Kategori',
            'status'=>'Status Wajib Diisi!',
            'rentang'=>"Rentang Maintenance Wajib Diisi!",
            'ganti'=>"Rentang Pergantian Wajib Diisi!",
        ]);

        $data=$request->all();
        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=aset::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $data;
        $status=Aset::create($data);
        if($status){
            session()->flash('success','Aset berhasil ditambahkan');
        }
        else{
            session()->flash('error','Please try again!!');
        }
        return redirect()->route('aset.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aset=Aset::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Aset::where('id',$id)->get();
        // return $items;
        return view('backend.aset.edit')->with('aset',$aset)
                    ->with('categories',$category)->with('items',$items);
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
        $aset=Aset::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|required',
            'photo'=>'string|required',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'required|exists:categories,id',
            'status'=>'required|in:active,inactive',
            'rentang'=>"required|numeric",
            'ganti'=>"required|numeric",
        ]);

        $data=$request->all();
        // return $data;
        $status=$aset->fill($data)->save();
        if($status){
            session()->flash('success','Aset berhasil diupdate');
        }
        else{
            session()->flash('error','Please try again!!');
        }
        return redirect()->route('aset.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aset=Aset::findOrFail($id);
        $status=$aset->delete();
        
        if($status){
            session()->flash('success','Aset berhasil dihapus');
        }
        else{
            session()->flash('error','Error while deleting aset');
        }
        return redirect()->route('aset.index');
    }
}
