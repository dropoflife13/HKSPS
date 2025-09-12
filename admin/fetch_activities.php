<?php
require_once 'admin/chart.php'; // ChartData class and $conn

header('Content-Type: application/json');

// Fetch latest 50 student & teacher activities
$recentActivities = $chartData->getRecentActivities(50, ['student','teacher']);

// Format activities
foreach ($recentActivities as &$activity) {
    $activity['formatted_description'] = formatActivityDescription($activity);
    $activity['formatted_time'] = formatActivityTime($activity['created_at']);
}

echo json_encode($recentActivities);
