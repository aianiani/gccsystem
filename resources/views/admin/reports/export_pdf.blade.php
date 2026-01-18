<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        @if($frequency == 'annual')
            Annual Report - {{ $year }}
        @elseif($frequency == 'weekly')
            Weekly Report - Week {{ $week }}, {{ $year }}
        @else
            Monthly Report - {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
        @endif
    </title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #333;
            margin: 0;
            padding: 0;
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
            margin: 5px 0 0;
            font-size: 10pt;
            font-weight: bold;
        }

        .section-header {
            background-color: #1f7a2d;
            color: white;
            font-weight: bold;
            padding: 6px 10px;
            font-size: 10pt;
            margin-top: 15px;
            margin-bottom: 0;
            border: 1px solid #1f7a2d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        th,
        td {
            border: 1px solid #444;
            /* Darker border for print clarity */
            padding: 4px;
            font-size: 8pt;
            vertical-align: middle;
            line-height: 1.2;
        }

        th {
            background-color: #e8f5e8;
            /* Lighter background for headers to save ink/toner */
            color: #1f7a2d;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .college-list {
            font-size: 7pt;
            font-style: italic;
            color: #555;
            white-space: normal;
            /* Allow wrapping */
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            font-size: 7pt;
            text-align: center;
            color: #999;
            padding: 10px;
        }

        /* Helper for very narrow columns */
        .w-numbers {
            width: 5%;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>
            @if($frequency == 'annual')
                Annual Admin Report
            @elseif($frequency == 'weekly')
                Weekly Admin Report
            @else
                Monthly Admin Report
            @endif
        </h1>
        <p>
            @if($frequency == 'annual')
                Year: {{ $year }}
            @elseif($frequency == 'weekly')
                Week {{ $week }}, {{ $year }}
            @else
                {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
            @endif
        </p>
        <p style="font-size: 8pt; font-weight: normal; margin-top: 2px;">GCC System Generated Report</p>
    </div>

    <!-- A. TESTING -->
    <div class="section-header">A. TESTING SERVICES</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 16%">TEST CATEGORY</th>
                <th colspan="5">ADMINISTRATION</th>
                <th colspan="4">CHECKING / SCORING</th>
                <th colspan="4">INTERPRETATION</th>
                <th colspan="4">REPORT / RESULT</th>
            </tr>
            <tr>
                <th style="width: 10%;">College</th>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>
                <th class="w-numbers">Enr</th>

                <th style="width: 8%;">College</th>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>

                <th style="width: 8%;">College</th>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>

                <th style="width: 8%;">College</th>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAdmin = ['male' => 0, 'female' => 0, 'total' => 0, 'enrolled' => 0];
                $totalChecking = ['male' => 0, 'female' => 0, 'total' => 0];
                $totalInterpretation = ['male' => 0, 'female' => 0, 'total' => 0];
                $totalReport = ['male' => 0, 'female' => 0, 'total' => 0];
            @endphp
        </tbody>

        @forelse($testingData as $test)
            <tbody style="page-break-inside: avoid;">
                @php $rowCount = count($test['rows']); @endphp
                @foreach($test['rows'] as $index => $row)
                    <tr>
                        @php
                            $borderStyle = 'border-bottom: 1px solid #444;';
                            if ($rowCount > 1) {
                                if ($index === 0) {
                                    $borderStyle = 'border-bottom: none;';
                                } elseif ($index === $rowCount - 1) {
                                    $borderStyle = 'border-top: none; border-bottom: 1px solid #444;';
                                } else {
                                    $borderStyle = 'border-top: none; border-bottom: none;';
                                }
                            }
                        @endphp
                        <td style="vertical-align: middle; background-color: #f8f9fa; {{ $borderStyle }}">
                            @if($index === 0)
                                <strong>{{ $test['category'] }}</strong>
                            @endif
                        </td>

                        <!-- Administration -->
                        <td class="text-start" style="font-size: 7pt;">{{ $row['college'] }}</td>
                        <td class="text-center">{{ $row['administration']['male'] }}</td>
                        <td class="text-center">{{ $row['administration']['female'] }}</td>
                        <td class="text-center"><strong>{{ $row['administration']['total'] }}</strong></td>
                        <td class="text-center">{{ $row['administration']['total_enrolled'] }}</td>

                        <!-- Checking -->
                        <td class="text-start" style="font-size: 7pt;">{{ $row['college'] }}</td>
                        <td class="text-center">{{ $row['checking_scoring']['male'] }}</td>
                        <td class="text-center">{{ $row['checking_scoring']['female'] }}</td>
                        <td class="text-center"><strong>{{ $row['checking_scoring']['total'] }}</strong></td>

                        <!-- Interpretation -->
                        <td class="text-start" style="font-size: 7pt;">{{ $row['college'] }}</td>
                        <td class="text-center">{{ $row['interpretation']['male'] }}</td>
                        <td class="text-center">{{ $row['interpretation']['female'] }}</td>
                        <td class="text-center"><strong>{{ $row['interpretation']['total'] }}</strong></td>

                        <!-- Report -->
                        <td class="text-start" style="font-size: 7pt;">{{ $row['college'] }}</td>
                        <td class="text-center">{{ $row['report_result']['male'] }}</td>
                        <td class="text-center">{{ $row['report_result']['female'] }}</td>
                        <td class="text-center"><strong>{{ $row['report_result']['total'] }}</strong></td>
                    </tr>

                    @php
                        $totalAdmin['male'] += $row['administration']['male'];
                        $totalAdmin['female'] += $row['administration']['female'];
                        $totalAdmin['total'] += $row['administration']['total'];
                        $totalAdmin['enrolled'] += $row['administration']['total_enrolled'];

                        $totalChecking['male'] += $row['checking_scoring']['male'];
                        $totalChecking['female'] += $row['checking_scoring']['female'];
                        $totalChecking['total'] += $row['checking_scoring']['total'];

                        $totalInterpretation['male'] += $row['interpretation']['male'];
                        $totalInterpretation['female'] += $row['interpretation']['female'];
                        $totalInterpretation['total'] += $row['interpretation']['total'];

                        $totalReport['male'] += $row['report_result']['male'];
                        $totalReport['female'] += $row['report_result']['female'];
                        $totalReport['total'] += $row['report_result']['total'];
                    @endphp
                @endforeach
            </tbody>
        @empty
            <tbody>
                <tr>
                    <td colspan="18" class="text-center">No testing data available</td>
                </tr>
            </tbody>
        @endforelse

        @if(count($testingData) > 0)
            <tbody style="page-break-inside: avoid;">
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
            </tbody>
        @endif
    </table>

    <!-- B. GUIDANCE -->
    <div class="section-header">B. GUIDANCE / SEMINARS</div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">DATE</th>
                <th style="width: 30%">TOPIC</th>
                <th style="width: 25%">COLLEGE</th>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th style="width: 8%">Total</th>
                <th style="width: 8%">Enr</th>
                <th style="width: 10%">EVALUATION</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMale = 0;
                $totalFemale = 0;
                $totalAttended = 0;
                $totalEnrolled = 0;
            @endphp
        </tbody>

        @forelse($guidanceData as $guidance)
            <tbody style="page-break-inside: avoid;">
                @php $rowCount = count($guidance['rows']); @endphp
                @foreach($guidance['rows'] as $index => $row)
                    <tr>
                        @php
                            $borderStyle = 'border-bottom: 1px solid #444;';
                            if ($rowCount > 1) {
                                if ($index === 0) {
                                    $borderStyle = 'border-bottom: none;';
                                } elseif ($index === $rowCount - 1) {
                                    $borderStyle = 'border-top: none; border-bottom: 1px solid #444;';
                                } else {
                                    $borderStyle = 'border-top: none; border-bottom: none;';
                                }
                            }
                        @endphp
                        <td style="vertical-align: middle; background-color: #f8f9fa; {{ $borderStyle }}">
                            @if($index === 0)
                                {{ $guidance['date'] }}
                            @endif
                        </td>
                        <td style="vertical-align: middle; background-color: #f8f9fa; {{ $borderStyle }}">
                            @if($index === 0)
                                <strong>{{ $guidance['topic'] }}</strong>
                            @endif
                        </td>

                        <td class="text-start" style="font-size: 7pt;">{{ $row['college'] }}</td>
                        <td class="text-center">{{ $row['male'] }}</td>
                        <td class="text-center">{{ $row['female'] }}</td>
                        <td class="text-center"><strong>{{ $row['total_attended'] }}</strong></td>
                        <td class="text-center">{{ $row['total_enrolled'] }}</td>
                        <td></td> <!-- Evaluation -->
                    </tr>
                    @php
                        $totalMale += $row['male'];
                        $totalFemale += $row['female'];
                        $totalAttended += $row['total_attended'];
                        $totalEnrolled += $row['total_enrolled'];
                    @endphp
                @endforeach
            </tbody>
        @empty
            <tbody>
                <tr>
                    <td colspan="8" class="text-center">No guidance data available</td>
                </tr>
            </tbody>
        @endforelse

        @if(count($guidanceData) > 0)
            <tbody style="page-break-inside: avoid;">
                <tr class="total-row">
                    <td colspan="3">GRAND TOTAL</td>
                    <td class="text-center">{{ $totalMale }}</td>
                    <td class="text-center">{{ $totalFemale }}</td>
                    <td class="text-center">{{ $totalAttended }}</td>
                    <td class="text-center">{{ $totalEnrolled }}</td>
                    <td></td>
                </tr>
            </tbody>
        @endif
    </table>

    {{-- Force page break if needed, but often fits in landscape --}}
    {{-- <div class="page-break"></div> --}}

    <!-- C. COUNSELING -->
    <div class="section-header">C. COUNSELING SERVICES</div>
    <table>
        <thead>
            <tr>
                <th style="width: 15%">NATURE</th>
                <th style="width: 20%">COLLEGE</th>
                <th style="width: 15%">YEAR LEVEL</th>
                <th style="width: 20%">PRESENTING PROBLEM</th>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th style="width: 10%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMale = 0;
                $totalFemale = 0;
                $totalCount = 0;
            @endphp
        </tbody>

        @forelse($counselingData as $counseling)
            <tbody style="page-break-inside: avoid;">
                @php $rowCount = count($counseling['rows']); @endphp
                @foreach($counseling['rows'] as $index => $row)
                    <tr>
                        @php
                            $borderStyle = 'border-bottom: 1px solid #444;';
                            if ($rowCount > 1) {
                                if ($index === 0) {
                                    $borderStyle = 'border-bottom: none;';
                                } elseif ($index === $rowCount - 1) {
                                    $borderStyle = 'border-top: none; border-bottom: 1px solid #444;';
                                } else {
                                    $borderStyle = 'border-top: none; border-bottom: none;';
                                }
                            }
                        @endphp
                        <td style="vertical-align: middle; background-color: #f8f9fa; {{ $borderStyle }}">
                            @if($index === 0)
                                <strong>{{ $counseling['nature'] }}</strong>
                            @endif
                        </td>

                        <td class="text-start" style="font-size: 7pt;">{{ $row['college'] }}</td>
                        <td class="text-center" style="font-size: 7pt;">{{ $row['year_level'] }}</td>
                        <td class="text-start" style="font-size: 7pt;">{{ $row['presenting_problem'] }}</td>
                        <td class="text-center">{{ $row['male'] }}</td>
                        <td class="text-center">{{ $row['female'] }}</td>
                        <td class="text-center"><strong>{{ $row['total'] }}</strong></td>
                    </tr>
                    @php
                        $totalMale += $row['male'];
                        $totalFemale += $row['female'];
                        $totalCount += $row['total'];
                    @endphp
                @endforeach
            </tbody>
        @empty
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">No counseling data available</td>
                </tr>
            </tbody>
        @endforelse

        @if(count($counselingData) > 0)
            <tbody style="page-break-inside: avoid;">
                <tr class="total-row">
                    <td colspan="4">GRAND TOTAL</td>
                    <td class="text-center">{{ $totalMale }}</td>
                    <td class="text-center">{{ $totalFemale }}</td>
                    <td class="text-center">{{ $totalCount }}</td>
                </tr>
            </tbody>
        @endif
    </table>

    <div class="footer">
        Generated on {{ now()->format('F j, Y, g:i a') }} by {{ auth()->user()->name }}
    </div>
</body>

</html>