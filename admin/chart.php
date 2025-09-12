<?php
// admin/chart.php
require_once './config/conn.php'; // updated connection file

class ChartData {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
  // Get applications by status with error handling
public function getApplicationsByStatus() {
    $data = [
        'labels' => [],
        'data' => [],
        'colors' => []
    ];
    
    $colorMap = [
        'pending' => '#ffc107',
        'approved' => '#28a745',
        'rejected' => '#dc3545'
    ];
    
    try {
        $query = "SELECT status, COUNT(*) as count FROM applications GROUP BY status";
        $result = $this->conn->query($query);
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data['labels'][] = ucfirst($row['status']);
                $data['data'][] = $row['count'];
                $data['colors'][] = $colorMap[$row['status']] ?? '#6c757d'; // default color
            }
        }
    } catch (Exception $e) {
        error_log("Error in getApplicationsByStatus: " . $e->getMessage());
    }
    
    return $data;
}
    
   // Get job applications count with table check
public function getJobApplicationsCount() {
    $data = [
        'labels' => [],
        'data' => []
    ];
    
    // Check if both tables exist
    $tablesCheck = $this->conn->query("SHOW TABLES LIKE 'job_postings'");
    $tablesCheck2 = $this->conn->query("SHOW TABLES LIKE 'applications'");
    
    if ($tablesCheck->num_rows == 0 || $tablesCheck2->num_rows == 0) {
        return $data;
    }
    
    try {
        $query = "SELECT j.title, COUNT(a.id) as application_count 
                  FROM job_postings j 
                  LEFT JOIN applications a ON j.id = a.job_id 
                  GROUP BY j.id, j.title 
                  ORDER BY application_count DESC 
                  LIMIT 10";
        $result = $this->conn->query($query);
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data['labels'][] = $row['title'];
                $data['data'][] = $row['application_count'];
            }
        }
    } catch (Exception $e) {
        error_log("Error in getJobApplicationsCount: " . $e->getMessage());
    }
    
    return $data;
}
    
    // Get users by role
    public function getUsersByRole() {
        $query = "SELECT role, COUNT(*) as count FROM users GROUP BY role";
        $result = $this->conn->query($query);
        
        $data = [
            'labels' => [],
            'data' => [],
            'colors' => []
        ];
        
        $colorMap = [
            'student' => '#17a2b8',
            'teacher' => '#6f42c1',
            'admin' => '#343a40'
        ];
        
        while ($row = $result->fetch_assoc()) {
            $data['labels'][] = ucfirst($row['role']);
            $data['data'][] = $row['count'];
            $data['colors'][] = $colorMap[$row['role']];
        }
        
        return $data;
    }
    
    // Get applications by month
    public function getApplicationsByMonth() {
        $query = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month, 
                    COUNT(*) as count 
                  FROM applications 
                  WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH) 
                  GROUP BY DATE_FORMAT(created_at, '%Y-%m') 
                  ORDER BY month";
        $result = $this->conn->query($query);
        
        $data = [
            'labels' => [],
            'data' => []
        ];
        
        while ($row = $result->fetch_assoc()) {
            $data['labels'][] = date('M Y', strtotime($row['month']));
            $data['data'][] = $row['count'];
        }
        
        return $data;
    }
    
    // Get recent activities with error handling
    // Get recent activities with error handling
public function getRecentActivities($limit = 5, $roles = ['student', 'teacher']) {
    $tableCheck = $this->conn->query("SHOW TABLES LIKE 'activities'");
    if ($tableCheck->num_rows == 0) return [];

    // Prepare placeholders for roles
    $in = implode(',', array_fill(0, count($roles), '?'));

    $query = "SELECT 
                u.name as user_name, 
                u.role as user_role,
                a.action_type,
                a.description,
                a.created_at,
                j.title as job_title
              FROM activities a
              JOIN users u ON a.user_id = u.id
              LEFT JOIN job_postings j ON a.job_id = j.id
              WHERE u.role IN ($in)
              ORDER BY a.created_at DESC 
              LIMIT ?";

    $stmt = $this->conn->prepare($query);

    // Bind parameters dynamically
    $types = str_repeat('s', count($roles)) . 'i';
    $params = array_merge($roles, [$limit]);

    // MySQLi requires references for call_user_func_array
    $refs = [];
    foreach ($params as $key => $value) {
        $refs[$key] = &$params[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $refs));

    $stmt->execute();
    $result = $stmt->get_result();

    $activities = [];
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }

    $stmt->close();
    return $activities;
}


}

// Database connection
$chartData = new ChartData($conn);

// Get all chart data
$applicationsByStatus = $chartData->getApplicationsByStatus();
$jobApplicationsCount = $chartData->getJobApplicationsCount();
$usersByRole = $chartData->getUsersByRole();
$applicationsByMonth = $chartData->getApplicationsByMonth();
$recentActivities = $chartData->getRecentActivities(5);



// Format the activity description based on action type
function formatActivityDescription($activity) {
    switch ($activity['action_type']) {
        case 'application_submitted':
            return "Applied for " . ($activity['job_title'] ?: "a job");
        case 'job_posted':
            return "Posted a new job: " . ($activity['job_title'] ?: "");
        case 'application_approved':
            return "Application was approved for " . ($activity['job_title'] ?: "a job");
        case 'application_rejected':
            return "Application was not selected for " . ($activity['job_title'] ?: "a job");
        case 'hours_completed':
            return "Completed service hours";
        case 'profile_updated':
            return "Updated their profile";
        default:
            return $activity['description'] ?: "Performed an action";
    }
}

// Improved time formatting function
function formatActivityTime($timestamp) {
    if (!$timestamp) {
        return "Recently";
    }
    
    // Handle both string timestamps and Unix timestamps
    $activityTime = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);
    $currentTime = time();
    
    // Check if the timestamp is valid
    if (!$activityTime || $activityTime > $currentTime) {
        return "Recently";
    }
    
    $diff = $currentTime - $activityTime;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes != 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours != 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days != 1 ? 's' : '') . ' ago';
    } else {
        return date('M j, Y', $activityTime);
    }
}


?>
