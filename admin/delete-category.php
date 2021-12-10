<?php
if($_SESSION['user_role'] != 1 ){
  header("Location: {$hostName}/admin/post.php");
}
include 'config.php';

$cat_id = $_GET['id'];

$sql = "DELETE FROM category WHERE category_id = {$cat_id};";

$result = mysqli_multi_query($conn, $sql);

if(mysqli_query($conn, $sql)){
  header("Location: {$hostName}/admin/category.php");
}else{
  echo "<h3 style = 'color:red;'>Category can't Delete.</h3>";
}
?>
