<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Monthly Report - {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            color: #1f7a2d;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12pt;
        }

        .section-title {
            background-color: #e8f5e8;
            color: #1f7a2d;
            font-weight: bold;
            padding: 8px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 2px solid #1f7a2d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 9pt;
            vertical-align: middle;
        }

        th {
            background-color: #1f7a2d;
            color: white;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            background-color: #e8f5e8;
            font-weight: bold;
        }

        .total-row td {
            color: #1f7a2d;
        }

        .college-list {
            font-size: 8pt;
            font-style: italic;
            color: #666;
            margin-top: 2px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8pt;
            text-align: center;
            color: #999;
            padding: 10px;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Monthly Report</h1>
        <p>{{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
    </div>

    <!-- A. TESTING -->
    <div class="section-title">A. TESTING</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 20%">CLIENT / STUDENTS TEST</th>
                <th colspan="5">ADMINISTRATION</th>
                <th colspan="4">CHECKING / SCORING</th>
                <th colspan="4">INTERPRETATION</th>
                <th colspan="4">REPORT/RESULT</th>
            </tr>
            <tr>
                <th>College</th>
                <th>M</th>
                <th>F</th>
                <th>Tot Attend</th>
                <th>Tot Enroll</th>
                <th>College</th>
                <th>M</th>
                <th>F</th>
                <th>Tot</th>
                <th>College</th>
                <th>M</th>
                <th>F</th>
                <th>Tot</th>
                <th>College</th>
                <th>M</th>
                <th>F</th>
                <th>Tot</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAdmin = ['male' => 0, 'female' => 0, 'total' => 0, 'enrolled' => 0];
                $totalChecking = ['male' => 0, 'female' => 0, 'total' => 0];
                $totalInterpretation = ['male' => 0, 'female' => 0, 'total' => 0];
                $totalReport = ['male' => 0, 'female' => 0, 'total' => 0];
            @endphp

            @forelse($testingData as $test)
                <tr>
                    <td>
                        <strong>{{ $test['category'] }}</strong>
                    </td>
                    <!-- Administration -->
                    <td>
                        @if(count($test['administration']['colleges']) > 0)
                            <div class="college-list">
                                {{ $test['administration']['colleges']->implode(', ') }}
                            </div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $test['administration']['male'] }}</td>
                    <td class="text-center">{{ $test['administration']['female'] }}</td>
                    <td class="text-center"><strong>{{ $test['administration']['total'] }}</strong></td>
                    <td class="text-center"><strong>{{ $test['administration']['total_enrolled'] }}</strong></td>

                    <!-- Checking -->
                    <td>
                        @if(count($test['checking_scoring']['colleges']) > 0)
                            <div class="college-list">
                                {{ $test['checking_scoring']['colleges']->implode(', ') }}
                            </div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $test['checking_scoring']['male'] }}</td>
                    <td class="text-center">{{ $test['checking_scoring']['female'] }}</td>
                    <td class="text-center"><strong>{{ $test['checking_scoring']['total'] }}</strong></td>

                    <!-- Interpretation -->
                    <td>
                        @if(count($test['interpretation']['colleges']) > 0)
                            <div class="college-list">
                                {{ $test['interpretation']['colleges']->implode(', ') }}
                            </div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $test['interpretation']['male'] }}</td>
                    <td class="text-center">{{ $test['interpretation']['female'] }}</td>
                    <td class="text-center"><strong>{{ $test['interpretation']['total'] }}</strong></td>

                    <!-- Report -->
                    <td>
                        @if(count($test['report_result']['colleges']) > 0)
                            <div class="college-list">
                                {{ $test['report_result']['colleges']->implode(', ') }}
                            </div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $test['report_result']['male'] }}</td>
                    <td class="text-center">{{ $test['report_result']['female'] }}</td>
                    <td class="text-center"><strong>{{ $test['report_result']['total'] }}</strong></td>
                </tr>
                @php
                    $totalAdmin['male'] += $test['administration']['male'];
                    $totalAdmin['female'] += $test['administration']['female'];
                    $totalAdmin['total'] += $test['administration']['total'];
                    $totalAdmin['enrolled'] += $test['administration']['total_enrolled'];
                    $totalChecking['male'] += $test['checking_scoring']['male'];
                    $totalChecking['female'] += $test['checking_scoring']['female'];
                    $totalChecking['total'] += $test['checking_scoring']['total'];
                    $totalInterpretation['male'] += $test['interpretation']['male'];
                    $totalInterpretation['female'] += $test['interpretation']['female'];
                    $totalInterpretation['total'] += $test['interpretation']['total'];
                    $totalReport['male'] += $test['report_result']['male'];
                    $totalReport['female'] += $test['report_result']['female'];
                    $totalReport['total'] += $test['report_result']['total'];
                @endphp
            @empty
                <tr>
                    <td colspan="18" class="text-center">No testing data available</td>
                </tr>
            @endforelse

            @if(count($testingData) > 0)
                <tr class="total-row">
                    <td>GRAND TOTAL</td>
                    <td></td> <!-- College -->
                    <td class="text-center">{{ $totalAdmin['male'] }}</td>
                    <td class="text-center">{{ $totalAdmin['female'] }}</td>
                    <td class="text-center">{{ $totalAdmin['total'] }}</td>
                    <td class="text-center">{{ $totalAdmin['enrolled'] }}</td>
                    <td></td> <!-- College -->
                    <td class="text-center">{{ $totalChecking['male'] }}</td>
                    <td class="text-center">{{ $totalChecking['female'] }}</td>
                    <td class="text-center">{{ $totalChecking['total'] }}</td>
                    <td></td> <!-- College -->
                    <td class="text-center">{{ $totalInterpretation['male'] }}</td>
                    <td class="text-center">{{ $totalInterpretation['female'] }}</td>
                    <td class="text-center">{{ $totalInterpretation['total'] }}</td>
                    <td></td> <!-- College -->
                    <td class="text-center">{{ $totalReport['male'] }}</td>
                    <td class="text-center">{{ $totalReport['female'] }}</td>
                    <td class="text-center">{{ $totalReport['total'] }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- B. GUIDANCE -->
    <div class="section-title">B. GUIDANCE</div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">DATE</th>
                <th style="width: 30%">TOPIC</th>
                <th style="width: 25%">COLLEGE</th>
                <th>Male</th>
                <th>Female</th>
                <th>Total Attended</th>
                <th>Total Enrolled</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMale = 0;
                $totalFemale = 0;
                $totalAttended = 0;
                $totalEnrolled = 0;
            @endphp

            @forelse($guidanceData as $guidance)
                <tr>
                    <td>{{ $guidance['date'] }}</td>
                    <td><strong>{{ $guidance['topic'] }}</strong></td>
                    <td>
                        @if(count($guidance['colleges']) > 0)
                            {{ $guidance['colleges']->implode(', ') }}
                        @else
                            All Colleges
                        @endif
                    </td>
                    <td class="text-center">{{ $guidance['male'] }}</td>
                    <td class="text-center">{{ $guidance['female'] }}</td>
                    <td class="text-center"><strong>{{ $guidance['total_attended'] }}</strong></td>
                    <td class="text-center"><strong>{{ $guidance['total_enrolled'] }}</strong></td>
                </tr>
                @php
                    $totalMale += $guidance['male'];
                    $totalFemale += $guidance['female'];
                    $totalAttended += $guidance['total_attended'];
                    $totalEnrolled += $guidance['total_enrolled'];
                @endphp
            @empty
                <tr>
                    <td colspan="7" class="text-center">No guidance data available</td>
                </tr>
            @endforelse

            @if(count($guidanceData) > 0)
                <tr class="total-row">
                    <td colspan="3">GRAND TOTAL</td>
                    <td class="text-center">{{ $totalMale }}</td>
                    <td class="text-center">{{ $totalFemale }}</td>
                    <td class="text-center">{{ $totalAttended }}</td>
                    <td class="text-center">{{ $totalEnrolled }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- C. COUNSELING -->
    <div class="section-title">C. COUNSELING</div>
    <table>
        <thead>
            <tr>
                <th style="width: 20%">NATURE</th>
                <th style="width: 20%">COLLEGE</th>
                <th style="width: 15%">YEAR LEVEL</th>
                <th style="width: 25%">PRESENTING PROBLEM</th>
                <th>Male</th>
                <th>Female</th>
                <th>Total Attendees</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMale = 0;
                $totalFemale = 0;
                $totalCount = 0;
            @endphp

            @forelse($counselingData as $counseling)
                <tr>
                    <td><strong>{{ $counseling['nature'] }}</strong></td>
                    <td>
                        @if(count($counseling['colleges']) > 0)
                            {{ $counseling['colleges']->implode(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if(count($counseling['year_levels']) > 0)
                            {{ $counseling['year_levels']->implode(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if(count($counseling['presenting_problems']) > 0)
                            {{ $counseling['presenting_problems']->implode(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $counseling['male'] }}</td>
                    <td class="text-center">{{ $counseling['female'] }}</td>
                    <td class="text-center"><strong>{{ $counseling['total'] }}</strong></td>
                </tr>
                @php
                    $totalMale += $counseling['male'];
                    $totalFemale += $counseling['female'];
                    $totalCount += $counseling['total'];
                @endphp
            @empty
                <tr>
                    <td colspan="7" class="text-center">No counseling data available</td>
                </tr>
            @endforelse

            @if(count($counselingData) > 0)
                <tr class="total-row">
                    <td colspan="4">GRAND TOTAL</td>
                    <td class="text-center">{{ $totalMale }}</td>
                    <td class="text-center">{{ $totalFemale }}</td>
                    <td class="text-center">{{ $totalCount }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('F j, Y, g:i a') }} by {{ auth()->user()->name }}
    </div>
</body>

</html>