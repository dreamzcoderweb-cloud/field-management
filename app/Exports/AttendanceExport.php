<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Constants;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class AttendanceExport implements FromQuery, WithTitle, WithHeadings, WithMapping, WithColumnWidths, WithEvents
{
    private $month;
    private $year;
    private $fromDate;
    private $toDate;
    private $employeeId;

    public function __construct($month = null, $year = null, $fromDate = null, $toDate = null, $employeeId = null)
    {
        $this->month = $month;
        $this->year = $year;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->employeeId = $employeeId;
    }

    public function query()
    {
        $query = Attendance::query();

        // employee filter
        if (!empty($this->employeeId)) {
            $query->where('user_id', $this->employeeId);
        }

        // from/to filter (uses created_at)
        if (!empty($this->fromDate) && !empty($this->toDate)) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->fromDate)->startOfDay(),
                Carbon::parse($this->toDate)->endOfDay(),
            ]);
        } elseif (!empty($this->year) && !empty($this->month)) {
            // fallback to existing month/year period filter
            $query->whereYear('created_at', $this->year)
                ->whereMonth('created_at', $this->month);
        }

        return $query->orderBy('created_at', 'asc');
    }

    public function title(): string
    {
        if (!empty($this->fromDate) && !empty($this->toDate)) {
            return 'Attendance ' . $this->fromDate . ' to ' . $this->toDate;
        }

        if (!empty($this->month) && !empty($this->year)) {
            return 'Period ' . $this->month . ' ' . $this->year;
        }

        return 'Attendance Report';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Employee ID',
            'Employee Name',
            'Shift',
            'Date',
            'Check In Time',
            'Check Out Time',
            'Total Hours',
            'Total KM',
        ];
    }

    public function map($row): array
    {
        $employee = null;
        if (!empty($row->user_id)) {
            $employee = User::where('id', $row->user_id)->first();
        }

        $shift = null;
        if (!empty($row->shift_id)) {
            $shift = Shift::where('id', $row->shift_id)->first();
        }

        $checkInTime = $row->check_in_time ?? null;
        $checkOutTime = $row->check_out_time ?? null;

        $totalHours = null;
        if (!empty($checkInTime) && !empty($checkOutTime)) {
            $totalHours = Carbon::parse($checkOutTime)->diffInHours(Carbon::parse($checkInTime));
        }

        $totalKm = $row->total_km ?? null;

        return [
            $row->id,
            $employee ? $employee->id : ($row->user_id ?? 'N/A'),
            $employee ? $employee->getFullName() : 'N/A',
            $shift ? $shift->title : 'N/A',
            !empty($row->created_at) ? $row->created_at->format(Constants::DateFormat) : 'N/A',
            !empty($checkInTime) ? Carbon::parse($checkInTime)->format(Constants::TimeFormat) : 'N/A',
            !empty($checkOutTime) ? Carbon::parse($checkOutTime)->format(Constants::TimeFormat) : 'N/A',
            $totalHours ?? 'N/A',
            $totalKm ?? 'N/A',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A1:I1')->getFont()->setBold(true);
            },
        ];
    }
}

