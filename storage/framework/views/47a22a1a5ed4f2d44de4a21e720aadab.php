<?php
    // DASS-42 Questions
    $questions = [
        1 => "I found myself getting upset by quite trivial things.",
        2 => "I was aware of dryness of my mouth.",
        3 => "I couldn't seem to experience any positive feeling at all.",
        4 => "I experienced breathing difficulty (e.g. excessively rapid breathing, breathlessness in the absence of physical exertion).",
        5 => "I just couldn't seem to get going.",
        6 => "I tended to over-react to situations.",
        7 => "I had a feeling of shakiness (e.g. legs going to give way).",
        8 => "I found it difficult to relax.",
        9 => "I found myself in situations that made me so anxious I was most relieved when they ended.",
        10 => "I felt that I had nothing to look forward to.",
        11 => "I found myself getting upset rather easily.",
        12 => "I felt that I was using a lot of nervous energy.",
        13 => "I felt sad and depressed.",
        14 => "I found myself getting impatient when I was delayed in any way (e.g. elevators, traffic lights, being kept waiting).",
        15 => "I had a feeling of faintness.",
        16 => "I felt that I had lost interest in just about everything.",
        17 => "I felt I wasn't worth much as a person.",
        18 => "I felt that I was rather touchy.",
        19 => "I perspired noticeably (e.g. hands sweaty) in the absence of high temperatures or physical exertion.",
        20 => "I felt scared without any good reason.",
        21 => "I felt that life wasn't worthwhile.",
        22 => "I found it hard to wind down.",
        23 => "I had difficulty in swallowing.",
        24 => "I couldn't seem to get any enjoyment out of the things I did.",
        25 => "I was aware of dryness of my heart in the absence of physical exertion (e.g. sense of heart rate increase, heart pounding).",
        26 => "I felt down-hearted and blue.",
        27 => "I found that I was very irritable.",
        28 => "I felt I was close to panic.",
        29 => "I found it hard to calm down after something upset me.",
        30 => "I feared that I would be 'thrown' by some trivial unfamiliar task.",
        31 => "I was unable to become enthusiastic about anything.",
        32 => "I found it difficult to tolerate interruptions to what I was doing.",
        33 => "I was in a state of nervous tension.",
        34 => "I felt I was pretty worthless.",
        35 => "I was intolerant of anything that kept me from getting on with what I was doing.",
        36 => "I felt terrified.",
        37 => "I could see nothing in the future to be hopeful about.",
        38 => "I felt that life was meaningless.",
        39 => "I found myself getting agitated.",
        40 => "I was worried about situations in which I might panic and make a fool of myself.",
        41 => "I experienced trembling (e.g. in the hands).",
        42 => "I found it difficult to work up the initiative to do things.",
    ];

    // Get student answers from assessment->score
    $studentAnswers = [];
    if ($assessment->score) {
        if (is_array($assessment->score)) {
            $studentAnswers = $assessment->score;
        } elseif (is_string($assessment->score)) {
            $decoded = json_decode($assessment->score, true);
            $studentAnswers = is_array($decoded) ? $decoded : [];
        }
    }

    // Normalize keys: if answers were saved with 0-based numeric keys (0..41),
    // convert them to 1-based keys (1..42) so the view can use question numbers.
    // Normalize keys: ONLY if answers utilize 0-based numeric keys (0..41).
    // If the data is already 1-based (which is how we save it now), we skip this to avoid shifting keys incorrectly.
    if (isset($studentAnswers[0])) {
        $normalized = [];
        foreach ($studentAnswers as $k => $v) {
            if (is_numeric($k)) {
                $ik = (int) $k;
                // if original keys were 0..41, convert to 1..42
                if ($ik >= 0 && $ik <= 41) {
                    $normalized[$ik + 1] = (int) $v;
                    continue;
                }
            }
            $normalized[$k] = $v;
        }
        $studentAnswers = $normalized;
    }
?>

<div class="dass42-questionnaire">
    <!-- Rating Scale Instructions removed for compact counselor view -->

    <!-- Questions Table (compact) -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 60px; text-align: center;">Q</th>
                    <th>Statement</th>
                    <th style="width: 120px; text-align: center;">Answer</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qNum => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $answer = $studentAnswers[$qNum] ?? null;
                    ?>
                    <tr>
                        <td style="text-align: center; font-weight: bold; background: #f8f9fa;"><?php echo e($qNum); ?></td>
                        <td><?php echo e($question); ?></td>
                        <td style="text-align: center; font-weight: bold; background: #f8f9fa;">
                            <?php if($answer !== null): ?>
                                <span class="badge 
                                                    <?php if($answer === 0 || $answer === '0'): ?> bg-success
                                                    <?php elseif($answer === 1 || $answer === '1'): ?> bg-info
                                                    <?php elseif($answer === 2 || $answer === '2'): ?> bg-warning text-dark
                                                    <?php elseif($answer === 3 || $answer === '3'): ?> bg-danger
                                                    <?php endif; ?>">
                                    <?php echo e($answer); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Small inline legend for counselor view -->
    <div class="small text-muted mt-3">
        <span class="me-3"><span class="badge bg-success me-1">0</span> Did not apply</span>
        <span class="me-3"><span class="badge bg-info me-1">1</span> Sometimes</span>
        <span class="me-3"><span class="badge bg-warning text-dark me-1">2</span> Often</span>
        <span class="me-0"><span class="badge bg-danger me-1">3</span> Very much</span>
    </div>
</div>

<style>
    .dass42-questionnaire .table {
        margin-bottom: 0;
    }

    .dass42-questionnaire .table th {
        background-color: #f0f0f0;
        color: #1f7a2d;
        font-weight: 700;
        border-color: #ddd;
    }

    .dass42-questionnaire .table td {
        vertical-align: middle;
        border-color: #ddd;
    }

    .dass42-questionnaire .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        .dass42-questionnaire .table {
            font-size: 0.85rem;
        }

        .dass42-questionnaire .table thead th {
            padding: 0.5rem 0.25rem;
        }

        .dass42-questionnaire .table td {
            padding: 0.5rem 0.25rem;
        }
    }
</style><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/counselor/assessments/partials/dass42_questionnaire.blade.php ENDPATH**/ ?>