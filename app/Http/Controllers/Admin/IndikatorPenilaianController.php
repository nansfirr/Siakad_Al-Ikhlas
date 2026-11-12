<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AspekPerkembangan;
use App\Models\IndikatorPenilaian;
use Illuminate\Http\Request;

class IndikatorPenilaianController extends Controller
{
    public function index()
    {
        $indikator = IndikatorPenilaian::with('aspek')
            ->orderBy('id_aspek')
            ->orderBy('urutan')
            ->get();

        return view('admin.indikator.index', compact('indikator'));
    }

    public function create()
    {
        $aspek = AspekPerkembangan::orderBy('urutan')->get();

        return view('admin.indikator.create', compact('aspek'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_aspek' => 'required|exists:aspek_perkembangan,id_aspek',
            'capaian_pembelajaran' => 'required|string',
            'urutan' => 'required|integer',
        ]);

        IndikatorPenilaian::create($validated);

        return redirect()->route('admin.indikator.index')
            ->with('success','Indikator berhasil ditambahkan.');
    }

    public function edit(IndikatorPenilaian $indikator)
    {
        $aspek = AspekPerkembangan::orderBy('urutan')->get();

        return view('admin.indikator.edit', compact('indikator','aspek'));
    }

    public function update(Request $request, IndikatorPenilaian $indikator)
    {
        $validated = $request->validate([
            'id_aspek' => 'required|exists:aspek_perkembangan,id_aspek',
            'capaian_pembelajaran' => 'required|string',
            'urutan' => 'required|integer',
        ]);

        $indikator->update($validated);

        return redirect()->route('admin.indikator.index')
            ->with('success','Indikator berhasil diubah.');
    }

    public function destroy(IndikatorPenilaian $indikator)
    {
        try {

            if($indikator->penilaian()->exists()){
                return back()->with('error','Indikator sudah digunakan.');
            }

            $indikator->delete();

            return redirect()->route('admin.indikator.index')
                ->with('success','Indikator berhasil dihapus.');

        } catch (\Exception $e){

            return back()->with('error','Data gagal dihapus.');
        }
    }
}