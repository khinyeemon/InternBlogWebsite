<?php
$titleErr="";
$contentErr="";
$imageErr="";
$categoryErr="";

//get category
$stmtCategory=$connect->prepare("SELECT * FROM categories");
$stmtCategory->execute();
$categories=$stmtCategory->fetchAll(PDO::FETCH_OBJ);

$blogId=$_GET['blog_id'];
$stmt=$connect->prepare("SELECT * FROM blogs where id=$blogId");
$stmt->execute();
$blog=$stmt->fetchObject();
//update
if(isset($_POST['blogUpdateBtn'])){
 $title=$_POST['title'];
 $categoryId=$_POST['category_id'];
  $content=$_POST['content'];
  $imageName=$_FILES['image']['name'];
  $imageTemName=$_FILES['image']['tmp_name'];
   $imageType=$_FILES['image']['type'];

if($title==''){
  $titleErr="Title field is required";
}elseif($categoryId==''){
  $categoryErr="Category field is required";
}
elseif($content==''){
  $contentErr="Content field is required";

}else{
  if($imageName==''){
 $stmt=$connect->prepare("UPDATE blogs SET title='$title',category_id=$categoryId , content='$content'  where id=$blogId");
  }else{
        unlink("../assets/blog-images/$blog->image");
     if(in_array($imageType,['image/png','image/jpg','image/jpeg','image/webp'])){
 move_uploaded_file( $imageTemName,"../assets/blog-images/$imageName");
  }
  $stmt=$connect->prepare("UPDATE blogs set title='$title',category_id=$categoryId, content='$content' , image='$imageName' WHERE id=$blogId");
}
}
$result=$stmt->execute();
if($result){
  ?>
  <script>
    sweetAlert('update a blog','index.php?page=blog');
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
                        <h6 class="m-0 font-weight-bold text-primary">Blog Update Form </h6>
                          <a href="index.php?page=blog" class="btn btn-primary btn-sm "><i class="fa fa-backward p-2" aria-hidden="true"></i>Back</a>
                        </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="mb-2">
                                            <label for="">Title</label>
                                            <input type="text" class="form-control" name="title" value="<?php echo $blog->title ?>">
                                            <span class="text-danger"><?php echo $titleErr?></span>
                                        </div>
                                        <div class="mb-2">
                                            <label for=""> Select Category</label>
                                            <select name="category_id" id="" class="form-control"> 
                                              <option value="">Select Category</option>
                                              <?php foreach($categories as $category):?>
                                                <option value="<?php echo $category->id?>"
                                                 <?php 
                                                 if($blog->category_id==$category->id){
                                                  echo "selected";
                                                 }
                                                 ?>
                                                ><?php echo $category->name?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <span class="text-danger"><?php echo $categoryErr?></span>
                                        </div>
                                        <div class="mb-2">
                                            <label for="">Content</label>
                                            <textarea type="text" class="form-control" name="content" rows="10" ><?php echo $blog->content ?></textarea>
                                           <span class="text-danger"><?php echo $contentErr?></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">Image</label>
                                            <input type="file" class="form-control" name="image">
                                            <img src="../assets/blog-images/<?php echo $blog->image ?>" alt="" style="width:100px;" class="my-2">
                                             <span class="text-danger"><?php echo $imageErr?></span><br>
                                        <button class="btn btn-primary " name="blogUpdateBtn" type="submit">Update</button>
                                    </form>
                                </div>
                            </div>
        </div>

                      
                       
                     </div>
</div>
                