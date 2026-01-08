@php
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
    // Normalize 0-based keys (0..41) to 1-based (1..42) for compatibility
    // Check if 0-based keys are used
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
    // Else assume already 1-based or proper keys

    // DASS-42 Scoring items
    $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38];
    $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
    $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39, 42];

    // Calculate scores (raw sums of item values)
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
@endphp

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
                @php
                    // Extract and decode student answers
                    $score = $studentAnswers ?? [];
                    if (is_string($score)) {
                        $score = json_decode($score, true) ?? [];
                    }
                    $studentAnswers = is_array($score) ? $score : [];

                    // DASS-42 item groupings
                    $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
                    $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
                    $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];

                    // Calculate scores
                    $depressionRaw = 0;
                    $anxietyRaw = 0;
                    $stressRaw = 0;

                    foreach ($depressionItems as $item) {
                        $depressionRaw += isset($studentAnswers[$item]) ? $studentAnswers[$item] : 0;
                    }
                    foreach ($anxietyItems as $item) {
                        $anxietyRaw += isset($studentAnswers[$item]) ? $studentAnswers[$item] : 0;
                    }
                    foreach ($stressItems as $item) {
                        $stressRaw += isset($studentAnswers[$item]) ? $studentAnswers[$item] : 0;
                    }

                    // Use raw summed scores (do not multiply by 2) to match stored totals
                    $depressionScore = $depressionRaw;
                    $anxietyScore = $anxietyRaw;
                    $stressScore = $stressRaw;

                    // Helper to get category color
                    $getCategoryColor = function ($qNum) use ($depressionItems, $anxietyItems, $stressItems) {
                        if (in_array($qNum, $depressionItems))
                            return '#0d6efd';
                        if (in_array($qNum, $anxietyItems))
                            return '#0099ff';
                        if (in_array($qNum, $stressItems))
                            return '#666';
                        return '#ccc';
                    };
                @endphp

                @for ($i = 1; $i <= 21; $i++)
                    @php
                        $q1 = $i;
                        $q2 = $i + 21;

                        // Check which category each question belongs to
                        $q1_isD = in_array($q1, $depressionItems) ? 1 : 0;
                        $q1_isA = in_array($q1, $anxietyItems) ? 1 : 0;
                        $q1_isS = in_array($q1, $stressItems) ? 1 : 0;

                        $q2_isD = in_array($q2, $depressionItems) ? 1 : 0;
                        $q2_isA = in_array($q2, $anxietyItems) ? 1 : 0;
                        $q2_isS = in_array($q2, $stressItems) ? 1 : 0;

                        // Calculate row scores
                        $rowDepression = 0;
                        $rowAnxiety = 0;
                        $rowStress = 0;

                        $q1_ans = $studentAnswers[$q1] ?? 0;
                        $q2_ans = $studentAnswers[$q2] ?? 0;

                        if ($q1_isD)
                            $rowDepression += $q1_ans;
                        if ($q1_isA)
                            $rowAnxiety += $q1_ans;
                        if ($q1_isS)
                            $rowStress += $q1_ans;

                        if ($q2_isD)
                            $rowDepression += $q2_ans;
                        if ($q2_isA)
                            $rowAnxiety += $q2_ans;
                        if ($q2_isS)
                            $rowStress += $q2_ans;
                    @endphp
                    <tr class="text-center align-middle">
                        {{-- First column: Questions 1-21 --}}
                        <td style="border: 1px solid #ddd;">{{ $q1 }}</td>
                        <td style="border: 1px solid #ddd; color: {{ $getCategoryColor($q1) }}; font-weight: bold;">
                            {{ $q1_ans }}
                        </td>

                        {{-- Second column: Questions 22-42 --}}
                        <td style="border: 1px solid #ddd;">{{ $q2 }}</td>
                        <td style="border: 1px solid #ddd; color: {{ $getCategoryColor($q2) }}; font-weight: bold;">
                            {{ $q2_ans }}
                        </td>

                        {{-- Depression Score for this row --}}
                        <td style="border: 1px solid #ddd; color: #0d6efd; font-weight: bold;">
                            {{ $rowDepression > 0 ? $rowDepression : '-' }}
                        </td>

                        {{-- Anxiety Score for this row --}}
                        <td style="border: 1px solid #ddd; color: #0099ff; font-weight: bold;">
                            {{ $rowAnxiety > 0 ? $rowAnxiety : '-' }}
                        </td>

                        {{-- Stress Score for this row --}}
                        <td style="border: 1px solid #ddd; color: #666; font-weight: bold;">
                            {{ $rowStress > 0 ? $rowStress : '-' }}
                        </td>
                    </tr>
                @endfor

                {{-- Total row --}}
                <tr class="fw-bold text-center" style="border: 2px solid #333;">
                    <td colspan="4" style="border: 1px solid #333;">Total</td>
                    <td style="border: 1px solid #333; color: #0d6efd; font-size: 1.1rem;">{{ $depressionScore }}</td>
                    <td style="border: 1px solid #333; color: #0099ff; font-size: 1.1rem;">{{ $anxietyScore }}</td>
                    <td style="border: 1px solid #333; color: #666; font-size: 1.1rem;">{{ $stressScore }}</td>
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