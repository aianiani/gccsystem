<?php

$notifications = [
    'app/Notifications/AppointmentAcceptedNotification.php',
    'app/Notifications/AppointmentBookedNotification.php',
    'app/Notifications/AppointmentDeclinedNotification.php',
    'app/Notifications/AppointmentDeclinedByCounselorNotification.php',
    'app/Notifications/AppointmentRescheduleAcceptedNotification.php',
    'app/Notifications/AppointmentRescheduledNotification.php',
    'app/Notifications/AssessmentCompletedNotification.php',
    'app/Notifications/SeminarUnlocked.php',
];

foreach ($notifications as $file) {
    if (!file_exists($file)) continue;
    
    $content = file_get_contents($file);
    
    // Check if broadcast is already there
    if (str_contains($content, "'broadcast'")) continue;
    
    // Update via method
    // Match patterns like return ['mail', 'database']; or return ['database'];
    $content = preg_replace("/return\s*\[\s*'mail'\s*,\s*'database'\s*\]\s*;/", "return ['mail', 'database', 'broadcast'];", $content);
    $content = preg_replace("/return\s*\[\s*'database'\s*\]\s*;/", "return ['database', 'broadcast'];", $content);
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
