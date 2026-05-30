<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Sheet</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            padding: 0.6in 0.7in;
        }

        /* ── HEADER ── */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .header-logo {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
            text-align: center;
        }
        .header-logo img {
            width: 60px;
            height: 60px;
        }
        .header-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }
        .header-text .republic {
            font-size: 9pt;
            font-style: italic;
        }
        .header-text .university {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-text .center-name {
            font-size: 11pt;
            font-weight: bold;
        }
        .header-text .address {
            font-size: 9pt;
        }
        .header-right {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
            text-align: center;
        }
        .header-right img {
            width: 55px;
            height: 55px;
        }

        .divider {
            border: none;
            border-top: 2.5px solid #1f7a2d;
            margin: 4px 0 2px 0;
        }
        .divider-thin {
            border: none;
            border-top: 1px solid #1f7a2d;
            margin: 2px 0 8px 0;
        }

        /* ── FORM TITLE ── */
        .form-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 8px 0 10px 0;
            text-decoration: underline;
        }

        /* ── INFO GRID ── */
        .info-grid {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
        }
        .info-grid td {
            padding: 2px 4px;
            font-size: 10.5pt;
            vertical-align: top;
        }
        .info-label {
            font-weight: bold;
            width: 130px;
            white-space: nowrap;
        }
        .info-value {
            border-bottom: 1px solid #000;
            min-width: 160px;
            padding-bottom: 1px;
        }
        .info-colon {
            width: 10px;
            text-align: center;
        }

        /* ── ATTENDANCE TABLE ── */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 9.5pt;
        }
        .attendance-table th {
            background-color: #1f7a2d;
            color: #fff;
            padding: 5px 4px;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            border: 1px solid #155724;
        }
        .attendance-table td {
            border: 1px solid #aaa;
            padding: 4px 4px;
            vertical-align: middle;
        }
        .attendance-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        .col-no       { width: 30px;  text-align: center; }
        .col-name     { width: 150px; }
        .col-id       { width: 80px;  text-align: center; }
        .col-college  { width: 80px;  text-align: center; }
        .col-course   { width: 90px;  text-align: center; }
        .col-year     { width: 40px;  text-align: center; }
        .col-sig      { width: 90px;  }

        /* empty rows */
        .empty-row td {
            height: 22px;
        }

        /* ── FOOTER ── */
        .footer-section {
            margin-top: 20px;
            width: 100%;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            padding: 2px 6px;
            vertical-align: top;
            font-size: 10pt;
        }
        .sig-line {
            border-top: 1px solid #000;
            margin-top: 30px;
            padding-top: 2px;
            text-align: center;
            font-size: 10pt;
        }
        .sig-label {
            font-size: 9pt;
            text-align: center;
            color: #444;
        }
        .note {
            font-size: 8.5pt;
            color: #555;
            margin-top: 10px;
            font-style: italic;
        }

        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    {{-- ══ HEADER ══ --}}
    <div class="header">
        <div class="header-logo">
            <img src="{{ public_path('images/logo.jpg') }}" alt="CMU Logo">
        </div>
        <div class="header-text">
            <div class="republic">Republic of the Philippines</div>
            <div class="university">Central Mindanao University</div>
            <div class="center-name">Guidance and Counseling Center</div>
            <div class="address">Musuan, Maramag, Bukidnon</div>
        </div>
        <div class="header-right">
            {{-- placeholder for GCC seal if available --}}
        </div>
    </div>
    <hr class="divider">
    <hr class="divider-thin">

    {{-- ══ FORM TITLE ══ --}}
    <div class="form-title">Attendance Sheet</div>

    {{-- ══ SEMINAR INFO ══ --}}
    @php
        $colleges = $schedule->colleges
            ? (is_array($schedule->colleges) ? implode(', ', $schedule->colleges) : implode(', ', json_decode($schedule->colleges, true) ?? []))
            : 'All Colleges';
        $dateFormatted = $schedule->date
            ? \Carbon\Carbon::parse($schedule->date)->format('F d, Y')
            : '—';
        $seminarName = $schedule->seminar->name ?? '—';
        $totalAttended = $attendances->count();
    @endphp

    <table class="info-grid">
        <tr>
            <td class="info-label">Seminar / Program</td>
            <td class="info-colon">:</td>
            <td class="info-value" style="width:220px;">{{ $seminarName }}</td>
            <td style="width:20px;"></td>
            <td class="info-label">Academic Year</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $schedule->academic_year ?? '—' }}</td>
        </tr>
        <tr>
            <td class="info-label">Date</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $dateFormatted }}</td>
            <td></td>
            <td class="info-label">Session</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $schedule->session_type ?? '—' }}</td>
        </tr>
        <tr>
            <td class="info-label">Venue / Location</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $schedule->location ?? '—' }}</td>
            <td></td>
            <td class="info-label">Total Attendees</td>
            <td class="info-colon">:</td>
            <td class="info-value">{{ $totalAttended }}</td>
        </tr>
        <tr>
            <td class="info-label">College(s)</td>
            <td class="info-colon">:</td>
            <td class="info-value" colspan="4">{{ $colleges }}</td>
        </tr>
    </table>

    {{-- ══ ATTENDANCE TABLE ══ --}}
    <table class="attendance-table">
        <thead>
            <tr>
                <th class="col-no">No.</th>
                <th class="col-name">Full Name</th>
                <th class="col-id">Student ID</th>
                <th class="col-college">College</th>
                <th class="col-course">Course</th>
                <th class="col-year">Year</th>
                <th class="col-sig">Signature</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $attendance)
            <tr>
                <td class="col-no">{{ $index + 1 }}</td>
                <td class="col-name">{{ $attendance->user->name ?? '—' }}</td>
                <td class="col-id">{{ $attendance->user->student_id ?? '—' }}</td>
                <td class="col-college">{{ $attendance->user->college ?? '—' }}</td>
                <td class="col-course">{{ $attendance->user->course ?? '—' }}</td>
                <td class="col-year">{{ $attendance->user->year_level ?? '—' }}</td>
                <td class="col-sig">&nbsp;</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:12px; color:#777; font-style:italic;">
                    No attendance records for this schedule.
                </td>
            </tr>
            @endforelse

            {{-- Extra blank rows for manual additions (minimum 5 extras) --}}
            @for($i = 0; $i < max(5, 30 - $attendances->count()); $i++)
            <tr class="empty-row">
                <td class="col-no">{{ $attendances->count() + $i + 1 }}</td>
                <td class="col-name"></td>
                <td class="col-id"></td>
                <td class="col-college"></td>
                <td class="col-course"></td>
                <td class="col-year"></td>
                <td class="col-sig"></td>
            </tr>
            @endfor
        </tbody>
    </table>

    {{-- ══ FOOTER / SIGNATURES ══ --}}
    <table class="footer-table">
        <tr>
            <td style="width:50%;">
                <div class="sig-line">{{ $counselor->name }}</div>
                <div class="sig-label">Guidance Counselor / Facilitator</div>
            </td>
            <td style="width:50%; text-align:right;">
                <div style="margin-top:30px; border-top:1px solid #000; padding-top:2px; text-align:center; width:220px; margin-left:auto;">
                    Noted by
                </div>
                <div class="sig-label" style="text-align:center; margin-right:0; width:220px; margin-left:auto;">
                    GCC Director / Head
                </div>
            </td>
        </tr>
    </table>

    <p class="note">
        * This document is an official record of the Guidance and Counseling Center, Central Mindanao University.
        Generated: {{ now()->format('F d, Y \a\t g:i A') }}
    </p>

</body>
</html>
