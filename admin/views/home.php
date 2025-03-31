<?php
// session_start();    
 require './views/layout/header.php'; 
 include './views/layout/navbar.php'; 
 include './views/layout/sidebar.php'; 
 
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>BÁO CÁO THỐNG KÊ</h1>
                    <?php var_dump($_SESSION['user_admin']) ?>
                </div>

            </div>
        </div>
    </section>

</div>
<!-- /.content-wrapper -->
<!-- <footer>
    <?php
    include './views/layout/footer.php';
    ?>
  </footer> -->
<!-- Page specific script -->

<!-- Code injected by live-server -->
</body>

</html>