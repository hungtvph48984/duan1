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
                    <h1>QUẢN LÝ TÀI KHOẢN KHÁCH HÀNG</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                    <div class="col-md-3">
                        <div class="text-center">
                            <img src="<?= BASE_URL . $thongTin['anh_dai_dien'];?>" style="width: 100px" class="avatar img-circle" alt="avatar" 
                            onerror="this.onerror = null; this.src='https://cdn-icons-png.flaticon.com/512/9131/9131478.png'">
                            <br>
                            <h6 class="mt-2">Họ và Tên: <?= $thongTin['ho_ten']?> </h6>
                            <h6 class="mt-2">Chức vụ:   <?= $thongTin['chuc_vu_id']?> </h6>
                        </div>
                    </div>

                    <!-- edit form column -->
                    <div class="col-md-9 personal-info">
                    <form action="<?= BASE_URL_ADMIN . '?act=sua-thong-tin-ca-nhan-quan-tri'?>" method="post">
                        <hr>
                        <h3>Thông tin cá nhân</h3>

                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Họ và Tên:</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" value="" name="">
                                </div>
                            </div>
                            
                            <!-- <div class="form-group">
                                <label class="col-lg-3 control-label">Company:</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" value="">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email:</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" value="">
                                </div>
                            </div>
        

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                        <hr>

                        <h3>Đổi mật khẩu</h3>

                        <?php if(isset($_SESSION['success'])) {?>
                         <div class="alert alert-info alert-dismissable">
                            <a class="panel-close close" data-dismiss="alert">*</a>
                            <i class="fa fa-coffee"></i>
                            <?= $_SESSION['success']?>
                         </div>
                        <?php } ?>

                        <form action="<?= BASE_URL_ADMIN . '?act=sua-mat-khau-ca-nhan-quan-tri' ?>" method="post">
                            <div class="form-group">
                              <label class="col-md-3 control-label">Mật khẩu cũ:</label>

                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="old_pass" value="">
                                    <?php if(isset($_SESSION['error']['old_pass'])) {?>
                                        <p class="text-danger"><?= $_SESSION['error']['old_pass']?></p>
                                    <?php } ?>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mật khẩu mới:</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="new_pass" value="">

                                    <?php if(isset($_SESSION['error']['new_pass'])) {?>
                                        <p class="text-danger"><?= $_SESSION['error']['new_pass']?></p>
                                    <?php } ?>
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nhập lại mật khẩu mới:</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="confirm_pass" value="">
                                    <?php if(isset($_SESSION['error']['confirm_pass'])) {?>
                                        <p class="text-danger"><?= $_SESSION['error']['confirm_pass']?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                        </form>
                    </div>
                
            </div>
        </div>
        <hr>
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