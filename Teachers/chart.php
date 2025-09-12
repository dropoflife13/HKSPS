<?php
require_once __DIR__ . '/../config/conn.php';

class TeacherChartData {
    private $conn;
    private $teacherId;

    public function __construct($conn, $teacherId) {
        $this->conn = $conn;
        $this->teacherId = $teacherId;
    }

    // Total students in the system
    public function getTotalStudents() {
        $query = "SELECT COUNT(*) AS total FROM users WHERE role = 'student'";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Total courses
    public function getTotalCourses() {
        $query = "SELECT COUNT(*) AS total FROM courses";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Total job postings by this teacher
    public function getJobPostingsCount() {
        $query = "SELECT COUNT(*) AS total FROM job_postings WHERE posted_by_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->teacherId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Total applications for this teacher's jobs
    public function getApplicationsCount() {
        $query = "SELECT COUNT(a.id) AS total
                  FROM applications a
                  JOIN job_postings jp ON a.job_id = jp.id
                  WHERE jp.posted_by_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->teacherId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // Recent activities by this teacher
    public function getRecentActivities($limit = 5) {
        $query = "SELECT action_type, description, created_at
                  FROM activities
                  WHERE user_id = ?
                  ORDER BY created_at DESC
                  LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $this->teacherId, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $activities = [];
        while ($row = $result->fetch_assoc()) {
            $activities[] = $row;
        }
        return $activities;
    }

    // Applicants per job for chart
    public function getApplicantsPerJob() {
        $query = "SELECT jp.title AS job_title, COUNT(a.id) AS total_applicants
                  FROM job_postings jp
                  LEFT JOIN applications a ON jp.id = a.job_id
                  WHERE jp.posted_by_id = ?
                  GROUP BY jp.id, jp.title";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->teacherId);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = ['labels' => [], 'data' => []];
        while ($row = $result->fetch_assoc()) {
            $data['labels'][] = $row['job_title'];
            $data['data'][] = $row['total_applicants'] ?? 0;
        }
        return $data;
    }
}

// Usage
$teacherId = 1; // Example teacher ID
$teacherChartData = new TeacherChartData($conn, $teacherId);

$totalStudents = $teacherChartData->getTotalStudents();
$totalCourses = $teacherChartData->getTotalCourses();
$jobPostings = $teacherChartData->getJobPostingsCount();
$applications = $teacherChartData->getApplicationsCount();
$recentActivities = $teacherChartData->getRecentActivities();
$applicantsPerJob = $teacherChartData->getApplicantsPerJob();
?>
