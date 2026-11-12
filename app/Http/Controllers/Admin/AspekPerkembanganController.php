<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AspekPerkembangan;
use Illuminate\Http\Request;

class AspekPerkembanganController extends Controller
{
    public function index()
    {
        $data = AspekPerkembangan::orderBy('urutan')->get();
        return view('admin.aspek.index', compact('data'));
    }

    public function create()
    {
        return view('admin.aspek.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_aspek' => 'required',
            'urutan' => 'required|integer'
        ]);

        AspekPerkembangan::create($request->all());

        return redirect()->route('admin.aspek.index')
            ->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = AspekPerkembangan::findOrFail($id);
        return view('admin.aspek.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_aspek' => 'required',
            'urutan' => 'required|integer'
        ]);

        $data = AspekPerkembangan::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('admin.aspek.index')
            ->with('success', 'Berhasil diupdate');
    }

    public function destroy($id)
    {
        AspekPerkembangan::findOrFail($id)->delete();

        return back()->with('success', 'Berhasil dihapus');
    }
}