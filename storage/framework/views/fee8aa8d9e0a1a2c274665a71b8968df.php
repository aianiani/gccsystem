<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        <?php if($frequency == 'annual'): ?>
            Annual Report - <?php echo e($year); ?>

        <?php elseif($frequency == 'weekly'): ?>
            Weekly Report - Week <?php echo e($week); ?>, <?php echo e($year); ?>

        <?php elseif($frequency == 'daily'): ?>
            Daily Report - <?php echo e(Carbon\Carbon::parse($date)->format('F j, Y')); ?>

        <?php elseif($frequency == 'custom'): ?>
            Custom Report - <?php echo e(Carbon\Carbon::parse($startDate ?? $date)->format('M d, Y')); ?> to
            <?php echo e(Carbon\Carbon::parse($endDate ?? $date)->format('M d, Y')); ?>

        <?php else: ?>
            Monthly Report - <?php echo e(DateTime::createFromFormat('!m', $month)->format('F')); ?> <?php echo e($year); ?>

        <?php endif; ?>
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
            <?php if($frequency == 'annual'): ?>
                Annual Admin Report
            <?php elseif($frequency == 'weekly'): ?>
                Weekly Admin Report
            <?php elseif($frequency == 'daily'): ?>
                Daily Admin Report
            <?php elseif($frequency == 'custom'): ?>
                Custom Period Admin Report
            <?php else: ?>
                Monthly Admin Report
            <?php endif; ?>
        </h1>
        <p>
            <?php if($frequency == 'annual'): ?>
                Year: <?php echo e($year); ?>

            <?php elseif($frequency == 'weekly'): ?>
                Week <?php echo e($week); ?>, <?php echo e($year); ?>

            <?php elseif($frequency == 'daily'): ?>
                <?php echo e(Carbon\Carbon::parse($date)->format('F j, Y')); ?>

            <?php elseif($frequency == 'custom'): ?>
                <?php echo e(Carbon\Carbon::parse($startDate ?? $date)->format('M d, Y')); ?> -
                <?php echo e(Carbon\Carbon::parse($endDate ?? $date)->format('M d, Y')); ?>

            <?php else: ?>
                <?php echo e(DateTime::createFromFormat('!m', $month)->format('F')); ?> <?php echo e($year); ?>

            <?php endif; ?>
        </p>
        <p style="font-size: 8pt; font-weight: normal; margin-top: 2px;">GCC System Generated Report</p>
    </div>

    <!-- A. TESTING -->
    <div class="section-header">A. TESTING SERVICES</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 15%">TEST CATEGORY</th>
                <th rowspan="2" style="width: 10%">College</th>
                <th colspan="4">ADMINISTRATION</th>
                <th colspan="3">CHECKING / SCORING</th>
                <th colspan="3">INTERPRETATION</th>
                <th colspan="3">REPORT / RESULT</th>
            </tr>
            <tr>
                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>
                <th class="w-numbers">Enr</th>

                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>

                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>

                <th class="w-numbers">M</th>
                <th class="w-numbers">F</th>
                <th class="w-numbers">Tot</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $totalAdmin = ['male' => 0, 'female' => 0, 'total' => 0, 'enrolled' => 0];
                $totalChecking = ['male' => 0, 'female' => 0, 'total' => 0];
                $totalInterpretation = ['male' => 0, 'female' => 0, 'total' => 0];
                $totalReport = ['male' => 0, 'female' => 0, 'total' => 0];
            ?>
        </tbody>

        <?php $__empty_1 = true; $__currentLoopData = $testingData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tbody style="page-break-inside: avoid;">
                <?php $rowCount = count($test['rows']); ?>
                <?php $__currentLoopData = $test['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
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
                        ?>
                        <td style="vertical-align: middle; background-color: #f8f9fa; <?php echo e($borderStyle); ?>">
                            <?php if($index === 0): ?>
                                <strong><?php echo e($test['category']); ?></strong>
                            <?php endif; ?>
                        </td>

                        <!-- College -->
                        <td class="text-start" style="font-size: 7pt;"><?php echo e($row['college']); ?></td>

                        <!-- Administration -->
                        <td class="text-center"><?php echo e($row['administration']['male']); ?></td>
                        <td class="text-center"><?php echo e($row['administration']['female']); ?></td>
                        <td class="text-center"><strong><?php echo e($row['administration']['total']); ?></strong></td>
                        <td class="text-center"><?php echo e($row['administration']['total_enrolled']); ?></td>

                        <!-- Checking -->
                        <td class="text-center"><?php echo e($row['checking_scoring']['male']); ?></td>
                        <td class="text-center"><?php echo e($row['checking_scoring']['female']); ?></td>
                        <td class="text-center"><strong><?php echo e($row['checking_scoring']['total']); ?></strong></td>

                        <!-- Interpretation -->
                        <td class="text-center"><?php echo e($row['interpretation']['male']); ?></td>
                        <td class="text-center"><?php echo e($row['interpretation']['female']); ?></td>
                        <td class="text-center"><strong><?php echo e($row['interpretation']['total']); ?></strong></td>

                        <!-- Report -->
                        <td class="text-center"><?php echo e($row['report_result']['male']); ?></td>
                        <td class="text-center"><?php echo e($row['report_result']['female']); ?></td>
                        <td class="text-center"><strong><?php echo e($row['report_result']['total']); ?></strong></td>
                    </tr>

                    <?php
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
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tbody>
                <tr>
                    <td colspan="18" class="text-center">No testing data available</td>
                </tr>
            </tbody>
        <?php endif; ?>

        <?php if(count($testingData) > 0): ?>
            <tbody style="page-break-inside: avoid;">
                <tr class="total-row">
                    <td colspan="2">GRAND TOTAL</td>
                    <td class="text-center"><?php echo e($totalAdmin['male']); ?></td>
                    <td class="text-center"><?php echo e($totalAdmin['female']); ?></td>
                    <td class="text-center"><?php echo e($totalAdmin['total']); ?></td>
                    <td class="text-center"><?php echo e($totalAdmin['enrolled']); ?></td>
                    <td class="text-center"><?php echo e($totalChecking['male']); ?></td>
                    <td class="text-center"><?php echo e($totalChecking['female']); ?></td>
                    <td class="text-center"><?php echo e($totalChecking['total']); ?></td>
                    <td class="text-center"><?php echo e($totalInterpretation['male']); ?></td>
                    <td class="text-center"><?php echo e($totalInterpretation['female']); ?></td>
                    <td class="text-center"><?php echo e($totalInterpretation['total']); ?></td>
                    <td class="text-center"><?php echo e($totalReport['male']); ?></td>
                    <td class="text-center"><?php echo e($totalReport['female']); ?></td>
                    <td class="text-center"><?php echo e($totalReport['total']); ?></td>
                </tr>
            </tbody>
        <?php endif; ?>
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
            <?php
                $totalMale = 0;
                $totalFemale = 0;
                $totalAttended = 0;
                $totalEnrolled = 0;
            ?>
        </tbody>

        <?php $__empty_1 = true; $__currentLoopData = $guidanceData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guidance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tbody style="page-break-inside: avoid;">
                <?php $rowCount = count($guidance['rows']); ?>
                <?php $__currentLoopData = $guidance['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
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
                        ?>
                        <td style="vertical-align: middle; background-color: #f8f9fa; <?php echo e($borderStyle); ?>">
                            <?php if($index === 0): ?>
                                <?php echo e($guidance['date']); ?>

                            <?php endif; ?>
                        </td>
                        <td style="vertical-align: middle; background-color: #f8f9fa; <?php echo e($borderStyle); ?>">
                            <?php if($index === 0): ?>
                                <strong><?php echo e($guidance['topic']); ?></strong>
                            <?php endif; ?>
                        </td>

                        <td class="text-start" style="font-size: 7pt;"><?php echo e($row['college']); ?></td>
                        <td class="text-center"><?php echo e($row['male']); ?></td>
                        <td class="text-center"><?php echo e($row['female']); ?></td>
                        <td class="text-center"><strong><?php echo e($row['total_attended']); ?></strong></td>
                        <td class="text-center"><?php echo e($row['total_enrolled']); ?></td>
                        <td></td> <!-- Evaluation -->
                    </tr>
                    <?php
                        $totalMale += $row['male'];
                        $totalFemale += $row['female'];
                        $totalAttended += $row['total_attended'];
                        $totalEnrolled += $row['total_enrolled'];
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tbody>
                <tr>
                    <td colspan="8" class="text-center">No guidance data available</td>
                </tr>
            </tbody>
        <?php endif; ?>

        <?php if(count($guidanceData) > 0): ?>
            <tbody style="page-break-inside: avoid;">
                <tr class="total-row">
                    <td colspan="3">GRAND TOTAL</td>
                    <td class="text-center"><?php echo e($totalMale); ?></td>
                    <td class="text-center"><?php echo e($totalFemale); ?></td>
                    <td class="text-center"><?php echo e($totalAttended); ?></td>
                    <td class="text-center"><?php echo e($totalEnrolled); ?></td>
                    <td></td>
                </tr>
            </tbody>
        <?php endif; ?>
    </table>

    
    

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
            <?php
                $totalMale = 0;
                $totalFemale = 0;
                $totalCount = 0;
            ?>
        </tbody>

        <?php $__empty_1 = true; $__currentLoopData = $counselingData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counseling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tbody style="page-break-inside: avoid;">
                <?php $rowCount = count($counseling['rows']); ?>
                <?php $__currentLoopData = $counseling['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php
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
                        ?>
                        <td style="vertical-align: middle; background-color: #f8f9fa; <?php echo e($borderStyle); ?>">
                            <?php if($index === 0): ?>
                                <strong><?php echo e($counseling['nature']); ?></strong>
                            <?php endif; ?>
                        </td>

                        <td class="text-start" style="font-size: 7pt;"><?php echo e($row['college']); ?></td>
                        <td class="text-center" style="font-size: 7pt;"><?php echo e($row['year_level']); ?></td>
                        <td class="text-start" style="font-size: 7pt;"><?php echo e($row['presenting_problem']); ?></td>
                        <td class="text-center"><?php echo e($row['male']); ?></td>
                        <td class="text-center"><?php echo e($row['female']); ?></td>
                        <td class="text-center"><strong><?php echo e($row['total']); ?></strong></td>
                    </tr>
                    <?php
                        $totalMale += $row['male'];
                        $totalFemale += $row['female'];
                        $totalCount += $row['total'];
                    ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center">No counseling data available</td>
                </tr>
            </tbody>
        <?php endif; ?>

        <?php if(count($counselingData) > 0): ?>
            <tbody style="page-break-inside: avoid;">
                <tr class="total-row">
                    <td colspan="4">GRAND TOTAL</td>
                    <td class="text-center"><?php echo e($totalMale); ?></td>
                    <td class="text-center"><?php echo e($totalFemale); ?></td>
                    <td class="text-center"><?php echo e($totalCount); ?></td>
                </tr>
            </tbody>
        <?php endif; ?>
    </table>

    <div class="footer">
        Generated on <?php echo e(now()->format('F j, Y, g:i a')); ?> by <?php echo e(auth()->user()->name); ?>

    </div>
</body>

</html><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/admin/reports/export_pdf.blade.php ENDPATH**/ ?>