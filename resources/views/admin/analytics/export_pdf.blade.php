<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Analytics Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #1f7a2d;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 10pt;
            font-weight: bold;
        }

        .section-header {
            background-color: #1f7a2d;
            color: white;
            padding: 6px 10px;
            font-weight: bold;
            margin-top: 15px;
            border: 1px solid #1f7a2d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #e8f5e8;
            color: #1f7a2d;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        .kpi-box {
            width: 24%;
            display: inline-block;
            background: #f8fafc;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            margin-right: 1%;
            margin-bottom: 15px;
        }

        .kpi-box h3 {
            margin: 0;
            font-size: 18pt;
            color: #1f7a2d;
        }

        .kpi-box p {
            margin: 5px 0 0;
            font-size: 8pt;
            text-transform: uppercase;
            color: #666;
        }

        .row {
            width: 100%;
            clear: both;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Analytics Overview Report</h1>
        <p>{{ $startDate->format('F d, Y') }} - {{ $endDate->format('F d, Y') }}</p>
        <p style="font-size: 8pt; font-weight: normal; margin-top: 2px;">GCC System Generated Report</p>
    </div>

    <!-- KPIs -->
    <div class="row">
        <div class="kpi-box">
            <h3>{{ number_format($totalAppointments) }}</h3>
            <p>Total Sessions</p>
        </div>
        <div class="kpi-box">
            <h3>{{ number_format($avgWaitTime, 1) }}</h3>
            <p>Avg Wait (Days)</p>
        </div>
        <div class="kpi-box">
            <h3>{{ number_format($cancellationRate, 1) }}%</h3>
            <p>Cancellation Rate</p>
        </div>
        <div class="kpi-box" style="margin-right: 0;">
            <h3>{{ number_format($criticalRiskCount) }}</h3>
            <p>Critical Risks</p>
        </div>
    </div>

    <!-- Section 1: Appointment & Counseling Stats -->
    <div class="section-header">A. APPOINTMENT STATISTICS</div>
    <table>
        <thead>
            <tr>
                <th width="50%">Appointment Status</th>
                <th width="50%">Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointmentStatus as $status => $count)
                <tr>
                    <td class="text-left">{{ ucfirst($status) }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Nature of Problem -->
    <div class="section-header">B. TOP PRESENTING PROBLEMS</div>
    <table>
        <thead>
            <tr>
                <th width="70%">Problem Nature</th>
                <th width="30%">Count</th>
            </tr>
        </thead>
        <tbody>
            @forelse($problemDistribution->take(10) as $problem => $count)
                <tr>
                    <td class="text-left">{{ $problem }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No data recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Risk Distribution -->
    <div class="section-header">C. RISK PROFILE (Assessment)</div>
    <table>
        <thead>
            <tr>
                <th width="50%">Risk Level</th>
                <th width="50%">Students Count</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riskDistribution as $risk => $count)
                <tr>
                    <td class="text-left">{{ ucfirst($risk) }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No assessments recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Seminar Reach -->
    <div class="section-header">D. SEMINAR OUTREACH</div>
    <table>
        <thead>
            <tr>
                <th width="70%">Seminar Name</th>
                <th width="30%">Attendees</th>
            </tr>
        </thead>
        <tbody>
            @forelse($seminarAttendance as $name => $count)
                <tr>
                    <td class="text-left">{{ $name }}</td>
                    <td>{{ $count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No seminar records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; color: #999;">
        Generated by {{ auth()->user()->name }} on {{ now()->format('Y-m-d H:i') }}
    </div>
</body>

</html>