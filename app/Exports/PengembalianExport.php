<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PengembalianExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    use Exportable;

    private $from;
    private $until;

    public function __construct($from, $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    public function query()
    {
        if ($this->until == null) {
            return Peminjaman::query()
                ->whereNotNull('tanggal_pengembalian')
                ->whereDate('tanggal_pengembalian', $this->from)
                ->orderBy('tanggal_pengembalian', 'ASC');
        } else {
            return Peminjaman::query()
                ->whereNotNull('tanggal_pengembalian')
                ->whereBetween('tanggal_peminjaman', [$this->from, $this->until])
                ->orderBy('tanggal_pengembalian', 'ASC');
        }
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Peminjam',
            'ISBN',
            'Judul Buku',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Batas Pengembalian',
            'Status',
            'Denda',
        ];
    }

    public function map($peminjaman): array
    {
        Carbon::setLocale('id');
        $tanggalKembali = $peminjaman->tanggal_pengembalian ? Carbon::parse($peminjaman->tanggal_pengembalian)->startOfDay() : null;
        $batasKembali = Carbon::parse($peminjaman->batas_pengembalian)->startOfDay();

        $selisih = $tanggalKembali ? $tanggalKembali->diffInDays($batasKembali, false) : null;
        $isTelat = $selisih !== null && $selisih < 0;

        $statusPengembalian = $tanggalKembali
            ? ($isTelat ? 'Telat ' . abs($selisih) . ' hari' : 'Tepat Waktu')
            : 'Belum Dikembalikan';

        $formatPeminjaman = Carbon::parse($peminjaman->tanggal_peminjaman)->translatedFormat('d F Y');
        $formatKembali = $tanggalKembali ? $tanggalKembali->translatedFormat('d F Y') : '-';
        $formatMax = $batasKembali ? Carbon::parse($peminjaman->batas_pengembalian)->translatedFormat('d F Y') : '-';

        return [
            $peminjaman->anggota->nim,
            $peminjaman->anggota->nama,
            '="' . $peminjaman->buku->ISBN . '"',
            $peminjaman->buku->judul,
            $formatPeminjaman,
            $formatKembali,
            $formatMax,
            $statusPengembalian,
            $peminjaman->denda ? 'Rp. ' . number_format($peminjaman->denda, 0, ',', '.') : '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:I1');
                $event->sheet->getDelegate()->mergeCells('A2:I2');

                $event->sheet->getDelegate()->setCellValue('A1', 'Laporan Pengembalian Buku')
                    ->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(20);

                $event->sheet->getDelegate()->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                if ($this->until == null) {
                    $periode = Carbon::parse($this->from)->translatedFormat('d F Y');
                } else {
                    $periode = Carbon::parse($this->from)->translatedFormat('d F Y') . ' - ' . Carbon::parse($this->until)->translatedFormat('d F Y');
                }

                $event->sheet->getDelegate()->setCellValue('A2', 'Periode: ' . $periode)
                    ->getStyle('A2')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(14);

                $event->sheet->getDelegate()->getStyle('A2')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },

            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                // Format header
                $sheet->getStyle('A3:I3')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12)
                    ->getColor()
                    ->setARGB('ffffff');

                $sheet->getStyle('A3:I3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getRowDimension(3)->setRowHeight(25);

                $sheet->getStyle('A3:I3')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('687ecb');

                // Border untuk semua data
                $sheet->getStyle("A3:I{$lastRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Auto-size semua kolom
                foreach (range('A', 'I') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // **Conditional Formatting untuk Status**
                $conditionalStyles = $sheet->getStyle("H4:H{$lastRow}")->getConditionalStyles();

                // **Jika Telat, background Merah**
                $conditionTelat = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                $conditionTelat->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT)
                    ->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT)
                    ->setText('Telat')
                    ->getStyle()
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFCCCC'); // 🔴 Warna merah muda (bisa disesuaikan)

                // **Jika Tepat Waktu, background Hijau**
                $conditionTepat = new \PhpOffice\PhpSpreadsheet\Style\Conditional();
                $conditionTepat->setConditionType(\PhpOffice\PhpSpreadsheet\Style\Conditional::CONDITION_CONTAINSTEXT)
                    ->setOperatorType(\PhpOffice\PhpSpreadsheet\Style\Conditional::OPERATOR_CONTAINSTEXT)
                    ->setText('Tepat Waktu')
                    ->getStyle()
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('CCFFCC'); // 🟢 Warna hijau muda (bisa disesuaikan)

                // Tambahkan kondisi ke style
                $conditionalStyles[] = $conditionTelat;
                $conditionalStyles[] = $conditionTepat;

                $sheet->getStyle("H4:H{$lastRow}")->setConditionalStyles($conditionalStyles);
            },


        ];
    }
}
