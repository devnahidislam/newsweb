<?php
if($_SESSION['user_role'] != 1 ){
  header("Location: {$hostName}/admin/post.php");
}

include 'config.php';
$userId = $_GET['id'];
$sql = "DELETE FROM user WHERE user_id = {$userId}";
if(mysqli_query($conn, $sql)){
  header("Location: {$hostName}/admin/users.php");
}else{
  echo "<h3 style = 'color:red;'>User can't Delete.</h3>";
}
?>