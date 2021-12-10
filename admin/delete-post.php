<?php
include 'config.php';

$post_id = $_GET['id'];
$category_id = $_GET['category'];

$sql1 = "SELECT * FROM post WHERE post_id = {$post_id}";
$result1 = mysqli_query($conn, $sql1) or die('Query faided in select.');
$row = mysqli_fetch_assoc($result1);

unlink("upload/".$row['post_img']);

$sql = "DELETE FROM post WHERE post_id = {$post_id};";
$sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$category_id}";

$result = mysqli_multi_query($conn, $sql);

if ($result) {
  header("Location: {$hostName}/admin/post.php");
}else{
  echo "Delete Query Failed.";
}
?>