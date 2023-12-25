<?php
$nameErr="";
$emailErr="";
$passwordErr="";

if(isset($_POST['userCreateBtn'])){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $password=$_POST['password'];
  $role=$_POST['role'];
  if($name==''){
    $nameErr="The name field is required";

  }elseif($email==''){
    $emailErr="The email field is required";
  }elseif($password==''){
    $passwordErr="The password field is required";
  }else{
    $password=md5($password);
    $stmt=$connect->prepare("INSERT INTO users (name,email,password,role) VALUES ('$name','$email','$password','$role')");
    $stmt->execute();
    ?>
<script>
sweetAlert('create a user', 'index.php?page=user');
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
          <h6 class="m-0 font-weight-bold text-primary">User Create Form </h6>
          <a href="index.php?page=user" class="btn btn-primary btn-sm "><i class="fa fa-backward p-2"
              aria-hidden="true"></i>Back</a>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-2">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name">
              <span class="text-danger"><?php echo $nameErr?></span>


            </div>
            <div class="mb-2">
              <label for="">Email</label>
              <input type="email" class="form-control" name="email">
              <span class="text-danger"><?php echo $emailErr?></span>

            </div>

            <div class="mb-2">
              <label for="">Password</label>
              <input type="password" class="form-control" name="password">
              <span class="text-danger"><?php echo $passwordErr?></span>
            </div>
            <div class="mb-2 mt-3">
              <label for="">Role</label>
              <select name="role" id="" class="form-control">
                <option value="admin">Admin</option>
                <option value="user">User</option>
              </select>
            </div>
            <button class="btn btn-primary" name="userCreateBtn" type="submit">Submit</button>
          </form>
        </div>
      </div>
    </div>



  </div>
</div>