<?php

// Simulate the scenario
$intScore = 123;
$decoded = json_decode($intScore, true);
echo "Decoded int: " . var_export($decoded, true) . "\n";
echo "Is array? " . (is_array($decoded) ? 'Yes' : 'No') . "\n";

if (!empty($decoded) && is_array($decoded)) {
    echo "Entering loop...\n";
    foreach ($decoded as $k => $v) {
        echo "$k => $v\n";
    }
} else {
    echo "Skipped loop (correctly)\n";
}

// Simulate string int
$stringInt = "123";
$decoded2 = json_decode($stringInt, true);
echo "Decoded string int: " . var_export($decoded2, true) . "\n";
echo "Is array? " . (is_array($decoded2) ? 'Yes' : 'No') . "\n";

// Simulate actual array json
$json = '{"1":2, "3":4}';
$decoded3 = json_decode($json, true);
echo "Decoded json: " . var_export($decoded3, true) . "\n";
echo "Is array? " . (is_array($decoded3) ? 'Yes' : 'No') . "\n";

// Simulate what if we mistakenly iterate an int
try {
    $val = 123;
    foreach ($val as $x) {
        echo "Iterating int...\n";
    }
} catch (Throwable $e) {
    echo "Caught expected error: " . $e->getMessage() . "\n";
}

// Simulate the partial logic
$assessment = (object) ['score' => 123];
$scores = is_array($assessment->score) ? $assessment->score : (is_string($assessment->score) ? json_decode($assessment->score, true) : []);
echo "Partial logic result for int 123: " . var_export($scores, true) . "\n";

// Simulate mixed case
$assessment2 = (object) ['score' => "123"];
// Current logic in partial:
// string "123" -> is_string true -> json_decode("123", true) -> 123
$scores2 = is_array($assessment2->score) ? $assessment2->score : (is_string($assessment2->score) ? json_decode($assessment2->score, true) : []);
echo "Partial logic result for string '123': " . var_export($scores2, true) . "\n";
// Result is 123 (int).
// So $scores2 IS INT.

// If we then foreach over $scores2...
try {
    foreach ($scores2 as $k => $v) {
        echo "Looping scores2...\n";
    }
} catch (Throwable $e) {
    echo "Caught error looping scores2: " . $e->getMessage() . "\n";
}
