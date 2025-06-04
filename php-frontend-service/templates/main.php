<?php

if (!isset($_SESSION['user'])) {
    header('Location: ../pages/login.php');
    exit;
}

$name = $_SESSION['user']['Name'];
$username = $_SESSION['user']['Username'];
    

 ?>
<?php include_once 'header.php'; ?>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 bg-light p-3">
      <?php include_once 'sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-3">
      <?php include_once $view; ?>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>
