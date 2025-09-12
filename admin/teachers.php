<?php
require_once __DIR__ . '/../modals/teachers.php';
showTeacherModals();

$currentRole = $_SESSION['role'] ?? 'teacher';

if ($currentRole === 'admin') {
    $result = $conn->query("SELECT * FROM users WHERE role='teacher' ORDER BY id ASC");
} else {
    // teachers cannot see other teachers
    $result = [];
}

$headers = ['id'=>'ID','teacher_id'=>'Teacher ID','name'=>'Name','email'=>'Email','department_id'=>'Department','role'=>'Role'];

$tableType = 'teachers';
include __DIR__ . '/../includes/list.php';
