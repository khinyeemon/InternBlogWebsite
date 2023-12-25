<?php
//get category
$stmtCategory=$connect->prepare("SELECT * FROM categories");
$stmtCategory->execute();
$categories=$stmtCategory->fetchAll(PDO::FETCH_OBJ);


$titleErr="";
$contentErr="";
$imageErr="";
$categoryErr="";
if(isset($_POST['blogCreateBtn'])){
  $title=$_POST['title'];
  $content=$_POST['content'];
  $categoryId=$_POST['category_id'];
  $userId=$_SESSION['user']->id;

  $created_at=date('Y-m-d H:i:s');
  $imageName=$_FILES['image']['name'];
   $imageTemName=$_FILES['image']['tmp_name'];
   $imageType=$_FILES['image']['type'];

if($title==""){
  $titleErr="Title field is required";
}elseif($categoryId==""){
  $categoryErr="Category field is required";
}elseif($content==""){
  $contentErr="Content field is required";

}elseif($imageName==""){
  $imageErr="Image field is required";
}else{
  $imageName=uniqid().'-'.$imageName;
  if(in_array($imageType,['image/png','image/jpg','image/jpeg','image/webp'])){
 move_uploaded_file( $imageTemName,"../assets/blog-images/$imageName");
}
$stmt=$connect->prepare("INSERT INTO blogs(title,category_id,content,image,user_id,created_at) VALUES ('$title',$categoryId,'$content','$imageName',$userId,'$created_at')");
$stmt->execute();

?>

<script>
sweetAlert('created a blog', 'index.php?page=blog');
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
          <h6 class="m-0 font-weight-bold text-primary">Blog Create Form </h6>
          <a href="index.php?page=blog" class="btn btn-primary btn-sm "><i class="fa fa-backward p-2"
              aria-hidden="true"></i>Back</a>
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-2">
              <label for="">Title</label>
              <input type="text" class="form-control" name="title">
              <span class="text-danger"><?php echo $titleErr?></span>

            </div>
            <div class="mb-2">
              <label for="">Category</label>
              <select name="category_id" id="" class="form-control">
                <option value="">Select Category</option>

                <?php foreach($categories as $category):?>
                <option value="<?php echo $category->id?>"><?php echo $category->name?></option>
                <?php endforeach;?>
              </select>
              <span class="text-danger"><?php echo $categoryErr?></span>

            </div>
            <div class="mb-2">
              <label for="">Content</label>
              <textarea type="text" class="form-control" name="content" rows="10"></textarea>
              <span class="text-danger"><?php echo $contentErr?></span>

            </div>

            <div class="mb-3">
              <label for="">Image</label>
              <input type="file" class="form-control" name="image">
              <span class="text-danger"><?php echo $imageErr?></span>
              <button class="btn btn-primary mt-3" name="blogCreateBtn" type="submit">Submit</button>
          </form>
        </div>
      </div>
    </div>



  </div>
</div>