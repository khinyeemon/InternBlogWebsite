<?php

$stmt=$connect->prepare("SELECT blogs.id,blogs.title,blogs.content,blogs.image,blogs.created_at,categories.name as category_name,users.name as user_name FROM blogs
 INNER JOIN categories ON blogs.category_id=categories.id
 INNER JOIN users ON blogs.user_id=users.id 
 ORDER BY blogs.id DESC
");
$stmt->execute();
$blogs=$stmt->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['blogDeleteBtn'])){
   $blogId=$_POST['blog_idd'];
   $selectStmt=$connect->prepare("SELECT image FROM blogs WHERE id=$blogId");
    $selectStmt->execute();
    $blog=$selectStmt->fetchObject();

   $stmt=$connect->prepare("DELETE FROM blogs where id=$blogId");
  $result=$stmt->execute();
  if($result){
    
    unlink("../assets/blog-images/$blog->image");
    ?>
<script>
sweetAlert('deleted a blog', 'index.php?page=blog');
</script>
<?php
  }
}
?>
<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center ">
          <h6 class="m-0 font-weight-bold text-primary">Blog List</h6>
          <a href="index.php?page=blog-create" class="btn btn-primary btn-sm "> <i class="fa fa-plus"
              aria-hidden="true"></i>Add New</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Content</th>
                  <th>Author</th>
                  <th>Created at</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                            foreach($blogs as $num => $blog):
                            ?>
                <tr>
                  <td><?php echo $num+1 ?></td>
                  <td>
                    <img src="../assets/blog-images/<?php echo $blog->image?> " alt="" style="width:100px;">
                  </td>
                  <td><?php echo $blog->title ?></td>
                  <td><?php echo $blog->category_name?></td>
                  <td>
                    <div style="max-width: 400px; max-height:300px; overflow:auto;"><?php echo $blog->content ?></div>
                  </td>
                  <td><?php echo $blog->user_name ?></td>
                  <td><?php echo $blog->created_at ?></td>
                  <td>
                    <form action="" method="post">
                      <input type="hidden" value="<?php echo $blog->id?>" name="blog_idd">

                      <a href="index.php?page=blog-edit&blog_id=<?php echo $blog->id ?>"
                        class="btn btn-success w-20 m-1" title="edit"><i class="far fa-edit"></i></a>

                      <button class="btn btn-danger w-20 m-1" name="blogDeleteBtn" title="delete">Delete</button>

                      <a href="index.php?page=blog-comment&blog_id=<?php echo $blog->id ?>" class="btn btn-primary m-1"
                        title="comments"><i class="fas fa-comment"></i></a>
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