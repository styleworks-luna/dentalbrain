<?php

namespace App\Exports;

use App\Models\Program\ProgramStudent;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;

class BoardSearchExport implements FromCollection,WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    private $is_online;

    use Exportable;

    public function __construct($is_online)
    {
        $this->is_online = $is_online;
    }

    public function map($programStudent): array
    {
        return [
            $programStudent->id,
            $programStudent->email,
            $programStudent->phone,
            $programStudent->left_days
        ];
    }

    public function collection()
    {
        if(isset($this->is_online)){
            $data = ProgramStudent::query()
                ->select('id','ticket_id','email','phone','expired_at')
                ->with(['ticket.program'])
                ->whereHas('ticket.program',function($query){
                    $query->where('is_online',$this->is_online);
                })->get();

            return $data;
        }
    }

    public function headings(): array
    {
        return [
            "id",
            "email",
            "phone",
            "left_days"
        ];
    }
}