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
                    <h1>SỬA DANH MỤC SẢN PHẨM</h1>
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
                            <h3 class="card-title">Sửa danh mục</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN .'?act=sua-danh-muc' ?>" method="POST">
                            <input type="text" name="id" value="<?= $danhMuc['id'] ?? '' ?>" hidden>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tên danh mục</label>
                                    <input type="text" class="form-control" name="ten_danh_muc" value="<?= $danhMuc['ten_danh_muc'] ?? '' ?>">

                                    <?php 
                                    if (isset($errors['ten_danh_muc'])) {?>
                                        <p class="text-danger"><?=$errors['ten_danh_muc']?></p>
                                   <?php }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="mo_ta" class="form-control" id="" ><?= $danhMuc['mo_ta'] ?? '' ?></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- <footer>
    <?php
    include './views/layout/footer.php';
    ?>
  </footer> -->

</body>

</html>