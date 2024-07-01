<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
class UnitController extends Controller
{
    public function index()
    {
        $units=Unit::orderBy('unit_id','ASC')->paginate(10);
        return view('backend.unit.index')->with('units',$units);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.unit.create');
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
            'unit_nama'=>'string|required|max:30',
            
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        $status=Unit::create($data);
        // dd($status);
        if($status){
            session()->flash('success','Successfully added unit');
        }
        else{
            session()->flash('error','Error occurred while adding unit');
        }
        return redirect()->route('units.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $unit_id
     * @return \Illuminate\Http\Response
     */
    public function show($unit_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $unit_id
     * @return \Illuminate\Http\Response
     */
    public function edit($unit_id)
    {
        $units=Unit::findOrFail($unit_id);
        return view('backend.unit.edit')->with('unit',$units);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $unit_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $unit_id)
    {
        $unit=Unit::findOrFail($unit_id);
        $this->validate($request,
        [
            'unit_nama'=>'string|required|max:30',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        
        $status=$unit->fill($data)->save();
        if($status){
            session()->flash('success','Successfully updated');
        }
        else{
            session()->flash('error','Error occured while updating');
        }
        return redirect()->route('units.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $unit_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($unit_id)
    {
        $delete=Unit::findorFail($unit_id);
        $status=$delete->delete();
        if($status){
            session()->flash('success','Unit Successfully deleted');
        }
        else{
            session()->flash('error','There is an error while deleting Units');
        }
        return redirect()->route('units.index');
    }
}
