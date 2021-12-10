<?php include 'header.php';
if ($_SESSION['user_role'] != 1) {
  header("Location: {$hostName}/admin/post.php");
}
?>
<div id="admin-content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="admin-heading">Website Settings</h1>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <?php
        include 'config.php';

        $sql = "SELECT * FROM settings";

        $result = mysqli_query($conn, $sql) or die("Query Failed.");
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <!-- Form -->
            <form action="save_settings.php" method="POST" enctype="multipart/form-data" autocomplete="off">
              <div class="form-group">
                <label for="website_name">Website Name</label>
                <input type="text" name="website_name" value="<?php echo $row['websitename'] ?>" class="form-control"  autocomplete="off">
              </div>
              <div class="form-group">
                <label for="">Website Logo</label>
                <input type="file" name="new_logo"> <br>
                <img src="images/<?php echo $row['logo'] ?>" alt="">
                <input type="hidden" name="old_logo" value="<?php echo $row['logo'] ?>">
              </div>
              <div class="form-group">
                <labe for="footer_desc">Footer Description</labe>
                <textarea name="footer_desc" class="form-control" rows="5"><?php echo $row['footerdesc'] ?></textarea>
              </div>
              <input type="submit" name="submit" class="btn btn-primary" value="Update" required/>
            </form>
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php' ?>