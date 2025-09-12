<?php
require_once __DIR__ . '/../modals/students.php';
showStudentModals();


$currentRole = $_SESSION['role'] ?? 'student';

if ($currentRole === 'admin') {
    $result = $conn->query("SELECT * FROM users WHERE role='student' ORDER BY id ASC");
    $tableType = 'students';
} else {
    $result = $conn->query("SELECT * FROM users WHERE role='student' ORDER BY id ASC");
    $tableType = 'students';
}

$headers = ['id'=>'ID','student_id'=>'Student ID','name'=>'Name','email'=>'Email','role'=>'Role'];

include __DIR__ . '/../includes/list.php';
