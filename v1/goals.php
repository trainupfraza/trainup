<?php
require_once '../includes/Db_operations.php';
header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(array('error' => true, 'message' => 'Invalid Request'));
    exit;
}

$userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
$activityType = isset($_POST['activity_type']) ? trim($_POST['activity_type']) : null;
$targetsJson = isset($_POST['targets']) ? $_POST['targets'] : null;
$durationOption = isset($_POST['duration_option']) ? trim($_POST['duration_option']) : null;
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';

if ($userId <= 0 || empty($activityType) || empty($targetsJson)) {
    echo json_encode(array('error' => true, 'message' => 'Missing required fields'));
    exit;
}

$db = new Db_operations();
$goalResult = $db->saveGoal($userId, $activityType, $durationOption, $notes);
if ($goalResult['error']) {
    echo json_encode($goalResult);
    exit;
}

$goalId = $goalResult['goal_id'];
$targets = json_decode($targetsJson, true);
if (!is_array($targets)) {
    echo json_encode(array('error' => true, 'message' => 'Targets JSON invalid'));
    exit;
}

$errors = array();
foreach ($targets as $t) {
    if (!isset($t['metric_key']) || !isset($t['value'])) continue;
    $metric = $t['metric_key'];
    $value = $t['value'];
    $unit = isset($t['unit']) ? $t['unit'] : null;

    $res = $db->saveGoalTarget($goalId, $metric, $value, $unit);
    if ($res['error']) $errors[] = $res['message'];
}

if (count($errors) === 0) {
    echo json_encode(array('error' => false, 'message' => 'Goal and targets saved successfully', 'goal_id' => $goalId));
} else {
    echo json_encode(array('error' => true, 'message' => 'Saved with errors', 'details' => $errors, 'goal_id' => $goalId));
}
?>