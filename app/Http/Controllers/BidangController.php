<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
class BidangController extends Controller
{
    public function index()
    {
        $bidangs=Bidang::orderBy('bidang_id','ASC')->paginate(10);
        return view('backend.bidang.index')->with('bidangs',$bidangs);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bidang.create');
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
            'bidang_name'=>'string|required|max:30',
            
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        $status=Bidang::create($data);
        // dd($status);
        if($status){
            session()->flash('success','Successfully added Bidang');
        }
        else{
            session()->flash('error','Error occurred while adding Bidang');
        }
        return redirect()->route('bidangs.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $bidang_id
     * @return \Illuminate\Http\Response
     */
    public function show($bidang_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $bidang_id
     * @return \Illuminate\Http\Response
     */
    public function edit($bidang_id)
    {
        $bidangs=Bidang::findOrFail($bidang_id);
        return view('backend.bidang.edit')->with('bidang',$bidangs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bidang_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bidang_id)
    {
        $bidang=bidang::findOrFail($bidang_id);
        $this->validate($request,
        [
            'bidang_name'=>'string|required|max:30',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        
        $status=$bidang->fill($data)->save();
        if($status){
            session()->flash('success','Successfully updated');
        }
        else{
            session()->flash('error','Error occured while updating');
        }
        return redirect()->route('bidangs.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $bidang_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bidang_id)
    {
        $delete=Bidang::findorFail($bidang_id);
        $status=$delete->delete();
        if($status){
            session()->flash('success','Bidang Successfully deleted');
        }
        else{
            session()->flash('error','There is an error while deleting Bidangs');
        }
        return redirect()->route('bidangs.index');
    }
}
