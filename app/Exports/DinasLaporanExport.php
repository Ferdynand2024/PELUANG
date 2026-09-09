<?php

namespace App\Exports;

use App\Models\Produk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Export laporan pelelangan untuk Dinas.
 * Bisa mencakup satu atau beberapa TPI (sesuai $tpiIds yang dikirim
 * dari controller, sudah di-scope ke TPI milik dinas yang login).
 * Hanya menyertakan penawaran dengan status 'sudah' (lunas dibayar).
 */
class DinasLaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $tpiIds;
    protected $tahun;
    protected $bulan;
    protected int $no = 0;

    public function __construct(array $tpiIds, $tahun = null, $bulan = null)
    {
        $this->tpiIds = $tpiIds;
        $this->tahun  = $tahun;
        $this->bulan  = $bulan;
    }

    public function collection()
    {
        $query = Produk::with([
                'tpi',
                'penawaran' => function ($q) {
                    $q->where('status', 'sudah')->with('user');
                },
            ])
            ->whereIn('tpi_id', $this->tpiIds)
            ->whereNotNull('waktu_selesai')
            ->whereHas('penawaran', function ($q) {
                $q->where('status', 'sudah');
            });

        if ($this->tahun && $this->bulan) {
            $start = Carbon::create($this->tahun, $this->bulan, 1)->startOfMonth();
            $end   = Carbon::create($this->tahun, $this->bulan, 1)->endOfMonth();
            $query->whereBetween('waktu_selesai', [$start, $end]);
        } elseif ($this->tahun) {
            $query->whereYear('waktu_selesai', $this->tahun);
        } elseif ($this->bulan) {
            $query->whereMonth('waktu_selesai', $this->bulan);
        }

        $rows = collect();

        foreach ($query->orderBy('waktu_selesai', 'desc')->get() as $produk) {
            foreach ($produk->penawaran as $pemenang) {
                $rows->push([
                    'produk'   => $produk,
                    'pemenang' => $pemenang,
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return ['No', 'TPI', 'Produk', 'Pemenang', 'Harga Akhir', 'Tanggal Selesai'];
    }

    public function map($row): array
    {
        $this->no++;

        return [
            $this->no,
            $row['produk']->tpi->name ?? '-',
            $row['produk']->jenis_ikan,
            $row['pemenang']->user->name ?? '-',
            $row['pemenang']->jumlah_penawaran,
            optional($row['produk']->waktu_selesai)->format('d M Y H:i'),
        ];
    }
}
