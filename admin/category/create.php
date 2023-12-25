<?php
$nameerr = "";
if(isset($_POST['categroyCreateBtn'])){
    $name=$_POST['name'];
    if($name === ''){
        $nameerr = "The name field is required";
        
    }else{
        
    $stmt=$connect->prepare("INSERT INTO categories (name) VALUES ('$name')");
    $stmt->execute();
 ?>
<script>
sweetAlert('created a category', 'index.php?page=categories');
</script>;
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
          <h6 class="m-0 font-weight-bold text-primary">Category Create Form </h6>
          <a href="index.php?page=categories" class="btn btn-primary btn-sm "><i class="fa fa-backward"
              aria-hidden="true"></i>
            Back</a>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-2">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name">
              <span class="text-danger"><?php echo $nameerr ?></span>
            </div>
            <button class="btn btn-primary" name="categroyCreateBtn" type="submit">Submit</button>
          </form>
        </div>
      </div>
    </div>



  </div>
</div>