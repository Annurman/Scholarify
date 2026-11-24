@extends('layouts.app')
@section('title', 'Evaluasi Beasiswa')
@section('content')
<div class="page-head"><div><h1>Evaluasi Penerima Beasiswa</h1><p>Tinjau rekomendasi mentor dan tetapkan keputusan akhir penyelenggara.</p></div></div>
<div class="card table-wrap">
@if($evaluasi->isEmpty())<div class="empty"><h3>Belum ada rekomendasi</h3>Rekomendasi mentor akan muncul di halaman ini.</div>
@else
<table><thead><tr><th>Mahasiswa</th><th>Mentor</th><th>Rekomendasi</th><th>Alasan</th><th>Keputusan</th></tr></thead><tbody>
@foreach($evaluasi as $e)
<tr>
<td><strong>{{ $e->pendaftaran->user->profile->nama_lengkap ?? $e->pendaftaran->user->name }}</strong></td>
<td>{{ $e->mentor->name }}</td>
<td>{{ ['pembinaan_lanjut'=>'Pembinaan dilanjutkan','peringatan'=>'Peringatan','evaluasi_pencabutan'=>'Evaluasi pencabutan'][$e->rekomendasi] ?? $e->rekomendasi }}</td>
<td>{{ $e->alasan }}</td>
<td>
@if($e->keputusan_admin === 'menunggu')
<form method="POST" action="{{ route('admin.evaluasi.putuskan', $e) }}" style="min-width:220px">@csrf @method('PATCH')
<select name="keputusan_admin" class="form-control" required><option value="">Pilih keputusan</option><option value="dipertahankan">Beasiswa dipertahankan</option><option value="dicabut">Beasiswa dicabut</option></select>
<input name="catatan_admin" class="form-control" style="margin-top:.4rem" placeholder="Catatan keputusan" required>
<button class="btn btn-sm" style="margin-top:.4rem" type="submit">Simpan keputusan</button></form>
@else<span class="badge {{ $e->keputusan_admin === 'dicabut' ? 'badge-nonaktif' : 'badge-aktif' }}">{{ $e->keputusan_admin === 'dicabut' ? 'Dicabut' : 'Dipertahankan' }}</span><br><small>{{ $e->catatan_admin }}</small>
@endif
</td></tr>
@endforeach
</tbody></table>{{ $evaluasi->links() }}
@endif
</div>
@endsection
