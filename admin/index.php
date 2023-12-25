<?php
ob_start();
session_start();
if(!isset($_SESSION['user'])){
    header('location:../index.php');
}else{
    if($_SESSION['user']->role !== 'admin'){
        header('location:../index.php');
    }
}
require_once('layout/header.php');
function getRowCount($table){
    global $connect;
    $stmt = $connect->prepare("SELECT COUNT(*) as count FROM $table");
    $stmt->execute();
    $stmtCount = $stmt->fetch(PDO::FETCH_ASSOC);
    return $stmtCount['count'];

}
//get table count
//get categories
$category = getRowCount('categories');
//blog statement
$blog = getRowCount('blogs');
$user = getRowCount('users');
$comment = getRowCount('comments');


?>
<!-- Page Wrapper -->
<div id="wrapper">
  <?php
require_once('layout/sidebar.php');
?>
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

      <?php
                   require_once('layout/topbar.php');
               ?>
      <?php
               //entry point
               if($_SERVER['QUERY_STRING']):
               switch($_REQUEST['page']){
                //categories
                case 'categories':
                    require_once('category/index.php');
                    break;
                    case 'categories-create':
                        require_once('category/create.php');
                        break;
                    case 'categories-edit':
                        require_once('category/edit.php');
                        break;
                        //user
                     case 'user':
                            require_once('user/index.php');
                            break;
                    case 'user-edit':
                            require_once('user/edit.php');
                            break;
                     case 'user-create':
                            require_once('user/create.php');
                            break;
              case 'user-profile':
                  require_once('user/profile.php');
                  break;
                      
                            //blogs
                     case 'blog':
                        require_once('blog/index.php');
                        break;
                    case 'blog-create':
                        require_once('blog/create.php');
                        break;
                     case 'blog-edit':
                        require_once('blog/edit.php');
                        break;
              case 'blog-comment':
                  require_once('blog/comment.php');
                  break;
               }
            else:
               ?>
      <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                      CATEGORIES</div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php echo $category;?>
                    </div>

                  </div>
                  <div class="col-auto">
                    <i class="fas fa-fw fa-table fs-2x text-gray-300"></i>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                      BLOGS</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php echo $blog;?>
                    </div>

                  </div>
                  <div class="col-auto">
                    <i class="fas fa-fw fa-folder fs-2x text-gray-300"></i>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">USERS
                    </div>
                    <div class="row no-gutters align-items-center">
                      <div class="col-auto">
                        <?php echo $user;?>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="col-auto">
                  <i class="fas fa-users text-gray-300"></i>

                </div>
              </div>
            </div>
          </div>


          <!-- Pending Requests Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      COMMENTS</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php echo $comment;?>
                    </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-comment fs-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Content Row -->

    </div>
    <?php
    endif;
     ?>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->
</div>
<?php
          require_once('layout/copyright.php');

           ?>
<!-- End of Content Wrapper -->

<!-- End of Page Wrapper -->
<?php
 require_once('layout/footer.php');
?>
</body>

</html>