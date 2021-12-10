<?php include "header.php";
if($_SESSION['user_role'] != 1 ){
    header("Location: {$hostName}/admin/post.php");
}

if (isset($_POST['submit'])) {
    include "config.php";
    $userId = mysqli_real_escape_string($conn, $_POST['user_id']);
    $fName = mysqli_real_escape_string($conn, $_POST['f_name']);
    $lName = mysqli_real_escape_string($conn, $_POST['l_name']);
    $userName = mysqli_real_escape_string($conn, $_POST['user_name']);
    //$password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    
    //$result = mysqli_query($conn, $sql) or die("Query Failed.");
    // if(mysqli_query($conn, $sql)){
    //     header("Location: {$hostName}/admin/users.php");
    // }

    $sql = "SELECT username FROM user WHERE username = '{$userName}'";
    $result = mysqli_query($conn, $sql) or die("Query Failed.");

    if (mysqli_num_rows($result) > 0) {
        echo "<h3 style='color:red;text-align:center;margin:10px 0'>UserName Already Used.</h3>";
    } else {
        $sql1 = "UPDATE user SET first_name = '{$fName}', last_name = '{$lName}', username = '{$userName}', role = '{$role}' WHERE user_id = '{$userId}'";
        if (mysqli_query($conn, $sql1)) {
            header("Location: {$hostName}/admin/users.php");
        }
    }
    
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">
                <?php
                include 'config.php';
                $user_id = $_GET['id'];
                $sql = "SELECT * FROM user WHERE user_id = {$user_id}";
                $result = mysqli_query($conn, $sql) or die("Query Failed.");
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <!-- Form Start -->
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id'] ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>First Nmae</label>
                                <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="user_name" class="form-control" value="<?php echo $row['username'] ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                                <?php
                                if($row['role'] == 1){
                                    echo '<option value="0">normal User</option>
                                    <option value="1" selected>Admin</option>
                                    <option value="2">Author</option>';
                                        }else if($row['role'] == 2){
                                            echo '<option value="0">User</option>
                                            <option value="1">Admin</option>
                                            <option value="2" selected>Author</option>';
                                        }else{
                                            echo '<option value="0" selected>User</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Author</option>';
                                        }
                                ?>
                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                        <!-- /Form -->
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>