<?php require './views/layout/header.php'; ?>
<?php include './views/layout/navbar.php'; ?>
<?php include './views/layout/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) --> 

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    <h1>QUẢN LÝ TÀI KHOẢN QUẢN TRỊ VIÊN</h1>

                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm tài khoản quản trị viên</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN .'?act=them-quan-tri' ?>" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text" class="form-control" name="ho_ten" placeholder="nhập họ tên">
                                    <?php
                                    if (isset($_SESSION['error']['ho_ten'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ho_ten'] ?></p>
                                    <?php } ?>
                                </div>
                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="nhập email">
                                    <?php
                                    if (isset($_SESSION['error']['email'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['email'] ?></p>
                                    <?php } ?>
                                </div>         
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

    <?php
    include './views/layout/footer.php';
    ?>
  </footer>


</body>

</html>