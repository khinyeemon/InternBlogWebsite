<?php
//get old categories
$categoryId= $_GET['category_id'];
$stmt=$connect->prepare("SELECT * FROM categories where id=$categoryId");
$stmt->execute();
$category=$stmt->fetchObject();

//update category
$nameErr="";
if(isset($_POST['categroyUpdateBtn'])){
    $name=$_POST['name'];
   if($name ===''){
        $nameErr="The name field is required";
    }else{
        
    $stmt=$connect->prepare("UPDATE categories SET name='$name' where id=$categoryId");
    $stmt->execute();
    ?>
<script>
sweetAlert('update a category', 'index.php?page=categories');
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
          <h6 class="m-0 font-weight-bold text-primary">Category Edit Form </h6>
          <a href="index.php?page=categories" class="btn btn-primary btn-sm ">Back</a>
        </div>
        <div class="card-body">
          <form action="" method="post">
            <div class="mb-2">
              <label for="">Name</label>
              <input type="text" class="form-control" value="<?php echo $category->name?>" name="name">
              <span class="text-danger"><?php echo  $nameErr ?></span>
              <button class="btn btn-primary mt-2" name="categroyUpdateBtn" type="">Update</button>
          </form>
        </div>
      </div>
    </div>



  </div>
</div>