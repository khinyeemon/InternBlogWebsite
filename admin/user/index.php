<?php

$stmt=$connect->prepare("SELECT * FROM users");
$stmt->execute();
$users=$stmt->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST['userDeleteBtn']))
{
  $userId=$_POST['user_idd'];
  $stmt=$connect->prepare("DELETE FROM users where id=$userId");
  $stmt->execute();
?>
<script>
sweetAlert('delete a user', 'index.php?page=user');
</script>
<?php
    
}
?>
<div class="container-fluid">
  <!-- Content Row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card shadow mb-4 ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center ">
          <h6 class="m-0 font-weight-bold text-primary">User List</h6>
          <a href="index.php?page=user-create" class="btn btn-primary btn-sm "> <i class="fa fa-plus"
              aria-hidden="true"></i>Add New</a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                                        foreach($users as $num => $user):
                                        ?>
                <tr>
                  <td><?php echo $num+1 ?></td>
                  <td> <?php echo $user->name ?></td>
                  <td><?php echo $user->role ?></td>
                  <td>
                    <form action="" method="post">
                      <input type="hidden" value="<?php echo $user->id?>" name="user_idd">
                      <a href="index.php?page=user-edit&user_id=<?php echo $user->id?>" class="btn btn-success w-20"><i
                          class="far fa-edit"></i></a>
                      <button class="btn btn-danger w-20" name="userDeleteBtn">Delete</button>
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