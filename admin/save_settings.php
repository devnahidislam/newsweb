<?php
include 'config.php';
if(empty($_FILES['new_logo']['name'])){
  $file_name = $_POST['old_logo'];
}else{
  $errors = array();
  $file_name = $_FILES['new_logo']['name'];
  $file_size = $_FILES['new_logo']['size'];
  $file_temp_name = $_FILES['new_logo']['tmp_name'];
  $file_type = $_FILES['new_logo']['type'];
  $exp = explode('.', $file_name);
  $file_ext = strtolower(end($exp));
  $extensions = ["jpg","jpeg","png"];

  if(in_array($file_ext, $extensions) === false) {
    $errors[]= "This file not allowed to be uploaded. Please upload any jpg or png files.";
  }

  if($file_size > 2097152){
    $errors[]= "File size must be 2MB or less.";
  }

  if(empty($errors) == true) {
    move_uploaded_file($file_temp_name,"images/".$file_name);
  }else{
    print_r($errors);
    die();
  }
}

$sql = "UPDATE settings SET websitename='{$_POST["website_name"]}', logo='{$file_name}', footerdesc='{$_POST["footer_desc"]}'";
$result = mysqli_query($conn, $sql);

if($result){
  header("Location: {$hostName}/admin/settings.php");
}else{
  echo "Post Update Failed.";
}
?>
