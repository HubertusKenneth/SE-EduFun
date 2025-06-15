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
$query = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
$result = mysqli_query($conn, $query);
if (!$result) {
    error_log("[web-app] MySQL error (student): " . mysqli_error($conn));
    echo 'false';
    exit;
}

$count = mysqli_num_rows($query);
$row = mysqli_fetch_array($query);

if ($count > 0){

$_SESSION['id']=$row['user_id'];

echo 'true';

mysqli_query($conn,"insert into user_log (username,login_date,user_id)values('$username',NOW(),".$row['user_id'].")")or die(mysqli_error());
	}else{ 
echo 'false';
}	
?>