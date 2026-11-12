<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi</title>
    <style>
        body { font-family: sans-serif; font-size: 9px; }
        h3, h4 { text-align: center; margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 3px 5px; text-align: center; }
        th { background-color: #c8e6c9; }
        .text-start { text-align: left; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 8px; }
    </style>
</head>
<body>
<div class="header">
    <h3>LAPORAN REKAPITULASI PERKEMBANGAN ANAK</h3>
    <h4>TK AL-IKHLAS TALIWANG</h4>
    <p>{{ $kelas->nama_kelas }} | Semester {{ $semester }} | Tahun Ajaran {{ $tahunAjaran }}</p>
</div>

<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2" class="text-start">Nama Siswa</th>
            @foreach($aspek as $a)
            <th>{{ $a->nama_aspek }}</th>
            @endforeach
            <th colspan="3">Presensi</th>
        </tr>
        <tr>
            @foreach($aspek as $a)<th>Nilai</th>@endforeach
            <th>H</th><th>I</th><th>TK</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa as $i => $s)
        <tr>
            <td>{{ $i+1 }}</td>
            <td class="text-start">{{ $s->nama_siswa }}</td>
            @foreach($aspek as $a)
            <td>{{ $rekapNilai[$s->id_siswa][$a->id_aspek] ?? '-' }}</td>
            @endforeach
            @php $p = $rekapPresensi[$s->id_siswa] ?? null; @endphp
            <td>{{ $p?->hadir ?? '-' }}</td>
            <td>{{ $p?->izin ?? '-' }}</td>
            <td>{{ $p?->tanpa_keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>