<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perusahaans = Perusahaan::latest()->get();
        return view('admin.perusahaan.index', compact('perusahaans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi
        $validated = $request->validate([
            'image_perusahaan' => 'required',
            'nama_perusahaan' => 'required|unique:perusahaans',
            'alamat' => 'required',
        ]);

        $perusahaans = new Perusahaan();
        if ($request->hasFile('image_perusahaan')) {
            $perusahaans->deleteImage(); //menghapus image sebelum di update melalui method deleteImage di model
            $image = $request->file('image_perusahaan');
            $name = rand(1000, 9999) . $image->getClientOriginalName();
            $image->move('images/image_perusahaan/', $name);
            $perusahaans->image_perusahaan = 'images/image_perusahaan/' . $name;
        }
        $perusahaans->nama_perusahaan = $request->nama_perusahaan;
        $perusahaans->alamat = $request->alamat;
        $perusahaans->save();
        return redirect()
            ->route('perusahaan.index')->with('success', 'Data has been added');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perusahaans = Perusahaan::findOrFail($id);
        return view('admin.perusahaan.edit', compact('perusahaans'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validasi
        $perusahaans = Perusahaan::findOrFail($id);

        if ($request->nama_perusahaan != $perusahaans->nama_perusahaan) {
            $rules['nama_perusahaan'] = 'required|unique:perusahaans';
        } else {
            $rules['nama_perusahaan'] = 'required';
        }
        $rules['alamat'] = 'required';
        $validasiData = $request->validate($rules);

        if ($request->hasFile('image_perusahaan')) {
            $perusahaans->deleteImage(); //menghapus image sebelum di update melalui method deleteImage di model
            $image = $request->file('image_perusahaan');
            $name = rand(1000, 9999) . $image->getClientOriginalName();
            $image->move('images/image_perusahaan/', $name);
            $perusahaans->image_perusahaan = 'images/image_perusahaan/' . $name;
        }
        $perusahaans->nama_perusahaan = $request->nama_perusahaan;
        $perusahaans->alamat = $request->alamat;
        $perusahaans->save();
        return redirect()
            ->route('perusahaan.index')->with('success', 'Data has been added');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perusahaans = Perusahaan::findOrFail($id);
        $perusahaans->deleteImage();
        $perusahaans->delete();

        return redirect()
            ->route('perusahaan.index')->with('success', 'Data has been deleted');

    }
}
