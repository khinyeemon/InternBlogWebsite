<?php
$blogId= $_GET['blog_id'];
$commentStmt = $connect->prepare("SELECT comments.id, comments.text,users.name,comments.created_at FROM comments INNER JOIN users ON comments.user_id=users.id WHERE blog_id=$blogId");
$commentStmt->execute();
$comments=$commentStmt->fetchAll(PDO::FETCH_OBJ);


?>
<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center ">
          <h6 class="m-0 font-weight-bold text-primary">Comment List</h6>
          <a href="index.php?page=blog" class="btn btn-primary btn-sm "><i class="fa fa-backward p-2"
              aria-hidden="true"></i>Back</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <?php if(count($comments) >=1): ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Text</th>
                  <th>User</th>
                  <th>Created at</th>

                </tr>
              </thead>
              <tbody>
                <?php
                            foreach($comments as $comment):
                            ?>
                <tr>
                  <td><?php echo $comment->id?></td>
                  <td><?php echo $comment->text ?></td>
                  <td><?php echo $comment->name?></td>
                  <td><?php echo $comment->created_at?></td>

                </tr>
                <?php
                                        endforeach;
                                        ?>
              </tbody>
            </table>
            <?php else: ?>
            <p>No comment</p>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
  </div>