<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TasksWlmExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths,WithColumnFormatting, WithStyles
{
    protected $data;
    protected $columns = ['id_task', 'project_name', 'client_name', 'status_client', 'product_type', 'practice_name', 'location_name', 'guide_name', 'directory_name', 'agreed_deadline', 'deadline', 'owner_name', 'sc_name', 'consultant_name', 'lds_name', 'coord_name', 'status_c', 'Ref Filed',];
    protected $columnWidths = [
        'A' => 10,
        'B' => 20,
        'C' => 20,
        'D' => 20,
        'E' => 20,
        'F' => 20,
        'G' => 20,
        'H' => 20,
        'I' => 20,
        'J' => 20,
        'K' => 20,
        'L' => 20,
        'M' => 20,
        'N' => 20,
        'O' => 20,
        'P' => 20,
        'Q' => 20,
    ];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Project Name',
            'Client Name',
            'Status Client',
            'Product Type',
            'Practice',
            'Location',
            'Guide',
            'Directory',
            'Agreed Deadline',
            'Dealine',
            'Owner',
            'SC',
            'Consultant',
            'LDS',
            'Coordinator',
            'Consultant Status',
            'Ref Filed',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id_task,
            $row->project_name,
            $row->client_name,
            $row->status_client,
            $row->product_type,
            $row->practice_name,
            $row->location_name,
            $row->guide_name,
            $row->directory_name,
            Date::dateTimeToExcel(Carbon::parse($row->agreed_deadline)),
            Date::dateTimeToExcel(Carbon::parse($row->deadline)),
            $row->owner_name,
            $row->sc_name,
            $row->consultant_name,
            $row->lds_name,
            $row->coord_name,
            __('babel.'.$row->status_c),
        ];
    }

    public function columnWidths(): array
    {
        return $this->columnWidths;
    }

    public function styles($sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
