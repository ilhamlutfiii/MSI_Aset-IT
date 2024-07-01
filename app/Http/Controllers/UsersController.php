<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Models\Jabatan;
use App\Models\Bidang;
use App\Models\Fungsi;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('backend.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatans = Jabatan::all();
        $bidangs = Bidang::all();
        $fungsis = Fungsi::all();
        return view('backend.users.create', compact('jabatans', 'bidangs', 'fungsis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'user_nid' => 'string|required|max:30',
                'user_nama' => 'string|required|max:30',
                'jabatan' => 'string|required',
                'bidang' => 'string|required',
                'fungsi' => 'string|required',
                'password' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'photo' => 'nullable|string',
                'noTelpon' => 'nullable|string',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        // dd($data);
        $status = User::create($data);
        // dd($status);
        if ($status) {
            session()->flash('success', 'User Berhasil Ditambahkan');
        } else {
            session()->flash('error', 'Gagal Ditambahkan, Terjadi Kesalahan');
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $users = User::findOrFail($id);
       return view('backend.users.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        $jabatans = Jabatan::all();
        $bidangs = Bidang::all();
        $fungsis = Fungsi::all();
        // dd($users, $jabatans, $bidangs, $fungsis);
        return view('backend.users.edit', compact('users', 'jabatans', 'bidangs', 'fungsis'));
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
        $users = User::findOrFail($id);
        $this->validate(
            $request,
            [
                'user_nid' => 'string|required',
                'user_nama' => 'string|required',
                'jabatan' => 'string|required',
                'fungsi' => 'string|required',
                'bidang' => 'string|required',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:active,inactive',
                'noTelpon' => 'nullable|string',
            ],
            [
                'user_nid.required' => 'Kolom NID Pengguna diperlukan.',
                'user_nama.required' => 'Kolom Nama Pengguna diperlukan.',
                'jabatan.required' => 'Kolom Jabatan diperlukan.',
                'fungsi.required' => 'Kolom Fungsi diperlukan.',
                'bidang.required' => 'Kolom Bidang diperlukan.',
                'role.in' => 'Peran harus berupa admin atau user.',
                'status.in' => 'Status harus berupa active atau inactive.',
            ]
        );
        // dd($request->all());
        $data = $request->all();
        // dd($data);

        $status = $users->fill($data)->save();
        if ($status) {
            session()->flash('success', 'User Berhasil Diupdate');
        } else {
            session()->flash('error', 'Gagal Diupdate, Terjadi Kesalahan');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = User::findorFail($id);
        $status = $delete->delete();
        if ($status) {
            session()->flash('success', 'User Berhasil Dihapus');
        } else {
            session()->flash('error', 'Gagal Dihapus, Terjadi Kesalahan');
        }
        return redirect()->route('users.index');
    }
}
