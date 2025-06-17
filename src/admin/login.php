<?php
session_start();
include('dbcon.php');
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
if (!$username || !$password) {
    error_log("[web-app] Missing username or password in POST request.");
    echo 'false';
    exit;
}
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);
if (!$result) {
    error_log("[web-app] MySQL error (student): " . mysqli_error($conn));
    echo 'false';
    exit;
}

$count = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($count > 0) {
    $_SESSION['id'] = $row['user_id'];
    echo 'true';
    mysqli_query(
        $conn,
        "INSERT INTO user_log (username, login_date, user_id) VALUES('{$username}', NOW(), {$row['user_id']})") or die(mysqli_error($conn));
} else {
    echo 'false';
}

?>
