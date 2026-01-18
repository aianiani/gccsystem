<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Assessment Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #222;
        }

        .header {
            border-bottom: 2px solid #237728;
            margin-bottom: 14px;
            padding-bottom: 8px;
        }

        .title {
            color: #1f6f2f;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .muted {
            color: #666;
            font-size: 12px;
        }

        .section {
            margin-bottom: 14px;
        }

        .label {
            width: 140px;
            display: inline-block;
            font-weight: 600;
        }

        .value {
            display: inline-block;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 6px;
        }

        .bg-danger {
            background: #dc3545;
            color: #fff;
        }

        .bg-warning {
            background: #ffc107;
            color: #222;
        }

        .bg-success {
            background: #198754;
            color: #fff;
        }

        .bg-info {
            background: #0dcaf0;
            color: #222;
        }

        .bg-secondary {
            background: #6c757d;
            color: #fff;
        }

        .bg-depression {
            background: #0d6efd;
            color: #fff;
        }

        .bg-anxiety {
            background: #0099ff;
            color: #fff;
        }

        .bg-stress {
            background: #666;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .box {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 8px;
        }

        .small {
            font-size: 12px;
            color: #888;
        }

        .key-scores td {
            padding: 6px;
            border: 1px solid #efefef;
        }

        .interpretation th,
        .interpretation td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">Assessment Summary</div>
        <div class="muted">Assessment ID: <?php echo e($assessment->id ?? 'N/A'); ?> &nbsp;|&nbsp; Date:
            <?php echo e($assessment->created_at ? $assessment->created_at->format('M d, Y h:i A') : 'N/A'); ?></div>
    </div>
    </div>
    <div class="section box">
        <table class="info-table">
            <tr>
                <td style="width:50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td class="label" style="width: 140px; padding-bottom: 4px;">Student Name:</td>
                            <td class="value" style="padding-bottom: 4px;"><?php echo e($assessment->user->name ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label" style="padding-bottom: 4px;">Student ID:</td>
                            <td class="value" style="padding-bottom: 4px;">
                                <?php echo e($assessment->user->student_id ?? $assessment->user->id ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label" style="padding-bottom: 4px;">College / Course:</td>
                            <td class="value" style="padding-bottom: 4px;">
                                <?php echo e(($assessment->user->college ?? '') . (isset($assessment->user->course) ? ' / ' . $assessment->user->course : '')); ?>

                            </td>
                        </tr>
                        <tr>
                            <td class="label" style="padding-bottom: 4px;">Year / Gender:</td>
                            <td class="value" style="padding-bottom: 4px;">
                                <?php echo e($assessment->user->year_level ?? $assessment->user->year ?? 'N/A'); ?> /
                                <?php echo e($assessment->user->gender ?? 'N/A'); ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width:50%; vertical-align: top;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td class="label" style="width: 100px; padding-bottom: 4px;">Email:</td>
                            <td class="value" style="padding-bottom: 4px;"><?php echo e($assessment->user->email ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label" style="padding-bottom: 4px;">Contact:</td>
                            <td class="value" style="padding-bottom: 4px;">
                                <?php echo e($assessment->user->contact_number ?? $assessment->user->phone ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label" style="padding-bottom: 4px;">Address:</td>
                            <td class="value small" style="padding-bottom: 4px;">
                                <?php echo e($assessment->user->address ?? $assessment->user->city ?? 'N/A'); ?></td>
                        </tr>
                        <tr>
                            <td class="label" style="padding-bottom: 4px;">Assessed By:</td>
                            <td class="value" style="font-weight: bold; padding-bottom: 4px;">
                                <?php echo e(auth()->user()->name ?? 'N/A'); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <?php if(isset($dass42_questions) && is_array($dass42_questions)): ?>
        <div class="section">
            <div style="font-weight:700; margin-bottom:6px;">Score Sheet (DASS-42)</div>
            <?php
                // Normalize stored scores to 1..42 keys
                $studentAnswers = [];
                if (isset($scores) && is_array($scores)) {
                    foreach ($scores as $k => $v) {
                        if (is_numeric($k)) {
                            $ik = (int) $k;
                            if ($ik >= 0 && $ik <= 41) {
                                $studentAnswers[$ik + 1] = (int) $v;
                                continue;
                            }
                        }
                        $studentAnswers[$k] = $v;
                    }
                }

                // DASS-42 groups (1-indexed)
                $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
                $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
                $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];

                // helper color function for inline styling
                $getCategoryColor = function ($q) use ($depressionItems, $anxietyItems, $stressItems) {
                    if (in_array($q, $depressionItems))
                        return '#0d6efd';
                    if (in_array($q, $anxietyItems))
                        return '#0099ff';
                    if (in_array($q, $stressItems))
                        return '#666';
                    return '#000';
                };

                // compute totals
                $depressionTotal = 0;
                $anxietyTotal = 0;
                $stressTotal = 0;
                foreach ($depressionItems as $it) {
                    $depressionTotal += (int) ($studentAnswers[$it] ?? 0);
                }
                foreach ($anxietyItems as $it) {
                    $anxietyTotal += (int) ($studentAnswers[$it] ?? 0);
                }
                foreach ($stressItems as $it) {
                    $stressTotal += (int) ($studentAnswers[$it] ?? 0);
                }
            ?>

            <div class="box">
                <table style="width:100%; border-collapse:collapse; font-size:12px;">
                    <thead>
                        <tr>
                            <th style="width:50px; border:1px solid #ddd; padding:6px;">Q</th>
                            <th style="width:70px; border:1px solid #ddd; padding:6px;">SCORE</th>
                            <th style="width:50px; border:1px solid #ddd; padding:6px;">Q</th>
                            <th style="width:70px; border:1px solid #ddd; padding:6px;">SCORE</th>
                            <th style="width:110px; border:1px solid #ddd; padding:6px; color:#0d6efd; font-weight:700;">
                                DEPRESSION</th>
                            <th style="width:110px; border:1px solid #ddd; padding:6px; color:#0099ff; font-weight:700;">
                                ANXIETY</th>
                            <th style="width:110px; border:1px solid #ddd; padding:6px; color:#666; font-weight:700;">STRESS
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 1; $i <= 21; $i++): ?>
                            <?php
                                $q1 = $i;
                                $q2 = $i + 21;
                                $q1_ans = (int) ($studentAnswers[$q1] ?? 0);
                                $q2_ans = (int) ($studentAnswers[$q2] ?? 0);

                                $rowDep = (in_array($q1, $depressionItems) ? $q1_ans : 0) + (in_array($q2, $depressionItems) ? $q2_ans : 0);
                                $rowAnx = (in_array($q1, $anxietyItems) ? $q1_ans : 0) + (in_array($q2, $anxietyItems) ? $q2_ans : 0);
                                $rowStr = (in_array($q1, $stressItems) ? $q1_ans : 0) + (in_array($q2, $stressItems) ? $q2_ans : 0);
                            ?>
                            <tr>
                                <td style="border:1px solid #ddd; padding:6px; text-align:center;"><?php echo e($q1); ?></td>
                                <td
                                    style="border:1px solid #ddd; padding:6px; text-align:center; color:<?php echo e($getCategoryColor($q1)); ?>; font-weight:700;">
                                    <?php echo e($q1_ans); ?></td>
                                <td style="border:1px solid #ddd; padding:6px; text-align:center;"><?php echo e($q2); ?></td>
                                <td
                                    style="border:1px solid #ddd; padding:6px; text-align:center; color:<?php echo e($getCategoryColor($q2)); ?>; font-weight:700;">
                                    <?php echo e($q2_ans); ?></td>
                                <td
                                    style="border:1px solid #ddd; padding:6px; text-align:center; color:#0d6efd; font-weight:700;">
                                    <?php echo e($rowDep > 0 ? $rowDep : '-'); ?></td>
                                <td
                                    style="border:1px solid #ddd; padding:6px; text-align:center; color:#0099ff; font-weight:700;">
                                    <?php echo e($rowAnx > 0 ? $rowAnx : '-'); ?></td>
                                <td style="border:1px solid #ddd; padding:6px; text-align:center; color:#666; font-weight:700;">
                                    <?php echo e($rowStr > 0 ? $rowStr : '-'); ?></td>
                            </tr>
                        <?php endfor; ?>

                        <tr style="font-weight:700; text-align:center;">
                            <td colspan="4" style="border:1px solid #333; padding:8px;">Total</td>
                            <td style="border:1px solid #333; padding:8px; color:#0d6efd;"><?php echo e($depressionTotal); ?></td>
                            <td style="border:1px solid #333; padding:8px; color:#0099ff;"><?php echo e($anxietyTotal); ?></td>
                            <td style="border:1px solid #333; padding:8px; color:#666;"><?php echo e($stressTotal); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <div class="section">
        <div style="font-weight:700; margin-bottom:6px;">Scores & Interpretation</div>
        <?php if($assessment->type === 'DASS-42'): ?>
            <?php
                // Use the totals computed from the score sheet to avoid mismatch with stored values
                $computedDep = $depressionTotal ?? ($scores['depression'] ?? 0);
                $computedAnx = $anxietyTotal ?? ($scores['anxiety'] ?? 0);
                $computedStr = $stressTotal ?? ($scores['stress'] ?? 0);

                $localInterpretation = [];
                $localInterpretation['depression'] = $computedDep >= 28 ? 'Extremely Severe' : ($computedDep >= 21 ? 'Severe' : ($computedDep >= 14 ? 'Moderate' : ($computedDep >= 10 ? 'Mild' : 'Normal')));
                $localInterpretation['anxiety'] = $computedAnx >= 20 ? 'Extremely Severe' : ($computedAnx >= 15 ? 'Severe' : ($computedAnx >= 10 ? 'Moderate' : ($computedAnx >= 8 ? 'Mild' : 'Normal')));
                $localInterpretation['stress'] = $computedStr >= 34 ? 'Extremely Severe' : ($computedStr >= 26 ? 'Severe' : ($computedStr >= 19 ? 'Moderate' : ($computedStr >= 15 ? 'Mild' : 'Normal')));
            ?>
            <table class="key-scores" style="width:100%; margin-bottom:8px;">
                <tr>
                    <td style="width:33%;"><strong>Depression</strong>
                        <div class="small">Score: <?php echo e($computedDep); ?></div>
                        <div style="margin-top:6px;"><span
                                class="badge bg-depression"><?php echo e($localInterpretation['depression']); ?></span></div>
                    </td>
                    <td style="width:33%;"><strong>Anxiety</strong>
                        <div class="small">Score: <?php echo e($computedAnx); ?></div>
                        <div style="margin-top:6px;"><span
                                class="badge bg-anxiety"><?php echo e($localInterpretation['anxiety']); ?></span></div>
                    </td>
                    <td style="width:34%;"><strong>Stress</strong>
                        <div class="small">Score: <?php echo e($computedStr); ?></div>
                        <div style="margin-top:6px;"><span
                                class="badge bg-stress"><?php echo e($localInterpretation['stress']); ?></span></div>
                    </td>
                </tr>
            </table>
        <?php else: ?>
            <div class="box">Total Score: <?php echo e($graph_data['scores'][0] ?? '-'); ?> / <?php echo e($graph_data['max'] ?? '-'); ?> <span
                    class="badge bg-info"><?php echo e($graph_data['score_level'] ?? ''); ?></span></div>
        <?php endif; ?>
    </div>

    

    <div class="section">
        <div style="font-weight:700; margin-bottom:6px;">Case Management Notes</div>
        <div class="box" style="min-height:70px;"><?php echo e($assessment->case_notes ?? ''); ?></div>
    </div>

    <div class="mt-4 section">
        <div style="font-weight:700; margin-bottom:6px;">Table. Interpretation guide for scores</div>
        <table style="width:100%; border-collapse:collapse; font-size:12px; border:1px solid #ddd;">
            <thead>
                <tr style="background:#f3f3f3; text-align:center; font-weight:700;">
                    <th style="width:25%; padding:8px; border:1px solid #ddd;">Severity</th>
                    <th style="width:25%; padding:8px; border:1px solid #ddd; color:#0d6efd;">Depression (D)</th>
                    <th style="width:25%; padding:8px; border:1px solid #ddd; color:#0099ff;">Anxiety (A)</th>
                    <th style="width:25%; padding:8px; border:1px solid #ddd; color:#666;">Stress (S)</th>
                </tr>
            </thead>
            <tbody style="text-align:center;">
                <tr>
                    <td style="padding:8px; border:1px solid #ddd; font-weight:700;">Normal</td>
                    <td style="padding:8px; border:1px solid #ddd;">0 - 9</td>
                    <td style="padding:8px; border:1px solid #ddd;">0 - 7</td>
                    <td style="padding:8px; border:1px solid #ddd;">0 - 14</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd; font-weight:700;">Mild</td>
                    <td style="padding:8px; border:1px solid #ddd;">10 - 13</td>
                    <td style="padding:8px; border:1px solid #ddd;">8 - 9</td>
                    <td style="padding:8px; border:1px solid #ddd;">15 - 18</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd; font-weight:700;">Moderate</td>
                    <td style="padding:8px; border:1px solid #ddd;">14 - 20</td>
                    <td style="padding:8px; border:1px solid #ddd;">10 - 14</td>
                    <td style="padding:8px; border:1px solid #ddd;">19 - 25</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd; font-weight:700;">Severe</td>
                    <td style="padding:8px; border:1px solid #ddd;">21 - 27</td>
                    <td style="padding:8px; border:1px solid #ddd;">15 - 19</td>
                    <td style="padding:8px; border:1px solid #ddd;">26 - 33</td>
                </tr>
                <tr>
                    <td style="padding:8px; border:1px solid #ddd; font-weight:700;">Extremely Severe</td>
                    <td style="padding:8px; border:1px solid #ddd;">28+</td>
                    <td style="padding:8px; border:1px solid #ddd;">20+</td>
                    <td style="padding:8px; border:1px solid #ddd;">34+</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/assessments/export.blade.php ENDPATH**/ ?>