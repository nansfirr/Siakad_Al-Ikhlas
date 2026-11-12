<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KatagoriKegiatan;
use Illuminate\Http\Request;

class KatagoriKegiatanController extends Controller
{
    public function index()
    {
        $data = KatagoriKegiatan::orderBy('urutan')->get();

        return view('admin.katagori.index', compact('data'));
    }

    public function create()
    {
        return view('admin.katagori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_katagori' => 'required|string|max:255',
            'urutan' => 'required|integer'
        ]);

        KatagoriKegiatan::create($request->all());

        return redirect()->route('admin.katagori.index')
            ->with('success', 'Kategori kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = KatagoriKegiatan::findOrFail($id);

        return view('admin.katagori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_katagori' => 'required|string|max:255',
            'urutan' => 'required|integer'
        ]);

        $data = KatagoriKegiatan::findOrFail($id);

        $data->update($request->all());

        return redirect()->route('admin.katagori.index')
            ->with('success', 'Kategori kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = KatagoriKegiatan::findOrFail($id);

        if ($data->itemKegiatan()->exists()) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih memiliki Item Kegiatan.'
            );
        }

        $data->delete();

        return back()->with(
            'success',
            'Kategori kegiatan berhasil dihapus.'
        );
    }
}