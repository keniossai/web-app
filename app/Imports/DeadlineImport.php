<?php

namespace App\Imports;

use App\Models\Deadline;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeadlineImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $deadline = Deadline::find($row['id']);

            if (isset($deadline)) {

                $date = $row['deadline'] != null ? Carbon::createFromFormat('d/m/Y', $row['deadline'])->format('Y-m-d') : null;

                $deadline->update([
                    'deadline' => $date,
                    'confirmed' => $row['confirmed']
                ]);
            }
        }
    }
}
