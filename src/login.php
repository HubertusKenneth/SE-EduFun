<?php
include('admin/dbcon.php');
session_start();
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
if (!$username || !$password) {
    error_log("[web-app] Missing username or password in POST request.");
    echo 'false';
    exit;
}
/* student */
$query = "SELECT * FROM student WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
if (!$result) {
    error_log("[web-app] MySQL error (student): " . mysqli_error($conn));
    echo 'false';
    exit;
}
$row = mysqli_fetch_array($result);
$num_row = mysqli_num_rows($result);
/* teacher */
$query_teacher = "SELECT * FROM teacher WHERE username='$username' AND password='$password'";
$result_teacher = mysqli_query($conn, $query_teacher);
if (!$result_teacher) {
    error_log("[web-app] MySQL error (teacher): " . mysqli_error($conn));
    echo 'false';
    exit;
}
$row_teacher = mysqli_fetch_array($result_teacher);
$num_row_teacher = mysqli_num_rows($result_teacher);
if ($num_row > 0) {
    $_SESSION['id'] = $row['student_id'];
    echo 'true_student';
} elseif ($num_row_teacher > 0) {
    $_SESSION['id'] = $row_teacher['teacher_id'];
    echo 'true';
} else {
    error_log("[web-app] Invalid login attempt for username: $username");
    echo 'false';
}
?>

