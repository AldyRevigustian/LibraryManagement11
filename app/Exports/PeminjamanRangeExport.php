<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PeminjamanRangeExport implements FromQuery, WithHeadings, WithMapping, WithEvents
{
    use Exportable;

    private $from;
    private $until;

    public function __construct($from, $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function query()
    {
        return Peminjaman::query()
            ->whereBetween('tanggal_peminjaman', [$this->from, $this->until])
            ->orderBy('tanggal_peminjaman', 'ASC');
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama Peminjam',
            'Judul Buku',
            'Tanggal Peminjaman',
            'Tanggal Pengembalian',
            'Status',
        ];
    }

    public function map($peminjaman): array
    {
        return [
            $peminjaman->anggota->nim,
            $peminjaman->anggota->nama,
            $peminjaman->buku->judul,
            $peminjaman->tanggal_peminjaman ? date('d/m/Y', strtotime($peminjaman->tanggal_peminjaman)) : '-',
            $peminjaman->tanggal_pengembalian ? date('d/m/Y', strtotime($peminjaman->tanggal_pengembalian)) : '-',
            $peminjaman->tanggal_pengembalian ? 'Returned' : '',
        ];
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:F1');
                $event->sheet->getDelegate()->mergeCells('A2:F2');

                $event->sheet->getDelegate()->setCellValue('A1', 'Laporan Peminjaman Buku')
                    ->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(20);

                $periode = date('d F Y', strtotime($this->from)) . ' - ' . date('d F Y', strtotime($this->until));
                $event->sheet->getDelegate()->setCellValue('A2', 'Periode: ' . $periode)
                    ->getStyle('A2')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(15);
            },
            AfterSheet::class => function (AfterSheet $event) {
                // Set header style with increased height, center alignment, and white borders
                $event->sheet->getDelegate()->getStyle('A3:F3')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12)
                    ->getColor()
                    ->setARGB('ffffff');

                $event->sheet->getDelegate()->getStyle('A3:F3')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('687ecb');

                // Set row height for header row (row 3)
                $event->sheet->getDelegate()->getRowDimension(3)->setRowHeight(30);

                // Center align text horizontally and vertically
                $event->sheet->getDelegate()->getStyle('A3:F3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Add white borders to header cells
                $event->sheet->getDelegate()->getStyle('A3:F3')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));

                // Auto-size columns
                foreach (range('A', 'F') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
