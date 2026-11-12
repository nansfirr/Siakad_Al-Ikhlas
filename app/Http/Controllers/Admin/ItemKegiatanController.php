<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemKegiatan;
use App\Models\KatagoriKegiatan;
use Illuminate\Http\Request;

class ItemKegiatanController extends Controller
{
    public function index()
    {
        $data = ItemKegiatan::with('katagori')
            ->orderBy('id_katagori')
            ->orderBy('urutan')
            ->get();

        return view('admin.item.index', compact('data'));
    }

    public function create()
    {
        $katagori = KatagoriKegiatan::orderBy('urutan')->get();

        return view('admin.item.create', compact('katagori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_katagori' => 'required|exists:katagori_kegiatan,id_katagori',
            'nama_item' => 'required|string|max:255',
            'urutan' => 'required|integer'
        ]);

        ItemKegiatan::create($request->all());

        return redirect()->route('admin.item.index')
            ->with('success', 'Item kegiatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = ItemKegiatan::findOrFail($id);

        $katagori = KatagoriKegiatan::orderBy('urutan')->get();

        return view('admin.item.edit', compact('data', 'katagori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_katagori' => 'required|exists:katagori_kegiatan,id_katagori',
            'nama_item' => 'required|string|max:255',
            'urutan' => 'required|integer'
        ]);

        $data = ItemKegiatan::findOrFail($id);

        $data->update($request->all());

        return redirect()->route('admin.item.index')
            ->with('success', 'Item kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = ItemKegiatan::findOrFail($id);

        if ($data->nilaiKegiatan()->exists()) {
            return back()->with('error', 'Item sudah digunakan sehingga tidak dapat dihapus.');
        }

        $data->delete();

        return back()->with('success', 'Item kegiatan berhasil dihapus.');
    }
}