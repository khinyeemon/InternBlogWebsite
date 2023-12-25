<?php
//select categories
$sql='SELECT * FROM categories';
$stmt=$connect->prepare($sql);
$stmt->execute();
$categories=$stmt->fetchAll(PDO::FETCH_OBJ); 
//delete category
if(isset($_POST['categoryDeleteBtn'])){
    $categoryId=$_POST['category_id'];
    $stmt=$connect->prepare("DELETE FROM categories where id=$categoryId");
     $stmt->execute();
     ?>
<script>
sweetAlert('deleted a category', 'index.php?page=categories');
</script>;
<?php

}
?>
<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center ">
          <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
          <a href="index.php?page=categories-create" class="btn btn-primary btn-sm "> <i class="fa fa-plus"
              aria-hidden="true"></i>
            Add New</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($categories as $num => $category):
                 ?>
                <tr>
                  <td>
                    <?php echo $num+1 ?>
                  </td>
                  <td> <?php echo $category->name ?></td>
                  <td>
                    <form action="" method="post">
                      <input type="hidden" value="<?php echo $category->id?>" name="category_id">
                      <a href="index.php?page=categories-edit&category_id=<?php echo
                                                 $category->id?>   " class="btn btn-success w-20"><i
                          class="far fa-edit"></i></a>
                      <button class="btn btn-danger w-20" name="categoryDeleteBtn"><i class="fa fa-trash"
                          aria-hidden="true"></i></button>
                    </form>
                  </td>
                </tr>
                <?php
                                        endforeach;
                                        ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


    </div>
  </div>