<?php
include 'config.php';
if(isset($_FILES['fileToUpload'])){
  $errors = array();

  $file_name = $_FILES['fileToUpload']['name'];
  $file_size = $_FILES['fileToUpload']['size'];
  $file_temp_name = $_FILES['fileToUpload']['tmp_name'];
  $file_type = $_FILES['fileToUpload']['type'];
  $file_ext = strtolower(end(explode('.', $file_name)));
  $extensions = ["jpg","jpeg","png"];

  if(in_array($file_ext, $extensions) === false) {
    $errors[]= "This file not allowed to be uploaded. Please upload any jpg or png files.";
  }

  if($file_size > 2097152){
    $errors[]= "File size must be 2MB or less.";
  }

  $new_name = time().'-'.basename($file_name);
  $target = "upload/".$new_name;
  if(empty($errors) == true) {
    move_uploaded_file($file_temp_name,$target);
  }else{
    print_r($errors);
    die();
  }
}

session_start();
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['post_desc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['user_id'];

$sql = "INSERT INTO post(title, description, category, post_date, author, post_img)
        VALUE('{$title}','{$description}',{$category},'{$date}',{$author},'{$new_name}');";
$sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$category}";

if(mysqli_multi_query($conn, $sql)){
  header("Location: {$hostName}/admin/post.php");
  //header("Location: http://localhost/php/nin-news/admin/post.php");
}else{
  echo "<div>Query Failled.</div>";
}
?>