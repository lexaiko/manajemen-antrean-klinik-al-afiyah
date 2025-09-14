<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Poli;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function antrean(Request $request)
    {
        $query = Antrian::with('polis');

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan poli
        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        $antrian = $query->orderBy('tanggal_kunjungan', 'desc')
                        ->orderBy('nomor_antrian', 'asc')
                        ->paginate(20);

        $polis = Poli::all();

        // Statistik
        $totalAntrian = $query->count();
        $statistik = [
            'total' => $totalAntrian,
            'antri' => (clone $query)->where('status', 'antri')->count(),
            'dilayani' => (clone $query)->where('status', 'dilayani')->count(),
            'selesai' => (clone $query)->where('status', 'selesai')->count(),
            'ditangguhkan' => (clone $query)->where('status', 'ditangguhkan')->count(),
        ];

        return view('admin.laporan.antrean', compact('antrian', 'polis', 'statistik'));
    }

    public function antreanPdf(Request $request)
    {
        $query = Antrian::with('polis');

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan poli
        if ($request->filled('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        $antrian = $query->orderBy('tanggal_kunjungan', 'desc')
                        ->orderBy('nomor_antrian', 'asc')
                        ->get();

        $polis = Poli::all();

        // Data untuk PDF
        $data = [
            'antrian' => $antrian,
            'polis' => $polis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'status_filter' => $request->status,
            'poli_filter' => $request->poli_id,
            'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y H:i:s'),
        ];

        $pdf = Pdf::loadView('admin.laporan.antrean-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'laporan-antrean-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
