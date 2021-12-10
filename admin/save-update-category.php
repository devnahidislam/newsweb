<?php
  include 'config.php';
  $sql1 = "UPDATE category SET category_name='{$_POST['cat_name']}' WHERE category_id={$_POST["cat_id"]}";
  $result1 = mysqli_query($conn, $sql1);
  if ($result1) {
    header("Location: {$hostName}/admin/category.php");
  } else {
    echo "Category Update Failed.";
  }
?>