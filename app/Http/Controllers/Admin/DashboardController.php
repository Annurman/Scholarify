<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use App\Models\Pendaftaran;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $perStatus = Pendaftaran::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        $stats = [
            'beasiswa' => Beasiswa::where('status', 'dibuka')->count(),
            'mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'menunggu' => ($perStatus['diajukan'] ?? 0) + ($perStatus['perlu_revisi'] ?? 0),
            'lulus' => $perStatus['lulus'] ?? 0,
        ];

        $terbaru = Pendaftaran::with(['user.profile', 'beasiswa'])->where('status', '!=', 'draft')
            ->latest('submitted_at')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'perStatus', 'terbaru'));
    }
}
