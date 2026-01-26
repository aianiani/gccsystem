<?php
    // Get student answers from assessment->score
    $studentAnswers = [];
    $rawScores = [];
    if ($assessment->score) {
        if (is_array($assessment->score)) {
            $rawScores = $assessment->score;
        } elseif (is_string($assessment->score)) {
            $rawScores = json_decode($assessment->score, true) ?? [];
        }
    }

    if (!isset($grit_questions)) {
        $grit_questions = app(App\Http\Controllers\AssessmentController::class)->getGritQuestions();
    }
    if (!isset($neo_questions)) {
        $neo_questions = app(App\Http\Controllers\AssessmentController::class)->getNeoQuestions();
    }
    if (!isset($wvi_questions)) {
        $wvi_questions = app(App\Http\Controllers\AssessmentController::class)->getWviQuestions();
    }
?>

<?php if($assessment->type === 'DASS-42'): ?>
    <?php
        // Normalize 0-based keys to 1-based for DASS
        $studentAnswers = $rawScores;
        if (isset($studentAnswers[0])) {
            $normalized = [];
            foreach ($studentAnswers as $k => $v) {
                if (is_numeric($k)) {
                    $ik = (int) $k;
                    if ($ik >= 0 && $ik <= 41) {
                        $normalized[$ik + 1] = (int) $v;
                        continue;
                    }
                }
                $normalized[$k] = $v;
            }
            $studentAnswers = $normalized;
        }

        // DASS-42 Scoring items
        $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
        $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
        $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];

        $depressionScore = 0;
        $anxietyScore = 0;
        $stressScore = 0;

        foreach ($depressionItems as $item) {
            $depressionScore += (int) ($studentAnswers[$item] ?? 0);
        }
        foreach ($anxietyItems as $item) {
            $anxietyScore += (int) ($studentAnswers[$item] ?? 0);
        }
        foreach ($stressItems as $item) {
            $stressScore += (int) ($studentAnswers[$item] ?? 0);
        }

        $getCategoryColor = function ($qNum) use ($depressionItems, $anxietyItems, $stressItems) {
            if (in_array($qNum, $depressionItems))
                return '#0d6efd';
            if (in_array($qNum, $anxietyItems))
                return '#0099ff';
            if (in_array($qNum, $stressItems))
                return '#666';
            return '#ccc';
        };
    ?>

    <div class="score-sheet-block">
        <div class="mb-4">
            <div class="mb-3 d-flex flex-row flex-wrap align-items-center gap-3">
                <div class="small"><strong>D</strong> = Depression</div>
                <div class="small"><strong>A</strong> = Anxiety</div>
                <div class="small"><strong>S</strong> = Stress</div>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered" style="font-size: 0.9rem;">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 50px;">Q</th>
                        <th style="width: 70px;">SCORE</th>
                        <th style="width: 50px;">Q</th>
                        <th style="width: 70px;">SCORE</th>
                        <th style="width: 110px; color: #0d6efd; font-weight: bold;">DEPRESSION SCORE</th>
                        <th style="width: 110px; color: #0099ff; font-weight: bold;">ANXIETY SCORE</th>
                        <th style="width: 110px; color: #666; font-weight: bold;">STRESS SCORES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 1; $i <= 21; $i++): ?>
                        <?php
                            $q1 = $i;
                            $q2 = $i + 21;

                            $q1_ans = $studentAnswers[$q1] ?? 0;
                            $q2_ans = $studentAnswers[$q2] ?? 0;

                            $rowDepression = (in_array($q1, $depressionItems) ? $q1_ans : 0) + (in_array($q2, $depressionItems) ? $q2_ans : 0);
                            $rowAnxiety = (in_array($q1, $anxietyItems) ? $q1_ans : 0) + (in_array($q2, $anxietyItems) ? $q2_ans : 0);
                            $rowStress = (in_array($q1, $stressItems) ? $q1_ans : 0) + (in_array($q2, $stressItems) ? $q2_ans : 0);
                        ?>
                        <tr class="text-center align-middle">
                            <td style="border: 1px solid #ddd;"><?php echo e($q1); ?></td>
                            <td style="border: 1px solid #ddd; color: <?php echo e($getCategoryColor($q1)); ?>; font-weight: bold;">
                                <?php echo e($q1_ans); ?>

                            </td>
                            <td style="border: 1px solid #ddd;"><?php echo e($q2); ?></td>
                            <td style="border: 1px solid #ddd; color: <?php echo e($getCategoryColor($q2)); ?>; font-weight: bold;">
                                <?php echo e($q2_ans); ?>

                            </td>
                            <td style="border: 1px solid #ddd; color: #0d6efd; font-weight: bold;">
                                <?php echo e($rowDepression > 0 ? $rowDepression : '-'); ?>

                            </td>
                            <td style="border: 1px solid #ddd; color: #0099ff; font-weight: bold;">
                                <?php echo e($rowAnxiety > 0 ? $rowAnxiety : '-'); ?>

                            </td>
                            <td style="border: 1px solid #ddd; color: #666; font-weight: bold;">
                                <?php echo e($rowStress > 0 ? $rowStress : '-'); ?>

                            </td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="fw-bold text-center" style="border: 2px solid #333;">
                        <td colspan="4" style="border: 1px solid #333;">Total</td>
                        <td style="border: 1px solid #333; color: #0d6efd; font-size: 1.1rem;"><?php echo e($depressionScore); ?></td>
                        <td style="border: 1px solid #333; color: #0099ff; font-size: 1.1rem;"><?php echo e($anxietyScore); ?></td>
                        <td style="border: 1px solid #333; color: #666; font-size: 1.1rem;"><?php echo e($stressScore); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <h6 class="mb-3"><strong>Table 2. Interpretation guide for scores</strong></h6>
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 25%; font-weight: bold;">Severity</th>
                        <th style="width: 25%; color: #0d6efd; font-weight: bold;">Depression (D)</th>
                        <th style="width: 25%; color: #0099ff; font-weight: bold;">Anxiety (A)</th>
                        <th style="width: 25%; color: #666; font-weight: bold;">Stress (S)</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td style="font-weight: bold;">Normal</td>
                        <td>0 - 9</td>
                        <td>0 - 7</td>
                        <td>0 - 14</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Mild</td>
                        <td>10 - 13</td>
                        <td>8 - 9</td>
                        <td>15 - 18</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Moderate</td>
                        <td>14 - 20</td>
                        <td>10 - 14</td>
                        <td>19 - 25</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Severe</td>
                        <td>21 - 27</td>
                        <td>15 - 19</td>
                        <td>26 - 33</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Extremely Severe</td>
                        <td>28+</td>
                        <td>20+</td>
                        <td>34+</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<?php elseif($assessment->type === 'GRIT Scale'): ?>
    <?php
        $passionIndices = [0, 2, 4, 6, 8];
        $perseveranceIndices = [1, 3, 5, 7, 9];
        $answers = $rawScores['answers'] ?? [];
    ?>
    <div class="score-sheet-block">
        <h5 class="mb-4 fw-bold"><i class="bi bi-grid-3x3-gap me-2"></i>GRIT Scale Score Sheet</h5>

        <div class="alert alert-info py-2 small mb-4">
            <i class="bi bi-info-circle me-2"></i>
            Passion Items: 1, 3, 5, 7, 9 | Perseverance Items: 2, 4, 6, 8, 10
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 50px;">#</th>
                        <th>Question</th>
                        <th style="width: 100px;">Raw Score</th>
                        <th style="width: 120px;">Category</th>
                        <th style="width: 100px;">Grit Point</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $grit_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isPassion = in_array($idx, $passionIndices);
                            $val = (int) ($answers[$idx] ?? 0);
                            $gritPoint = $isPassion ? $val : (6 - $val);
                        ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo e($idx + 1); ?></td>
                            <td><?php echo e($q); ?></td>
                            <td class="text-center"><?php echo e($val ?: '-'); ?></td>
                            <td class="text-center">
                                <span class="badge <?php echo e($isPassion ? 'bg-warning text-dark' : 'bg-info text-dark'); ?>">
                                    <?php echo e($isPassion ? 'Passion' : 'Perseverance'); ?>

                                </span>
                            </td>
                            <td class="text-center fw-bold text-success"><?php echo e($gritPoint ?: '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot class="table-light fw-bold text-center">
                    <tr>
                        <td colspan="4" class="text-end px-4">Passion Score Index (Avg):</td>
                        <td class="text-warning"><?php echo e($rawScores['passion_index'] ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end px-4">Perseverance Score Index (Avg):</td>
                        <td class="text-info"><?php echo e($rawScores['perseverance_index'] ?? '-'); ?></td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="4" class="text-end px-4" style="font-size: 1.1rem;">TOTAL GRIT SCORE INDEX:</td>
                        <td style="font-size: 1.1rem; color: #1f7a2d;"><?php echo e($rawScores['total_index'] ?? '-'); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-4">
            <div class="card bg-light border-0">
                <div class="card-body py-3">
                    <h6><strong>Score Interpretation Guide:</strong></h6>
                    <ul class="mb-0 small">
                        <li><strong>High Grit:</strong> 3.5 - 5.0 (Low Risk)</li>
                        <li><strong>Moderate Grit:</strong> 3.0 - 3.4 (Moderate Risk)</li>
                        <li><strong>Low Grit:</strong> Below 3.0 (High Risk)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php elseif($assessment->type === 'Personality (NEO-FFI)'): ?>
    <?php
        $domains = $rawScores['domains'] ?? [];
        $answers = $rawScores['answers'] ?? [];
        $scale = $rawScores['scale'] ?? 7;

        $domainConfigs = [
            'Neuroticism' => [
                'pos' => [6, 11, 21, 26, 36, 41, 51, 56],
                'neg' => [1, 16, 31, 46],
                'color' => '#dc3545', // Danger/Red
                'icon' => 'bi-wind'
            ],
            'Extroversion' => [
                'pos' => [2, 7, 17, 22, 32, 37, 47, 52],
                'neg' => [12, 27, 42, 57],
                'color' => '#fd7e14', // Orange
                'icon' => 'bi-people'
            ],
            'Openness' => [
                'pos' => [13, 28, 43, 53, 58],
                'neg' => [3, 8, 18, 23, 33, 38, 48],
                'color' => '#0d6efd', // blue
                'icon' => 'bi-lightbulb'
            ],
            'Agreeableness' => [
                'pos' => [4, 19, 34, 49],
                'neg' => [9, 14, 24, 29, 39, 44, 54, 59],
                'color' => '#20c997', // Teal
                'icon' => 'bi-hand-thumbs-up'
            ],
            'Conscientiousness' => [
                'pos' => [5, 10, 20, 25, 35, 40, 50, 60],
                'neg' => [15, 30, 45, 55],
                'color' => '#198754', // Green
                'icon' => 'bi-check-circle'
            ],
        ];

        // Theoretical Max/Min for 12 items on 1-7 scale:
        // Max: 12 * 7 = 84
        // Min: 12 * 1 = 12
    ?>

    <div class="score-sheet-block">
        <h5 class="mb-4 fw-bold"><i class="bi bi-person-check me-2"></i>Big Five Personality Profile (NEO-FFI)</h5>

        <div class="row g-3 mb-5">
            <?php $__currentLoopData = $domainConfigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $conf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0" style="border-left: 5px solid <?php echo e($conf['color']); ?> !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold" style="color: <?php echo e($conf['color']); ?>"><?php echo e(strtoupper($name)); ?></span>
                                <i class="bi <?php echo e($conf['icon']); ?> fs-4" style="color: <?php echo e($conf['color']); ?>"></i>
                            </div>
                            <div class="h3 mb-0 fw-bold"><?php echo e($domains[$name] ?? 0); ?></div>
                            <div class="progress mt-2" style="height: 6px;">
                                <?php
                                    // Percentage calculation: (val - 12) / (84 - 12) * 100
                                    $percent = (($domains[$name] ?? 12) - 12) / (84 - 12) * 100;
                                ?>
                                <div class="progress-bar" role="progressbar"
                                    style="width:<?php echo e($percent); ?>%; background-color: <?php echo e($conf['color']); ?>"></div>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                <span>Min: 12</span>
                                <span>Max: 84</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="alert alert-light border small mb-4">
            <h6 class="fw-bold small mb-2">Baseline Comparison Table (Sample Average)</h6>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0" style="font-size: 0.75rem;">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th>Domain</th>
                            <th>Mean (Sample)</th>
                            <th>Current Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>Neuroticism</td>
                            <td>35.32</td>
                            <td><?php echo e($domains['Neuroticism'] ?? '-'); ?></td>
                        </tr>
                        <tr class="text-center">
                            <td>Extroversion</td>
                            <td>35.85</td>
                            <td><?php echo e($domains['Extroversion'] ?? '-'); ?></td>
                        </tr>
                        <tr class="text-center">
                            <td>Openness</td>
                            <td>29.55</td>
                            <td><?php echo e($domains['Openness'] ?? '-'); ?></td>
                        </tr>
                        <tr class="text-center">
                            <td>Agreeableness</td>
                            <td>44.50</td>
                            <td><?php echo e($domains['Agreeableness'] ?? '-'); ?></td>
                        </tr>
                        <tr class="text-center">
                            <td>Conscientiousness</td>
                            <td>38.01</td>
                            <td><?php echo e($domains['Conscientiousness'] ?? '-'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="mt-2 mb-0 text-muted">Note: Means are provided for typical undergraduate class samples (1-5 scale
                adjusted to 1-7 ratio). Current score is on a 1-7 truth scale.</p>
        </div>

        <h6 class="fw-bold mb-3 mt-5">Detailed Item Responses</h6>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-sm align-middle" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 50px;">#</th>
                        <th>Question</th>
                        <th style="width: 80px;">Response</th>
                        <th style="width: 120px;">Domain</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $neo_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $qNum = $idx + 1;
                            $domName = '';
                            $color = '#666';
                            foreach ($domainConfigs as $name => $conf) {
                                if (in_array($qNum, $conf['pos']) || in_array($qNum, $conf['neg'])) {
                                    $domName = $name;
                                    $color = $conf['color'];
                                    break;
                                }
                            }
                            $isNeg = false;
                            if ($domName) {
                                $isNeg = in_array($qNum, $domainConfigs[$domName]['neg']);
                            }
                        ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo e($qNum); ?></td>
                            <td><?php echo e($q); ?> <?php if($isNeg): ?><span class="text-muted small">(R)</span><?php endif; ?></td>
                            <td class="text-center fw-bold"><?php echo e($answers[$idx] ?? '-'); ?></td>
                            <td class="text-center small">
                                <span class="badge" style="background-color: <?php echo e($color); ?>"><?php echo e(substr($domName, 0, 1)); ?></span>
                                <?php echo e($domName); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php elseif($assessment->type === 'Work Values Inventory'): ?>
    <?php
        $scales = $rawScores['scales'] ?? [];
        $answers = $rawScores['answers'] ?? [];
        
        $wviConfigs = [
            'Creativity' => [15, 16, 45],
            'Management' => [14, 24, 37],
            'Achievement' => [13, 17, 44],
            'Surroundings' => [12, 25, 36],
            'Supervisory Relationships' => [11, 18, 43],
            'Way of Life' => [10, 26, 35],
            'Security' => [9, 19, 42],
            'Associates' => [8, 27, 34],
            'Aesthetic' => [7, 20, 41],
            'Prestige' => [6, 28, 33],
            'Independence' => [5, 21, 40],
            'Variety' => [4, 29, 32],
            'Economic Return' => [3, 22, 39],
            'Altruism' => [2, 30, 31],
            'Intellectual Stimulation' => [1, 23, 38],
        ];

        $getInterpret = function($sum) {
            if ($sum >= 13) return ['label' => 'Very Important', 'color' => '#198754'];
            if ($sum >= 10) return ['label' => 'Important', 'color' => '#20c997'];
            if ($sum >= 7)  return ['label' => 'Moderately Important', 'color' => '#ffb300'];
            if ($sum >= 4)  return ['label' => 'Of Little Importance', 'color' => '#fd7e14'];
            return ['label' => 'Unimportant', 'color' => '#6c757d'];
        };
    ?>

    <div class="score-sheet-block">
        <h5 class="mb-4 fw-bold"><i class="bi bi-briefcase me-2"></i>Work Values Inventory (WVI) Results</h5>
        
        <div class="row g-3 mb-5">
            <?php $__currentLoopData = $wviConfigs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $sum = $scales[$name] ?? 0;
                    $inter = $getInterpret($sum);
                ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid <?php echo e($inter['color']); ?> !important;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="fw-bold small text-muted text-uppercase"><?php echo e($name); ?></span>
                                <span class="badge" style="background-color: <?php echo e($inter['color']); ?>; font-size: 0.65rem;"><?php echo e($inter['label']); ?></span>
                            </div>
                            <div class="h3 mb-1 fw-bold"><?php echo e($sum); ?></div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" role="progressbar" style="width:<?php echo e(($sum / 15) * 100); ?>%; background-color: <?php echo e($inter['color']); ?>"></div>
                            </div>
                            <div class="mt-2 small text-muted">Items: <?php echo e(implode(', ', $items)); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <h6 class="fw-bold mb-3 mt-5">Detailed Item Responses</h6>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-sm align-middle" style="font-size: 0.85rem;">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 50px;">#</th>
                        <th>Question</th>
                        <th style="width: 100px;">Response</th>
                        <th style="width: 150px;">Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $wvi_questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $qNum = $idx + 1;
                            $catName = '';
                            $catColor = '#666';
                            foreach($wviConfigs as $name => $items) {
                                if(in_array($qNum, $items)) {
                                    $catName = $name;
                                    $catColor = $getInterpret($scales[$name] ?? 0)['color'];
                                    break;
                                }
                            }
                        ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo e($qNum); ?></td>
                            <td class="px-3"><?php echo e($q); ?></td>
                            <td class="text-center fw-bold"><?php echo e($answers[$idx] ?? '-'); ?></td>
                            <td class="text-center small">
                                <span class="badge" style="background-color: <?php echo e($catColor); ?>"><?php echo e($catName); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="p-5 text-center text-muted">
        <i class="bi bi-clipboard-x display-4 d-block mb-3"></i>
        Score sheet not available for this assessment type.
    </div>
<?php endif; ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/assessments/partials/score_sheet.blade.php ENDPATH**/ ?>