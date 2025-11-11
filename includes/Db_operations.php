<?php
class Db_operations {
    private $con;

    function __construct(){
        require_once dirname(__FILE__).'/dbconnect.php';
        $db = new dbconnect();
        $this->con = $db->connect();
    }

    // -------------------------
    // USER FUNCTIONS
    // -------------------------
    public function createUser($username, $email, $gender, $pass, $weight) {
        if($this->isUserExist($username, $email)){
            return 1;
        } else {
            $password = password_hash($pass, PASSWORD_BCRYPT);
            $sql = "INSERT INTO train_up_users (username, email, gender, password, weight) VALUES ($1, $2, $3, $4, $5)";
            $result = pg_prepare($this->con, "create_user", $sql);
            $result = pg_execute($this->con, "create_user", array($username, $email, $gender, $password, $weight));
            
            if ($result) {
                return 0;
            } else {
                return 2;
            }
        }
    }

    public function userLogin($email, $pass) {
        $sql = "SELECT id, password FROM train_up_users WHERE email = $1";
        $result = pg_prepare($this->con, "login_query", $sql);
        $result = pg_execute($this->con, "login_query", array($email));
        
        if (pg_num_rows($result) == 0) {
            return 0;
        }
        
        $row = pg_fetch_assoc($result);
        if (password_verify($pass, $row['password'])) {
            return $row['id'];
        }
        return 0;
    }

    public function getUserByUsername($username){
        $sql = "SELECT * FROM train_up_users WHERE username = $1";
        $result = pg_prepare($this->con, "get_user_username", $sql);
        $result = pg_execute($this->con, "get_user_username", array($username));
        return pg_fetch_assoc($result);
    }

    public function getUserByEmail($useremail){
        $sql = "SELECT * FROM train_up_users WHERE email = $1";
        $result = pg_prepare($this->con, "get_user_email", $sql);
        $result = pg_execute($this->con, "get_user_email", array($useremail));
        return pg_fetch_assoc($result);
    }

    private function isUserExist($username, $email){
        $sql = "SELECT id FROM train_up_users WHERE username = $1 OR email = $2";
        $result = pg_prepare($this->con, "user_exist", $sql);
        $result = pg_execute($this->con, "user_exist", array($username, $email));
        return pg_num_rows($result) > 0;
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM train_up_users WHERE id = $1";
        $result = pg_prepare($this->con, "delete_user", $sql);
        $result = pg_execute($this->con, "delete_user", array($userId));
        
        if ($result) {
            if (pg_affected_rows($result) > 0) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    // -------------------------
    // ACTIVITY SAVE FUNCTIONS
    // -------------------------
    public function saveRunningActivity($userId, $distanceKm, $timeMinutes, $weather, $speedKmh, $caloriesBurned, $note) {
        $sql = "INSERT INTO running_activities (user_id, distance_km, time_minutes, weather, speed_kmh, calories_burned, note) VALUES ($1, $2, $3, $4, $5, $6, $7)";
        $result = pg_prepare($this->con, "save_running", $sql);
        $result = pg_execute($this->con, "save_running", array($userId, $distanceKm, $timeMinutes, $weather, $speedKmh, $caloriesBurned, $note));
        
        if ($result) {
            return array("error" => false, "message" => "Running activity saved successfully");
        } else {
            return array("error" => true, "message" => "Failed to save running activity");
        }
    }

    public function saveCyclingActivity($userId, $distanceKm, $timeMinutes, $weather, $bikeType, $speedKmh, $caloriesBurned, $note) {
        $sql = "INSERT INTO cycling_activities (user_id, distance, time_minutes, weather, bike_type, speed, calories, note) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $result = pg_prepare($this->con, "save_cycling", $sql);
        $result = pg_execute($this->con, "save_cycling", array($userId, $distanceKm, $timeMinutes, $weather, $bikeType, $speedKmh, $caloriesBurned, $note));
        
        if ($result) {
            return array("error" => false, "message" => "Cycling activity saved successfully");
        } else {
            return array("error" => true, "message" => "Failed to save cycling activity");
        }
    }

    public function saveWeightliftingActivity($userId, $exerciseName, $sets, $reps, $weightKg, $timeMinutes, $calories, $note) {
        $sql = "INSERT INTO weightlifting_activities (user_id, exercise_name, sets, reps, weight_kg, time_minutes, calories, note) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $result = pg_prepare($this->con, "save_weightlifting", $sql);
        $result = pg_execute($this->con, "save_weightlifting", array($userId, $exerciseName, $sets, $reps, $weightKg, $timeMinutes, $calories, $note));
        
        if ($result) {
            return array("error" => false, "message" => "Weightlifting activity saved successfully");
        } else {
            return array("error" => true, "message" => "Failed to save weightlifting activity");
        }
    }

    public function saveYogaActivity($userId, $sessionType, $durationMinutes, $intensity, $calories, $note) {
        $sql = "INSERT INTO yoga_activities (user_id, session_type, duration_minutes, intensity, calories, note) VALUES ($1, $2, $3, $4, $5, $6)";
        $result = pg_prepare($this->con, "save_yoga", $sql);
        $result = pg_execute($this->con, "save_yoga", array($userId, $sessionType, $durationMinutes, $intensity, $calories, $note));
        
        if ($result) {
            return array("error" => false, "message" => "Yoga activity saved successfully");
        } else {
            return array("error" => true, "message" => "Failed to save yoga activity");
        }
    }

    public function saveSwimmingActivity($userId, $distanceMeters, $timeMinutes, $weather, $strokeType, $speedMps, $caloriesBurned, $note) {
        $sql = "INSERT INTO swimming_activities (user_id, distance_meters, time_minutes, weather, stroke_type, speed_mps, calories_burned, note) VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
        $result = pg_prepare($this->con, "save_swimming", $sql);
        $result = pg_execute($this->con, "save_swimming", array($userId, $distanceMeters, $timeMinutes, $weather, $strokeType, $speedMps, $caloriesBurned, $note));
        
        if ($result) {
            return array("error" => false, "message" => "Swimming activity saved successfully");
        } else {
            return array("error" => true, "message" => "Failed to save swimming activity");
        }
    }

    public function saveWalkingActivity($userId, $distanceKm, $timeMinutes, $weather, $speedKmh, $caloriesBurned, $note) {
        $sql = "INSERT INTO walking_activities (user_id, distance_km, time_minutes, weather, speed_kmh, calories_burned, note) VALUES ($1, $2, $3, $4, $5, $6, $7)";
        $result = pg_prepare($this->con, "save_walking", $sql);
        $result = pg_execute($this->con, "save_walking", array($userId, $distanceKm, $timeMinutes, $weather, $speedKmh, $caloriesBurned, $note));
        
        if ($result) {
            return array("error" => false, "message" => "Walking activity saved successfully");
        } else {
            return array("error" => true, "message" => "Failed to save walking activity");
        }
    }

    // -------------------------
    // GOALS
    // -------------------------
    public function saveGoal($userId, $activityType, $durationOption = null, $notes = null) {
        $sql = "INSERT INTO goals (user_id, activity_type, duration_option, notes) VALUES ($1, $2, $3, $4) RETURNING id";
        $result = pg_prepare($this->con, "save_goal", $sql);
        $result = pg_execute($this->con, "save_goal", array($userId, $activityType, $durationOption, $notes));
        
        if ($result) {
            $row = pg_fetch_assoc($result);
            $goalId = $row['id'];
            return array('error' => false, 'message' => 'Goal created', 'goal_id' => $goalId);
        } else {
            return array('error' => true, 'message' => 'Failed to create goal');
        }
    }

    public function saveGoalTarget($goalId, $metricKey, $value, $unit = null) {
        $sql = "INSERT INTO goal_targets (goal_id, metric_key, value, unit) VALUES ($1, $2, $3, $4)";
        $result = pg_prepare($this->con, "save_goal_target", $sql);
        $result = pg_execute($this->con, "save_goal_target", array($goalId, $metricKey, $value, $unit));
        
        if ($result) {
            return array('error' => false, 'message' => 'Target saved');
        } else {
            return array('error' => true, 'message' => 'Failed to save target');
        }
    }

    // -------------------------
    // DASHBOARD STATISTICS
    // -------------------------
    public function getDashboardStats($userId) {
        $response = array();

        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');
        $week_start = date('Y-m-d 00:00:00', strtotime('-6 days'));
        $week_end = date('Y-m-d 23:59:59');

        $tables = [
            ['table' => 'running_activities', 'date' => 'created_at', 'cal' => 'calories_burned'],
            ['table' => 'cycling_activities', 'date' => 'created_at', 'cal' => 'calories'],
            ['table' => 'walking_activities', 'date' => 'created_at', 'cal' => 'calories_burned'],
            ['table' => 'yoga_activities', 'date' => 'created_at', 'cal' => 'calories'],
            ['table' => 'swimming_activities', 'date' => 'created_at', 'cal' => 'calories_burned'],
            ['table' => 'weightlifting_activities', 'date' => 'created_at', 'cal' => 'calories']
        ];

        $today_total = 0;
        $weekly_total = 0;
        $weekly_calories = 0.0;

        foreach ($tables as $t) {
            $table = $t['table'];
            $date_col = $t['date'];
            $cal_col = $t['cal'];

            // Today's total activities
            $sql = "SELECT COUNT(*) as total FROM $table WHERE user_id = $1 AND $date_col BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "today_$table", $sql);
            $result = pg_execute($this->con, "today_$table", array($userId, $today_start, $today_end));
            $today_result = pg_fetch_assoc($result);
            $today_count = intval($today_result['total'] ?? 0);
            $today_total += $today_count;

            // Weekly total + calories
            $sql = "SELECT COUNT(*) as total, COALESCE(SUM($cal_col), 0) as total_calories FROM $table WHERE user_id = $1 AND $date_col BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "week_$table", $sql);
            $result = pg_execute($this->con, "week_$table", array($userId, $week_start, $week_end));
            $week_result = pg_fetch_assoc($result);
            $week_count = intval($week_result['total'] ?? 0);
            $week_cal = floatval($week_result['total_calories'] ?? 0);

            $weekly_total += $week_count;
            $weekly_calories += $week_cal;
        }

        $response['error'] = false;
        $response['today_activities'] = (int)$today_total;
        $response['weekly_activities'] = (int)$weekly_total;
        $response['weekly_calories'] = round($weekly_calories, 2);
        $response['current_streak'] = $this->calculateCurrentStreak($userId);

        return $response;
    }

    // -------------------------
    // GET USER GOALS
    // -------------------------
    public function getUserGoals($userId) {
        $response = array();

        try {
            $sql = "SELECT g.id, g.activity_type, g.duration_option, g.notes, g.created_at, g.status 
                    FROM goals g 
                    WHERE g.user_id = $1 
                    ORDER BY g.created_at DESC 
                    LIMIT 100";
            $result = pg_prepare($this->con, "get_user_goals", $sql);
            $result = pg_execute($this->con, "get_user_goals", array($userId));

            $goals = array();
            while ($goal = pg_fetch_assoc($result)) {
                $goalId = $goal['id'];

                $targetSql = "SELECT metric_key, value, unit FROM goal_targets WHERE goal_id = $1";
                $targetResult = pg_prepare($this->con, "get_goal_targets", $targetSql);
                $targetResult = pg_execute($this->con, "get_goal_targets", array($goalId));

                $targets = array();
                while ($target = pg_fetch_assoc($targetResult)) {
                    $targets[] = $target;
                }

                $goal['targets'] = $targets;
                $goals[] = $goal;
            }

            if (count($goals) > 0) {
                $response['error'] = false;
                $response['goals'] = $goals;
            } else {
                $response['error'] = true;
                $response['message'] = 'No goals found for this user';
            }

        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = 'Error fetching goals: ' . $e->getMessage();
        }

        return $response;
    }

    // -------------------------
    // COMPREHENSIVE STATS
    // -------------------------
    public function getComprehensiveStatistics($userId) {
        $response = array();

        try {
            $basicStats = $this->getDashboardStats($userId);
            $performanceMetrics = $this->getPerformanceMetrics($userId);
            $personalRecords = $this->getPersonalRecords($userId);
            $goalAnalytics = $this->getGoalAnalytics($userId);
            $activityDistribution = $this->getActivityDistribution($userId);

            $response['error'] = false;
            $response['basic_stats'] = array(
                'weekly_activities' => $basicStats['weekly_activities'] ?? 0,
                'weekly_calories' => $basicStats['weekly_calories'] ?? 0,
                'today_activities' => $basicStats['today_activities'] ?? 0,
                'current_streak' => $basicStats['current_streak'] ?? $this->calculateCurrentStreak($userId)
            );
            $response['performance_metrics'] = $performanceMetrics;
            $response['personal_records'] = $personalRecords;
            $response['goal_analytics'] = $goalAnalytics;
            $response['activity_distribution'] = $activityDistribution;
            $response['current_streak'] = $basicStats['current_streak'] ?? $this->calculateCurrentStreak($userId);

        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = "Error fetching comprehensive statistics: " . $e->getMessage();
        }

        return $response;
    }

    // -------------------------
    // PERFORMANCE METRICS
    // -------------------------
    private function minutesFloatToMinSec($minutesFloat) {
        $totalSeconds = (int)round($minutesFloat * 60);
        $m = intdiv($totalSeconds, 60);
        $s = $totalSeconds % 60;
        return sprintf("%d:%02d", $m, $s);
    }

    public function getPerformanceMetrics($userId) {
        $metrics = array();

        try {
            // Running average pace
            $sql = "SELECT AVG(speed_kmh) as avg_speed FROM running_activities WHERE user_id = $1 AND speed_kmh > 0";
            $result = pg_prepare($this->con, "running_avg", $sql);
            $result = pg_execute($this->con, "running_avg", array($userId));
            $runningResult = pg_fetch_assoc($result);
            $avgRunningSpeed = floatval($runningResult['avg_speed'] ?? 0);
            $avgPace = $avgRunningSpeed > 0 ? (60 / $avgRunningSpeed) : 0.0;
            $metrics['avg_running_pace'] = $avgPace > 0 ? $this->minutesFloatToMinSec($avgPace) : "0:00";

            // Walking average pace
            $sql = "SELECT AVG(speed_kmh) as avg_speed FROM walking_activities WHERE user_id = $1 AND speed_kmh > 0";
            $result = pg_prepare($this->con, "walking_avg", $sql);
            $result = pg_execute($this->con, "walking_avg", array($userId));
            $walkingResult = pg_fetch_assoc($result);
            $avgWalkingSpeed = floatval($walkingResult['avg_speed'] ?? 0);
            $avgWalkingPace = $avgWalkingSpeed > 0 ? (60 / $avgWalkingSpeed) : 0.0;
            $metrics['avg_walking_pace'] = $avgWalkingPace > 0 ? $this->minutesFloatToMinSec($avgWalkingPace) : "0:00";

            // Swimming average pace
            $sql = "SELECT AVG(speed_mps) as avg_speed FROM swimming_activities WHERE user_id = $1 AND speed_mps > 0";
            $result = pg_prepare($this->con, "swimming_avg", $sql);
            $result = pg_execute($this->con, "swimming_avg", array($userId));
            $swimResult = pg_fetch_assoc($result);
            $avgSwimSpeed = floatval($swimResult['avg_speed'] ?? 0);
            if ($avgSwimSpeed > 0) {
                $minutesPer100m = 100 / ($avgSwimSpeed * 60.0);
                $metrics['avg_swimming_pace'] = $this->minutesFloatToMinSec($minutesPer100m);
            } else {
                $metrics['avg_swimming_pace'] = "0:00";
            }

            // Cycling average speed
            $sql = "SELECT AVG(speed) as avg_speed FROM cycling_activities WHERE user_id = $1 AND speed > 0";
            $result = pg_prepare($this->con, "cycling_avg", $sql);
            $result = pg_execute($this->con, "cycling_avg", array($userId));
            $cyclingResult = pg_fetch_assoc($result);
            $metrics['avg_cycling_speed'] = $cyclingResult['avg_speed'] ? number_format(floatval($cyclingResult['avg_speed']), 1) : "0.0";

            // Max weight lifted
            $sql = "SELECT MAX(weight_kg) as max_weight FROM weightlifting_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "max_weight", $sql);
            $result = pg_execute($this->con, "max_weight", array($userId));
            $weightResult = pg_fetch_assoc($result);
            $metrics['max_weight'] = $weightResult['max_weight'] !== null ? intval($weightResult['max_weight']) : 0;

            // Average yoga duration
            $sql = "SELECT AVG(duration_minutes) as avg_duration FROM yoga_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "yoga_avg", $sql);
            $result = pg_execute($this->con, "yoga_avg", array($userId));
            $yogaResult = pg_fetch_assoc($result);
            $metrics['avg_yoga_duration'] = $yogaResult['avg_duration'] ? round(floatval($yogaResult['avg_duration'])) : 0;

        } catch (Exception $e) {
            $metrics['avg_running_pace'] = "0:00";
            $metrics['avg_cycling_speed'] = "0.0";
            $metrics['max_weight'] = 0;
            $metrics['avg_yoga_duration'] = 0;
            $metrics['avg_swimming_pace'] = "0:00";
            $metrics['avg_walking_pace'] = "0:00";
        }

        return $metrics;
    }

    // -------------------------
    // PERSONAL RECORDS
    // -------------------------
    public function getPersonalRecords($userId) {
        $records = array();

        try {
            // Longest run
            $sql = "SELECT MAX(distance_km) as longest_run FROM running_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "longest_run", $sql);
            $result = pg_execute($this->con, "longest_run", array($userId));
            $runResult = pg_fetch_assoc($result);
            $records['longest_run'] = $runResult['longest_run'] !== null ? number_format(floatval($runResult['longest_run']), 1) : "0.0";

            // Longest cycling ride
            $sql = "SELECT MAX(distance) as longest_ride FROM cycling_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "longest_ride", $sql);
            $result = pg_execute($this->con, "longest_ride", array($userId));
            $cycleResult = pg_fetch_assoc($result);
            $records['longest_ride'] = $cycleResult['longest_ride'] !== null ? number_format(floatval($cycleResult['longest_ride']), 1) : "0.0";

            // Heaviest weight lifted
            $sql = "SELECT MAX(weight_kg) as heaviest_lift FROM weightlifting_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "heaviest_lift", $sql);
            $result = pg_execute($this->con, "heaviest_lift", array($userId));
            $weightResult = pg_fetch_assoc($result);
            $records['heaviest_lift'] = $weightResult['heaviest_lift'] !== null ? intval($weightResult['heaviest_lift']) : 0;

            // Longest swim
            $sql = "SELECT MAX(distance_meters) as longest_swim FROM swimming_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "longest_swim", $sql);
            $result = pg_execute($this->con, "longest_swim", array($userId));
            $swimResult = pg_fetch_assoc($result);
            $records['longest_swim'] = $swimResult['longest_swim'] !== null ? number_format((floatval($swimResult['longest_swim']) / 1000.0), 1) : "0.0";

            // Longest walk
            $sql = "SELECT MAX(distance_km) as longest_walk FROM walking_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "longest_walk", $sql);
            $result = pg_execute($this->con, "longest_walk", array($userId));
            $walkResult = pg_fetch_assoc($result);
            $records['longest_walk'] = $walkResult['longest_walk'] !== null ? number_format(floatval($walkResult['longest_walk']), 1) : "0.0";

            // Longest yoga session
            $sql = "SELECT MAX(duration_minutes) as longest_yoga FROM yoga_activities WHERE user_id = $1";
            $result = pg_prepare($this->con, "longest_yoga", $sql);
            $result = pg_execute($this->con, "longest_yoga", array($userId));
            $yogaResult = pg_fetch_assoc($result);
            $records['longest_yoga'] = $yogaResult['longest_yoga'] !== null ? intval($yogaResult['longest_yoga']) : 0;

        } catch (Exception $e) {
            $records['longest_run'] = "0.0";
            $records['longest_ride'] = "0.0";
            $records['heaviest_lift'] = 0;
            $records['longest_swim'] = "0.0";
            $records['longest_walk'] = "0.0";
            $records['longest_yoga'] = 0;
        }

        return $records;
    }

    // -------------------------
    // GOAL ANALYTICS
    // -------------------------
    public function getGoalAnalytics($userId) {
        $analytics = array();

        try {
            $goalsResponse = $this->getUserGoals($userId);

            if (!$goalsResponse['error'] && isset($goalsResponse['goals'])) {
                $goals = $goalsResponse['goals'];
                $completed = 0;
                $inProgress = 0;

                $activityProgress = [
                    'running' => ['progress_sum' => 0, 'goal_count' => 0],
                    'cycling' => ['progress_sum' => 0, 'goal_count' => 0],
                    'weightlifting' => ['progress_sum' => 0, 'goal_count' => 0],
                    'yoga' => ['progress_sum' => 0, 'goal_count' => 0],
                    'swimming' => ['progress_sum' => 0, 'goal_count' => 0],
                    'walking' => ['progress_sum' => 0, 'goal_count' => 0]
                ];

                foreach ($goals as $goal) {
                    $activityType = strtolower($goal['activity_type'] ?? '');
                    $targets = $goal['targets'] ?? [];
                    $durationOption = $goal['duration_option'] ?? '';
                    $goalCreatedAt = $goal['created_at'] ?? '';
                    
                    if (isset($activityProgress[$activityType]) && !empty($targets)) {
                        $goalProgress = $this->calculateGoalProgress($userId, $activityType, $targets, $durationOption, $goalCreatedAt);
                        $activityProgress[$activityType]['progress_sum'] += $goalProgress;
                        $activityProgress[$activityType]['goal_count']++;
                        
                        if ($goalProgress >= 100) {
                            $completed++;
                        } else {
                            $inProgress++;
                        }
                    } else {
                        $inProgress++;
                    }
                }

                $analytics['completed'] = $completed;
                $analytics['in_progress'] = $inProgress;
                $analytics['success_rate'] = ($completed + $inProgress) > 0 ? 
                    round(($completed / ($completed + $inProgress)) * 100) : 0;

                foreach ($activityProgress as $activity => $data) {
                    $averageProgress = $data['goal_count'] > 0 ? 
                        round($data['progress_sum'] / $data['goal_count']) : 0;
                    $analytics[$activity . '_progress'] = $averageProgress;
                }

            } else {
                $analytics['completed'] = 0;
                $analytics['in_progress'] = 0;
                $analytics['success_rate'] = 0;
                $analytics['running_progress'] = 0;
                $analytics['cycling_progress'] = 0;
                $analytics['weightlifting_progress'] = 0;
                $analytics['yoga_progress'] = 0;
                $analytics['swimming_progress'] = 0;
                $analytics['walking_progress'] = 0;
            }

        } catch (Exception $e) {
            $analytics['completed'] = 0;
            $analytics['in_progress'] = 0;
            $analytics['success_rate'] = 0;
            $analytics['running_progress'] = 0;
            $analytics['cycling_progress'] = 0;
            $analytics['weightlifting_progress'] = 0;
            $analytics['yoga_progress'] = 0;
            $analytics['swimming_progress'] = 0;
            $analytics['walking_progress'] = 0;
        }

        return $analytics;
    }

    // -------------------------
    // CALCULATE INDIVIDUAL GOAL PROGRESS WITH TIME SCOPE
    // -------------------------
    private function calculateGoalProgress($userId, $activityType, $targets, $durationOption, $goalCreatedAt) {
        $totalProgress = 0;
        $targetCount = 0;

        foreach ($targets as $target) {
            $metricKey = strtolower($target['metric_key'] ?? '');
            $targetValue = floatval($target['value'] ?? 0);
            $unit = strtolower($target['unit'] ?? '');

            if ($targetValue <= 0) continue;

            $actualValue = $this->getBestPerformance($userId, $activityType, $metricKey, $durationOption, $goalCreatedAt);
            $progress = $this->calculateMetricProgress($actualValue, $targetValue, $metricKey);
            
            $totalProgress += $progress;
            $targetCount++;
        }

        return $targetCount > 0 ? round($totalProgress / $targetCount) : 0;
    }

    // -------------------------
    // GET BEST PERFORMANCE FROM LOGGED ACTIVITIES WITH TIME SCOPE
    // -------------------------
    private function getBestPerformance($userId, $activityType, $metricKey, $durationOption, $goalCreatedAt) {
        $tableMap = [
            'running' => 'running_activities',
            'cycling' => 'cycling_activities', 
            'weightlifting' => 'weightlifting_activities',
            'yoga' => 'yoga_activities',
            'swimming' => 'swimming_activities',
            'walking' => 'walking_activities'
        ];

        $columnMap = [
            'target_time_minutes' => ['running' => 'time_minutes', 'cycling' => 'time_minutes', 'walking' => 'time_minutes', 'swimming' => 'time_minutes', 'yoga' => 'duration_minutes', 'weightlifting' => 'time_minutes'],
            'target_duration_minutes' => ['running' => 'time_minutes', 'cycling' => 'time_minutes', 'walking' => 'time_minutes', 'swimming' => 'time_minutes', 'yoga' => 'duration_minutes', 'weightlifting' => 'time_minutes'],
            'target_distance_km' => ['running' => 'distance_km', 'cycling' => 'distance', 'walking' => 'distance_km'],
            'target_distance_meters' => ['swimming' => 'distance_meters'],
            'target_speed_kmh' => ['running' => 'speed_kmh', 'cycling' => 'speed', 'walking' => 'speed_kmh'],
            'target_speed_mps' => ['swimming' => 'speed_mps'],
            'target_weight_kg' => ['weightlifting' => 'weight_kg'],
            'target_reps' => ['weightlifting' => 'reps'],
            'target_sets' => ['weightlifting' => 'sets'],
            'target_calories' => ['running' => 'calories_burned', 'cycling' => 'calories', 'walking' => 'calories_burned', 'swimming' => 'calories_burned', 'yoga' => 'calories', 'weightlifting' => 'calories'],
            
            'time_minutes' => ['running' => 'time_minutes', 'cycling' => 'time_minutes', 'walking' => 'time_minutes', 'swimming' => 'time_minutes', 'yoga' => 'duration_minutes', 'weightlifting' => 'time_minutes'],
            'duration' => ['running' => 'time_minutes', 'cycling' => 'time_minutes', 'walking' => 'time_minutes', 'swimming' => 'time_minutes', 'yoga' => 'duration_minutes', 'weightlifting' => 'time_minutes'],
            'distance' => ['running' => 'distance_km', 'cycling' => 'distance', 'walking' => 'distance_km', 'swimming' => 'distance_meters'],
            'speed' => ['running' => 'speed_kmh', 'cycling' => 'speed', 'walking' => 'speed_kmh', 'swimming' => 'speed_mps'],
            'weight' => ['weightlifting' => 'weight_kg'],
            'reps' => ['weightlifting' => 'reps'],
            'sets' => ['weightlifting' => 'sets'],
            'calories' => ['running' => 'calories_burned', 'cycling' => 'calories', 'walking' => 'calories_burned', 'swimming' => 'calories_burned', 'yoga' => 'calories', 'weightlifting' => 'calories']
        ];

        $table = $tableMap[$activityType] ?? '';
        
        $column = $columnMap[$metricKey][$activityType] 
                ?? $columnMap[$this->stripTargetPrefix($metricKey)][$activityType] 
                ?? $columnMap[$this->extractGenericMetric($metricKey)][$activityType] 
                ?? '';

        if (empty($table) || empty($column)) {
            return 0;
        }

        try {
            $timeWindow = $this->calculateTimeWindow($durationOption, $goalCreatedAt);
            $startDate = $timeWindow['start'];
            $endDate = $timeWindow['end'];

            $sql = "SELECT MAX($column) as best_value FROM $table WHERE user_id = $1 AND $column > 0 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "best_performance", $sql);
            $result = pg_execute($this->con, "best_performance", array($userId, $startDate, $endDate));
            $result = pg_fetch_assoc($result);
            $bestValue = floatval($result['best_value'] ?? 0);
            return $bestValue;
        } catch (Exception $e) {
            return 0;
        }
    }

    // -------------------------
    // CALCULATE TIME WINDOW FOR GOALS
    // -------------------------
    private function calculateTimeWindow($durationOption, $goalCreatedAt) {
        $createdDate = date('Y-m-d H:i:s', strtotime($goalCreatedAt));
        $startDate = $createdDate;
        
        switch ($durationOption) {
            case 'Today':
                $endDate = date('Y-m-d 23:59:59', strtotime($createdDate));
                break;
            case 'In two weeks':
                $endDate = date('Y-m-d 23:59:59', strtotime($createdDate . ' +14 days'));
                break;
            case 'In three months':
                $endDate = date('Y-m-d 23:59:59', strtotime($createdDate . ' +90 days'));
                break;
            default:
                $endDate = date('Y-m-d 23:59:59', strtotime($createdDate));
                break;
        }
        
        return [
            'start' => $startDate,
            'end' => $endDate
        ];
    }

    // Helper to strip "target_" prefix
    private function stripTargetPrefix($metricKey) {
        if (strpos($metricKey, 'target_') === 0) {
            return substr($metricKey, 7);
        }
        return $metricKey;
    }

    // Improved helper method to extract generic metric
    private function extractGenericMetric($metricKey) {
        $cleanKey = $this->stripTargetPrefix($metricKey);
        $parts = explode('_', $cleanKey);
        if (count($parts) > 1) {
            return end($parts);
        }
        return $cleanKey;
    }

    // -------------------------
    // CALCULATE PROGRESS FOR A SPECIFIC METRIC
    // -------------------------
    private function calculateMetricProgress($actualValue, $targetValue, $metricKey) {
        if ($actualValue <= 0) return 0;
        if ($targetValue <= 0) return 0;

        $progress = ($actualValue / $targetValue) * 100;
        return min(100, round($progress));
    }

    // -------------------------
    // ACTIVITY DISTRIBUTION
    // -------------------------
    public function getActivityDistribution($userId) {
        $distribution = array();

        try {
            $tables = [
                'running_activities',
                'cycling_activities',
                'weightlifting_activities',
                'yoga_activities',
                'swimming_activities',
                'walking_activities'
            ];

            $totalActivities = 0;
            $counts = array();

            foreach ($tables as $table) {
                $sql = "SELECT COUNT(*) as count FROM $table WHERE user_id = $1";
                $result = pg_prepare($this->con, "count_$table", $sql);
                $result = pg_execute($this->con, "count_$table", array($userId));
                $result = pg_fetch_assoc($result);
                $count = intval($result['count'] ?? 0);
                $counts[$table] = $count;
                $totalActivities += $count;
            }

            if ($totalActivities > 0) {
                $distribution['running'] = round(($counts['running_activities'] / $totalActivities) * 100);
                $distribution['cycling'] = round(($counts['cycling_activities'] / $totalActivities) * 100);
                $distribution['weightlifting'] = round(($counts['weightlifting_activities'] / $totalActivities) * 100);
                $distribution['yoga'] = round(($counts['yoga_activities'] / $totalActivities) * 100);
                $distribution['swimming'] = round(($counts['swimming_activities'] / $totalActivities) * 100);
                $distribution['walking'] = round(($counts['walking_activities'] / $totalActivities) * 100);
            } else {
                $distribution['running'] = 0;
                $distribution['cycling'] = 0;
                $distribution['weightlifting'] = 0;
                $distribution['yoga'] = 0;
                $distribution['swimming'] = 0;
                $distribution['walking'] = 0;
            }

        } catch (Exception $e) {
            $distribution['running'] = 0;
            $distribution['cycling'] = 0;
            $distribution['weightlifting'] = 0;
            $distribution['yoga'] = 0;
            $distribution['swimming'] = 0;
            $distribution['walking'] = 0;
        }

        return $distribution;
    }

    // -------------------------
    // CURRENT STREAK
    // -------------------------
    public function calculateCurrentStreak($userId) {
        try {
            $sql = "SELECT COUNT(DISTINCT DATE(created_at)) as active_days 
                    FROM (
                        SELECT created_at FROM running_activities WHERE user_id = $1
                        UNION ALL SELECT created_at FROM cycling_activities WHERE user_id = $2
                        UNION ALL SELECT created_at FROM weightlifting_activities WHERE user_id = $3
                        UNION ALL SELECT created_at FROM yoga_activities WHERE user_id = $4
                        UNION ALL SELECT created_at FROM swimming_activities WHERE user_id = $5
                        UNION ALL SELECT created_at FROM walking_activities WHERE user_id = $6
                    ) AS all_activities 
                    WHERE created_at >= CURRENT_DATE - INTERVAL '30 days'";
            
            $result = pg_prepare($this->con, "current_streak", $sql);
            $result = pg_execute($this->con, "current_streak", array($userId, $userId, $userId, $userId, $userId, $userId));
            $result = pg_fetch_assoc($result);
            return intval($result['active_days'] ?? 0);

        } catch (Exception $e) {
            return 0;
        }
    }

    // -------------------------
    // CURRENT MONTH CALORIES DATA FOR CHART
    // -------------------------
    public function getCurrentMonthCaloriesData($userId) {
        $response = array();
        
        try {
            $currentMonthStart = date('Y-m-01');
            $currentMonthEnd = date('Y-m-t');
            $currentMonthLabel = date('F Y');
            
            $caloriesData = array(
                'running' => 0,
                'cycling' => 0,
                'weightlifting' => 0,
                'yoga' => 0,
                'swimming' => 0,
                'walking' => 0
            );
            
            // Running calories
            $sql = "SELECT COALESCE(SUM(calories_burned), 0) as total_calories FROM running_activities WHERE user_id = $1 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "month_running", $sql);
            $result = pg_execute($this->con, "month_running", array($userId, $currentMonthStart, $currentMonthEnd));
            $result = pg_fetch_assoc($result);
            $caloriesData['running'] = floatval($result['total_calories'] ?? 0);
            
            // Cycling calories
            $sql = "SELECT COALESCE(SUM(calories), 0) as total_calories FROM cycling_activities WHERE user_id = $1 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "month_cycling", $sql);
            $result = pg_execute($this->con, "month_cycling", array($userId, $currentMonthStart, $currentMonthEnd));
            $result = pg_fetch_assoc($result);
            $caloriesData['cycling'] = floatval($result['total_calories'] ?? 0);
            
            // Weightlifting calories
            $sql = "SELECT COALESCE(SUM(calories), 0) as total_calories FROM weightlifting_activities WHERE user_id = $1 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "month_weightlifting", $sql);
            $result = pg_execute($this->con, "month_weightlifting", array($userId, $currentMonthStart, $currentMonthEnd));
            $result = pg_fetch_assoc($result);
            $caloriesData['weightlifting'] = floatval($result['total_calories'] ?? 0);
            
            // Yoga calories
            $sql = "SELECT COALESCE(SUM(calories), 0) as total_calories FROM yoga_activities WHERE user_id = $1 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "month_yoga", $sql);
            $result = pg_execute($this->con, "month_yoga", array($userId, $currentMonthStart, $currentMonthEnd));
            $result = pg_fetch_assoc($result);
            $caloriesData['yoga'] = floatval($result['total_calories'] ?? 0);
            
            // Swimming calories
            $sql = "SELECT COALESCE(SUM(calories_burned), 0) as total_calories FROM swimming_activities WHERE user_id = $1 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "month_swimming", $sql);
            $result = pg_execute($this->con, "month_swimming", array($userId, $currentMonthStart, $currentMonthEnd));
            $result = pg_fetch_assoc($result);
            $caloriesData['swimming'] = floatval($result['total_calories'] ?? 0);
            
            // Walking calories
            $sql = "SELECT COALESCE(SUM(calories_burned), 0) as total_calories FROM walking_activities WHERE user_id = $1 AND created_at BETWEEN $2 AND $3";
            $result = pg_prepare($this->con, "month_walking", $sql);
            $result = pg_execute($this->con, "month_walking", array($userId, $currentMonthStart, $currentMonthEnd));
            $result = pg_fetch_assoc($result);
            $caloriesData['walking'] = floatval($result['total_calories'] ?? 0);
            
            $response['error'] = false;
            $response['current_month'] = $currentMonthLabel;
            $response['calories_data'] = $caloriesData;
            
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = "Error fetching current month calories data: " . $e->getMessage();
        }
        
        return $response;
    }

    // -------------------------
    // USER PROFILE STATS
    // -------------------------
    public function getUserProfileStats($userId) {
        $response = array();
        
        try {
            $totalActivities = $this->getTotalActivitiesCount($userId);
            $totalGoals = $this->getTotalGoalsCount($userId);
            
            $response['error'] = false;
            $response['total_activities'] = $totalActivities;
            $response['total_goals'] = $totalGoals;
            
        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = "Error fetching profile stats: " . $e->getMessage();
        }
        
        return $response;
    }

    private function getTotalActivitiesCount($userId) {
        $tables = [
            'running_activities',
            'cycling_activities', 
            'weightlifting_activities',
            'yoga_activities',
            'swimming_activities',
            'walking_activities'
        ];
        
        $totalCount = 0;
        
        foreach ($tables as $table) {
            $sql = "SELECT COUNT(*) as count FROM $table WHERE user_id = $1";
            $result = pg_prepare($this->con, "total_$table", $sql);
            $result = pg_execute($this->con, "total_$table", array($userId));
            $result = pg_fetch_assoc($result);
            $totalCount += intval($result['count'] ?? 0);
        }
        
        return $totalCount;
    }

    private function getTotalGoalsCount($userId) {
        $sql = "SELECT COUNT(*) as total_goals FROM goals WHERE user_id = $1";
        $result = pg_prepare($this->con, "total_goals", $sql);
        $result = pg_execute($this->con, "total_goals", array($userId));
        $result = pg_fetch_assoc($result);
        return intval($result['total_goals'] ?? 0);
    }

    // -------------------------
    // GET ALL ACTIVITIES
    // -------------------------
    public function getAllActivities($userId) {
        $response = array();

        try {
            $activities = array();

            // Running activities
            $sql = "SELECT id, 'running' as activity_type, distance_km, time_minutes, weather, speed_kmh, calories_burned as calories, note, created_at FROM running_activities WHERE user_id = $1 ORDER BY created_at DESC";
            $result = pg_prepare($this->con, "all_running", $sql);
            $result = pg_execute($this->con, "all_running", array($userId));
            $rows = pg_fetch_all($result);
            if ($rows) {
                foreach($rows as $row) {
                    $activities[] = $row;
                }
            }

            // Cycling activities
            $sql = "SELECT id, 'cycling' as activity_type, distance as distance_km, time_minutes, weather, speed as speed_kmh, calories, note, created_at FROM cycling_activities WHERE user_id = $1 ORDER BY created_at DESC";
            $result = pg_prepare($this->con, "all_cycling", $sql);
            $result = pg_execute($this->con, "all_cycling", array($userId));
            $rows = pg_fetch_all($result);
            if ($rows) {
                foreach($rows as $row) {
                    $activities[] = $row;
                }
            }

            // Walking activities
            $sql = "SELECT id, 'walking' as activity_type, distance_km, time_minutes, weather, speed_kmh, calories_burned as calories, note, created_at FROM walking_activities WHERE user_id = $1 ORDER BY created_at DESC";
            $result = pg_prepare($this->con, "all_walking", $sql);
            $result = pg_execute($this->con, "all_walking", array($userId));
            $rows = pg_fetch_all($result);
            if ($rows) {
                foreach($rows as $row) {
                    $activities[] = $row;
                }
            }

            // Swimming activities
            $sql = "SELECT id, 'swimming' as activity_type, distance_meters, time_minutes, weather, stroke_type, speed_mps, calories_burned as calories, note, created_at FROM swimming_activities WHERE user_id = $1 ORDER BY created_at DESC";
            $result = pg_prepare($this->con, "all_swimming", $sql);
            $result = pg_execute($this->con, "all_swimming", array($userId));
            $rows = pg_fetch_all($result);
            if ($rows) {
                foreach($rows as $row) {
                    $activities[] = $row;
                }
            }

            // Yoga activities
            $sql = "SELECT id, 'yoga' as activity_type, session_type, duration_minutes as time_minutes, intensity, calories, note, created_at FROM yoga_activities WHERE user_id = $1 ORDER BY created_at DESC";
            $result = pg_prepare($this->con, "all_yoga", $sql);
            $result = pg_execute($this->con, "all_yoga", array($userId));
            $rows = pg_fetch_all($result);
            if ($rows) {
                foreach($rows as $row) {
                    $activities[] = $row;
                }
            }

            // Weightlifting activities
            $sql = "SELECT id, 'weightlifting' as activity_type, exercise_name, sets, reps, weight_kg, time_minutes, calories, note, created_at FROM weightlifting_activities WHERE user_id = $1 ORDER BY created_at DESC";
            $result = pg_prepare($this->con, "all_weightlifting", $sql);
            $result = pg_execute($this->con, "all_weightlifting", array($userId));
            $rows = pg_fetch_all($result);
            if ($rows) {
                foreach($rows as $row) {
                    $activities[] = $row;
                }
            }

            // Sort all activities by date (newest first)
            usort($activities, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            $response['error'] = false;
            $response['activities'] = $activities;

        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = "Error fetching activities: " . $e->getMessage();
        }

        return $response;
    }

    // -------------------------
    // DELETE ACTIVITY
    // -------------------------
    public function deleteActivity($userId, $activityId, $activityType) {
        $response = array();

        try {
            $tableMap = [
                'running' => 'running_activities',
                'cycling' => 'cycling_activities',
                'walking' => 'walking_activities',
                'swimming' => 'swimming_activities',
                'yoga' => 'yoga_activities',
                'weightlifting' => 'weightlifting_activities'
            ];

            $table = $tableMap[$activityType] ?? '';

            if (empty($table)) {
                throw new Exception("Invalid activity type");
            }

            $sql = "DELETE FROM $table WHERE id = $1 AND user_id = $2";
            $result = pg_prepare($this->con, "delete_activity", $sql);
            $result = pg_execute($this->con, "delete_activity", array($activityId, $userId));
            
            if ($result) {
                if (pg_affected_rows($result) > 0) {
                    $response['error'] = false;
                    $response['message'] = "Activity deleted successfully";
                } else {
                    $response['error'] = true;
                    $response['message'] = "Activity not found or you don't have permission";
                }
            } else {
                throw new Exception("Failed to delete activity");
            }

        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = "Error deleting activity: " . $e->getMessage();
        }

        return $response;
    }

    // -------------------------
    // DELETE GOAL
    // -------------------------
    public function deleteGoal($userId, $goalId) {
        $response = array();

        try {
            // First delete goal targets
            $sql = "DELETE FROM goal_targets WHERE goal_id = $1";
            $result = pg_prepare($this->con, "delete_goal_targets", $sql);
            $result = pg_execute($this->con, "delete_goal_targets", array($goalId));

            // Then delete the goal
            $sql = "DELETE FROM goals WHERE id = $1 AND user_id = $2";
            $result = pg_prepare($this->con, "delete_goal", $sql);
            $result = pg_execute($this->con, "delete_goal", array($goalId, $userId));
            
            if ($result) {
                if (pg_affected_rows($result) > 0) {
                    $response['error'] = false;
                    $response['message'] = "Goal deleted successfully";
                } else {
                    $response['error'] = true;
                    $response['message'] = "Goal not found or you don't have permission";
                }
            } else {
                throw new Exception("Failed to delete goal");
            }

        } catch (Exception $e) {
            $response['error'] = true;
            $response['message'] = "Error deleting goal: " . $e->getMessage();
        }

        return $response;
    }
}
?>
