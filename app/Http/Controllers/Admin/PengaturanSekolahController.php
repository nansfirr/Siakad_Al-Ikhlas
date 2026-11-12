<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanSekolahController extends Controller
{
    public function index()
{
    $pengaturan = PengaturanSekolah::first();

    if (!$pengaturan) {
        $pengaturan = new PengaturanSekolah();
    }

    return view('admin.pengaturan.index', compact('pengaturan'));
}

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah'   => 'required',
            'alamat'         => 'nullable',
            'telepon'        => 'nullable',
            'email'          => 'nullable|email',
            'kepala_sekolah' => 'nullable',
            'nip_kepala'     => 'nullable',
            'logo'           => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $pengaturan = PengaturanSekolah::first();
        
        if (!$pengaturan) {
             $pengaturan = new PengaturanSekolah();
        }

        if ($request->hasFile('logo')) {

            if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
                Storage::disk('public')->delete($pengaturan->logo);
            }

            $pengaturan->logo = $request->file('logo')->store('logo', 'public');
        }

        $pengaturan->nama_sekolah   = $request->nama_sekolah;
        $pengaturan->alamat         = $request->alamat;
        $pengaturan->telepon        = $request->telepon;
        $pengaturan->email          = $request->email;
        $pengaturan->kepala_sekolah = $request->kepala_sekolah;
        $pengaturan->nip_kepala     = $request->nip_kepala;

        $pengaturan->save();

        return back()->with('success', 'Pengaturan sekolah berhasil disimpan.');
    }
}
