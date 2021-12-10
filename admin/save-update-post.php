<?php
include 'config.php';
if(empty($_FILES['new_image']['name'])){
  $new_name = $_POST['old_image'];
}else{
  $file_name = $_FILES['new_image']['name'];
  $file_size = $_FILES['new_image']['size'];
  $file_temp_name = $_FILES['new_image']['tmp_name'];
  $file_type = $_FILES['new_image']['type'];
  $exp = explode('.', $file_name);
  $file_ext = strtolower(end($exp));
  $extensions = ["jpg","jpeg","png"];

  if(in_array($file_ext, $extensions) === false) {
    $errors[]= "This file not allowed to be uploaded. Please upload any jpg or png files.";
  }

  if($file_size > 2097152){
    $errors[]= "File size must be 2MB or less.";
  }

  $new_name = time().'-'.basename($file_name);
  $target = "upload/".$new_name;
  $image_name = $new_name;
  if(empty($errors) == true) {
    move_uploaded_file($file_temp_name,$target);
  }else{
    print_r($errors);
    die();
  }
  
}

$sql = "UPDATE post SET title='{$_POST["post_title"]}', description='{$_POST["post_desc"]}', category={$_POST["category"]}, post_img='{$image_name}' WHERE post_id={$_POST["post_id"]};";
if($_POST['old_category'] != $_POST['category']){
  $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$_POST['old_category']};";
  $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$_POST['category']}";
}
$result = mysqli_multi_query($conn, $sql);

if($result){
  header("Location: {$hostName}/admin/post.php");
}else{
  echo "Post Update Failed.";
}

?>