<?php

namespace App\Exports;

use App\Models\Produk;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Export laporan pelelangan untuk 1 TPI (yang sedang login).
 * Hanya menyertakan penawaran dengan status 'sudah' (lunas dibayar).
 */
class TpiLaporanExport implements FromCollection, WithHeadings, WithMapping
{
    protected int $tpiId;
    protected $tahun;
    protected $bulan;
    protected int $no = 0;

    public function __construct(int $tpiId, $tahun = null, $bulan = null)
    {
        $this->tpiId = $tpiId;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $query = Produk::with(['penawaran' => function ($q) {
                $q->where('status', 'sudah')->with('user');
            }])
            ->where('tpi_id', $this->tpiId)
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
        return ['No', 'Produk', 'Pemenang', 'Harga Akhir', 'Tanggal Selesai'];
    }

    public function map($row): array
    {
        $this->no++;

        return [
            $this->no,
            $row['produk']->jenis_ikan,
            $row['pemenang']->user->name ?? '-',
            $row['pemenang']->jumlah_penawaran,
            optional($row['produk']->waktu_selesai)->format('d M Y H:i'),
        ];
    }
}
