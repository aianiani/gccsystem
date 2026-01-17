<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Role',
            'Status',
            'Student ID',
            'College',
            'Course',
            'Year Level',
            'Registration Status',
            'Join Date',
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            ucfirst($user->role),
            $user->is_active ? 'Active' : 'Inactive',
            $user->student_id ?? 'N/A',
            $user->college ?? 'N/A',
            $user->course ?? 'N/A',
            $user->year_level ?? 'N/A',
            ucfirst($user->registration_status ?? 'N/A'),
            $user->created_at->format('M d, Y'),
        ];
    }
}
