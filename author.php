<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  include 'config.php';

                  if(isset($_GET['aid'])){
                      $author_id = $_GET['aid'];
                  }
                  
                  $sql1 = "SELECT * FROM post p JOIN user u
                  ON p.author = u.user_id
                  WHERE p.author = {$author_id}";
                  $result1 = mysqli_query($conn, $sql1);
                  $row1 = mysqli_fetch_assoc($result1);
                  ?>
                  <h4 style="text-align:right";><b>UserName:</b> <?php echo $row1['username']?></h4>
                  <h2 class="page-heading"><?php echo $row1['first_name'].' '.$row1['last_name']?></h2>
                  <?php
                    $limit = 2;
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                    } else {
                        $page = 1;
                    }
                    $offset = ($page - 1) * $limit;

                    $sql = "SELECT p.post_id,p.title,p.description,p.category,p.post_date,p.author,p.post_img,c.category_name,u.username FROM post p
                        LEFT JOIN category c ON p.category = c.category_id
                        LEFT JOIN user u ON p.author = u.user_id
                        WHERE p.author = {$author_id}
                        ORDER BY p.post_id DESC LIMIT {$offset},{$limit}";

                    $result = mysqli_query($conn, $sql) or die("Query Failed.");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href='single.php?id=<?php echo $row["post_id"] ?>'><img src="admin/upload/<?php echo $row['post_img'] ?>" alt="" /></a>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="inner-content clearfix">
                                            <h3><a href='single.php?id=<?php echo $row["post_id"] ?>'><?php echo $row['title'] ?></a></h3>
                                            <div class="post-information">
                                                <span>
                                                    <i class="fa fa-tags" aria-hidden="true"></i>
                                                    <a href='category.php?cid=<?php echo $row['categori'] ?>'><?php echo $row['category_name'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-user" aria-hidden="true"></i>
                                                    <a href='author.php?aid=<?php echo $row['author'] ?>'><?php echo $row['username'] ?></a>
                                                </span>
                                                <span>
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    <?php echo $row['post_date'] ?>
                                                </span>
                                            </div>
                                            <p class="description"><?php echo substr($row['description'],0,120) . "...." ?></p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo $row["post_id"] ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        "News Not found";
                    }

                    // show pagination
                    
                    if (mysqli_num_rows($result1) > 0) {
                        $total_records = mysqli_num_rows($result1);
                        $total_page = ceil($total_records / $limit);
                        if (mysqli_num_rows($result) < 0 /*|| $_SESSION['user_role'] != 1*/) {
                            $hide = "hide-ul";
                        } else {
                            $hide = "";
                        }

                        echo '<ul class="' . $hide . ' pagination admin-pagination">';
                        if ($page > 1) {
                            echo '<li><a href="author.php?aid='.$author_id.' & page=' . ($page - 1) . '">Prev</a></li>';
                        }
                        for ($i = 1; $i <= $total_page; $i++) {
                            if ($i == $page) {
                                $active = "active";
                            } else {
                                $active = "";
                            }
                            echo '<li class ="' . $active . '"><a href ="author.php?aid='.$author_id.' & page=' . $i . '">' . $i . '</a></li>';
                        }
                        if ($total_page > $page) {
                            echo '<li><a href="author.php?aid='.$author_id.' & page=' . ($page + 1) . '">Next</a></li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
