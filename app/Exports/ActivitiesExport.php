<?php

namespace App\Exports;

use App\Models\UserActivity;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivitiesExport implements FromQuery, WithHeadings, WithMapping
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
            'Date & Time',
            'User',
            'Role',
            'Action',
            'Description',
            'IP Address',
            'Browser',
        ];
    }

    public function map($activity): array
    {
        return [
            $activity->created_at->format('Y-m-d H:i:s'),
            $activity->user ? $activity->user->name : 'Unknown/System',
            $activity->user ? ucfirst($activity->user->role) : 'N/A',
            ucfirst(str_replace('_', ' ', $activity->action)),
            $activity->description,
            $activity->ip_address ?? 'N/A',
            $this->getBrowserName($activity->user_agent),
        ];
    }

    private function getBrowserName($userAgent)
    {
        if (!$userAgent)
            return 'Unknown';
        if (stripos($userAgent, 'Brave') !== false)
            return 'Brave';
        if (stripos($userAgent, 'Edg') !== false)
            return 'Edge';
        if (stripos($userAgent, 'Chrome') !== false)
            return 'Chrome';
        if (stripos($userAgent, 'Safari') !== false)
            return 'Safari';
        if (stripos($userAgent, 'Firefox') !== false)
            return 'Firefox';
        if (stripos($userAgent, 'OPR') !== false || stripos($userAgent, 'Opera') !== false)
            return 'Opera';
        return 'Other';
    }
}
