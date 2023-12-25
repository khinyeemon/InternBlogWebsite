<?php

require_once('layout/header.php');
require_once('layout/navbar.php');
$blogId=$_GET['blog_id'];
// echo "sweetAlert('delete a comment','blog-detail.php?blog_id=$blogId')";
$stmt=$connect->prepare("SELECT blogs.title, blogs.content, blogs.image, blogs.created_at, users.name FROM  blogs INNER JOIN users  ON blogs.user_id=users.id ORDER BY blogs.id= $blogId DESC");
$stmt->execute();
$blog=$stmt->fetchObject();

//create comment
if(isset($_POST['createCommentBtn'])){
    $text = $_POST['text'];
    $userId = $_SESSION['user']->id;
    $date = date('Y-m-d H:i:s');
   $stmt = $connect->prepare("INSERT INTO comments(text,blog_id,user_id,created_at) VALUES ('$text',$blogId,$userId,'$date')");
    $result=  $stmt->execute();
    if ($result) {
        echo "<script>sweetAlert('created a comment','blog-detail.php?blog_id=$blogId')</script>";
    }
    
}
$commentStmt = $connect->prepare("SELECT comments.id, comments.text,users.name,comments.created_at FROM comments INNER JOIN users ON comments.user_id=users.id WHERE blog_id=$blogId");
$commentStmt->execute();
$comments=$commentStmt->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST["commentDeleteBtn"])){
 $commentId=$_POST['comment_idd'];
  // $blogId = $_GET['blog_id'];
  $cstmt = $connect->prepare("DELETE FROM comments WHERE id=$commentId ");
  $cstmt->execute();
 echo "<script>sweetAlert('delete a comment','blog-detail.php?blog_id=$blogId')</script>";

// Redirect back
    
}
//Sign Up
if (isset($_POST['signUpBtn'])) {
    $name = $_POST['signUpName'];
    $email = $_POST['signUpEmail'];
    $password = $_POST['signUpPassword'];

    // Check if name, email, and password are not empty
    if ($name != '' && $email != '' && $password != '') {

        // Check if the user already exists
        $stmt = $connect->prepare("SELECT * FROM users WHERE name = :name OR email = :email");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
            ?>
<script>
Swal.fire({
  title: 'Sorry!',
  text: 'Already exists',
  icon: 'error',
  confirmButtonText: 'OK'
}).then(function() {
  location.href = 'index.php';
})
</script>
<?php
        } else {
            // Insert the new user
            $password = md5($password);
            $stmt = $connect->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            echo "<script>sweetAlert('Sign up','index.php');</script>";
        }

    } else {
        // Handle empty fields
        echo "<script>alert('Please fill in all fields');</script>";
    }
}

//sign In 
 if (isset($_POST['signBtn'])) {
   $email = $_POST['email'];
   $password = md5($_POST['password']);
   $stmt = $connect->prepare("SELECT * FROM users WHERE email ='$email' AND password ='$password'");
   $stmt->execute();
   $user = $stmt->fetchObject();
   if ($user) {
     $_SESSION['user'] = $user;
     if ($user->role === 'admin') {
       echo "<script>sweetAlert('signed in','admin/index.php')</script>";
     } else {
      echo "<script>sweetAlert('created a comment','blog-detail.php?blog_id=$blogId')</script>";

     }
   } else {

     ?>
<script>
Swal.fire({
  title: 'Sorry!',
  text: 'Sign In fail',
  icon: 'error',
  confirmButtonText: 'ok'
}).then(function() {
  location.href = index.php;

})
</script>
<?php
   }
 }
 
 ?>

?>

<div id="blog">
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-7">
        <h3 data-aos="fade-right" data-aos-duration="1000">Blog Detail</h3>
        <div class="heading-line" data-aos="fade-left" data-aos-duration="1000"></div>
        <div class="card my-3" data-aos="zoom-in" data-aos-duration="1000">
          <div class="card-body p-0">
            <div class="img-wrapper">
              <img src="assets/blog-images/<?php echo $blog->image ?>" class="img-fluid" alt="">
            </div>
            <div class="content p-3">
              <h5 class="fw-semibold"> <?php echo $blog->title ?></h5>
              <div class="mb-3"><?php echo $blog->created_at ?> | by <?php echo  $blog->name ?></div>
              <p>
                <?php echo $blog->content?>
              </p>
            </div>
          </div>
        </div>

        <div class="comment">
          <?php if(isset($_SESSION['user'])): ?>
          <h5 data-aos="fade-right" data-aos-duration="1000">Leave a Comment</h5>
          <form method="post" data-aos="fade-left" data-aos-duration="1000">
            <div class="mb-2">
              <textarea name="text" rows="5" class="form-control" required></textarea>
            </div>
            <button class="btn" type="submit" name="createCommentBtn">Submit</button>
          </form>
          <?php else: ?>
          <a class="btn btn-primary" href="#signIn" data-bs-toggle="offcanvas" aria-controls="staticBackdrop">Sign In to
            comments</a>
          <?php endif; ?>
          <h6 class="fw-bold mt-3">User's comments</h6>
          <?php foreach($comments as $comment):  ?>
          <div class="card card-body my-3" data-aos="fade-right" data-aos-duration="1000">
            <h6><?php echo $comment->name ?></h6>
            <?php echo $comment->text ?>
            <div class="mt-3">
              <span class="float-end"><?php echo $comment->created_at ?></span><br>
              <form method="post">
                <input type="hidden" value="<?php echo $comment->id?>" name="comment_idd">
                <button class="btn float-end w-20 m-1" name="commentDeleteBtn" title="delete">Delete</button>

              </form>
            </div>
          </div>
          <?php endforeach;?>
        </div>
      </div>
      <?php
            require_once('layout/right-side.php');
            
               ?>
    </div>
  </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" id="footer-wave">
  <path fill="#6366f1" fill-opacity="1"
    d="M0,32L48,37.3C96,43,192,53,288,90.7C384,128,480,192,576,192C672,192,768,128,864,117.3C960,107,1056,149,1152,149.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
  </path>
</svg>
<footer id="footer" class="d-flex justify-content-center align-items-center">
  <div class="container">
    <div>&copy; 2023 Hornbill Technology, Inc. All rights reserved.</div>
  </div>
</footer>

<!-- sign in  -->
<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="signIn"
  aria-labelledby="signInLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="signInLabel">Sign In</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="">
      <form action="" method="post">
        <div class="mb-2">
          <input type="text" class="form-control" placeholder="email" name="email" required>
        </div>
        <div class="mb-2">
          <input type="password" class="form-control" placeholder="password" name="password" required>
        </div>
        <button class="btn" name="signBtn">Sign In</button>
      </form>
      <a href="#signUp" data-bs-toggle="offcanvas" aria-controls="staticBackdrop" class="d-block my-2">You have no
        account yet?Sign Up here</a>
    </div>
  </div>
</div>
<!-- sign up  -->
<div class="offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="signUp"
  aria-labelledby="signUpLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="signUpLabel">Sign Up</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="">
      <form action="" method="post">
        <div class="mb-2">
          <input type="text" class="form-control" placeholder="name" name="signUpName" required>
        </div>
        <div class="mb-2">
          <input type="text" class="form-control" placeholder="email" name="signUpEmail" required>
        </div>
        <div class="mb-2">
          <input type="password" class="form-control" placeholder="password" name="signUpPassword" required>
        </div>
        <button class="btn" name="signUpBtn">Sign Up</button>
      </form>
    </div>
  </div>
</div>


<!-- bootstrap cdn  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<!-- aos  -->
<script src="assets/aos/aos.js"></script>
<script>
AOS.init();
</script>
</body>

</html>