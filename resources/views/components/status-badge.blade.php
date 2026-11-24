@props(['status'])
<span class="badge badge-{{ $status }}">{{ \App\Models\Pendaftaran::label($status) }}</span>
