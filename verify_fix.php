<?php

function checkLogic($score)
{
    echo "Testing score: " . var_export($score, true) . "\n";
    $studentAnswers = [];
    if ($score) {
        if (is_array($score)) {
            $studentAnswers = $score;
        } elseif (is_string($score)) {
            // New logic
            $decoded = json_decode($score, true);
            $studentAnswers = is_array($decoded) ? $decoded : [];
        }
    }

    echo "Resulting studentAnswers type: " . gettype($studentAnswers) . "\n";
    echo "Resulting studentAnswers value: " . var_export($studentAnswers, true) . "\n";

    // Simulate foreach
    try {
        foreach ($studentAnswers as $k => $v) {
            // ok
        }
        echo "Loop succesful.\n";
    } catch (Throwable $e) {
        echo "Loop FAILED: " . $e->getMessage() . "\n";
    }
    echo "--------------------------------\n";
}

// Test cases
checkLogic("123");
checkLogic('{"1":2}');
checkLogic([]);
checkLogic(null);
checkLogic([1, 2, 3]);
