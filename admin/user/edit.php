<?php
$nameErr="";
$emailErr="";
 $userId=$_GET['user_id'];
 $stmt=$connect->prepare("SELECT * FROM users where id=$userId");
$stmt->execute();
$user=$stmt->fetchObject();

if(isset($_POST['userUpdateBtn'])){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $role=$_POST['role'];
  if($name==''){
    $nameErr="The name field is required";

  }elseif($email==''){
    $emailErr="The email field is required";
  }else{
    if($password ==''){
      $stmt=$connect->prepare("UPDATE users SET name='$name' , email='$email'  ,  role='$role'  where id=$userId");
    }else{
      $password=md5($password);
      $stmt=$connect->prepare("UPDATE users SET name='$name' , email='$email' , password='$password' ,  role='$role'  where id=$userId");
    }
      $stmt->execute();
      ?>
<script>
sweetAlert('edit a user', 'index.php?page=user');
</script>
<?php
  }
      
    

}
?>

<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center ">
          <h6 class="m-0 font-weight-bold text-primary">User Edit Form </h6>
          <a href="index.php?page=user" class="btn btn-primary btn-sm "><i class="fa fa-backward p-2"
              aria-hidden="true"></i>Back</a>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-2">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name" value="<?php echo $user->name?>">
              <span class="text-danger"><?php echo $nameErr?></span>


            </div>
            <div class="mb-2">
              <label for="">Email</label>
              <input type="text" class="form-control" name="email" value="<?php echo $user->email?>">
              <span class="text-danger"><?php echo $emailErr?></span>


            </div>

            <div class="mb-2">
              <label for="">Password</label>
              <input type="checkbox" onclick="showPassword()" id="checkbox">
              <input type="text" class="form-control" name="password" id="password-input" style="display:none"
                placeholder="Enter new">

            </div>
            <div class="mb-2 mt-3">
              <label for="">Role</label>
              <select name="role" id="" class="form-control" value="<?php echo $user->role?>">
                <option value="admin" <?php if($user->role=='admin'):?> selected <?php endif ?>>Admin</option>
                <option value="user" <?php if($user->role=='user'):?> selected <?php endif ?>>User</option>
              </select>
              <button class="btn btn-primary mt-2" name="userUpdateBtn" type="submit">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function showPassword() {
  let checkbox = document.getElementById('checkbox');
  let passwordInput = document.getElementById('password-input');
  if (checkbox.checked) {
    passwordInput.style.display = 'block';
  } else {
    passwordInput.style.display = 'none';
  }
}
</script>