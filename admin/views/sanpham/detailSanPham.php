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
                    <h1>CHI TIẾT SẢN PHẨM</h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none"></h3>
                        <div class="col-12">
                            <img style="width:400px; height:400px" src="<?= '.' . $sanPham['hinh_anh'] ?> " class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <?php foreach ($listAnhSanPham as $key => $anhSP) : ?>
                                <div class="product-image-thumb <?= $anhSP[$key] == 0 ? 'active' : '' ?>  "><img src="<?= '.' . $anhSP['hinh_anh'] ?>" alt="Product Image"></div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">Tên sản phẩm: <?= $sanPham['ten_san_pham'] ?></h3>
                        <hr>
                        <h4 class="mt-3">Giá tiền: <small><?= $sanPham['gia_san_pham'] ?></small></h4>
                        <h4 class="mt-3">Giá khuyến mãi: <small><?= $sanPham['gia_khuyen_mai'] ?></small></h4>
                        <h4 class="mt-3">Số lượng: <small><?= $sanPham['so_luong'] ?></small></h4>
                        <h4 class="mt-3">Lượt xem: <small><?= $sanPham['luot_xem'] ?></small></h4>
                        <h4 class="mt-3">Ngày nhập: <small><?= $sanPham['ngay_nhap'] ?></small></h4>
                        <h4 class="mt-3">Danh mục: <small><?= $sanPham['ten_danh_muc'] ?></small></h4>
                        <h4 class="mt-3">Trạng thái: <small><?= $sanPham['trang_thai'] == 1 ? 'Còn hàng' : 'Dừng bán' ?></small></h4>
                        <h4 class="mt-3">Mô tả: <small><?= $sanPham['mo_ta'] ?></small></h4>

                        <!-- Hiển thị biến thể -->
                        <h4 class="mt-3">Biến thể:</h4>
                        <?php if (!empty($sanPham['variants'])) : ?>
                            <ul>
                                <?php foreach ($sanPham['variants'] as $variant) : ?>
                                    <li>Size: <?= $variant['size'] ?>, Màu: <?= $variant['color'] ?>, Số lượng: <?= $variant['so_luong'] ?> </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p>Sản phẩm không có biến thể</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#binh-luan" role="tab" aria-controls="product-desc" aria-selected="true">Bình luận sản phẩm</a>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="binh-luan" role="tabpanel" aria-labelledby="product-desc-tab">
                            <div class="container-fulid">
                               
                            </div>

                        </div>
                    </div>
                </div> -->
                <ul class="nav nav-tabs row mt-4 " id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Bình luận sản phẩm</button>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên người bình luận</th>
                                    <th>Nội dung</th>
                                    <th>Ngày đăng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Đàm Xuân Biên Linh</td>
                                    <td>Sản phẩm chất lượng</td>
                                    <td>26/3/2025</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#"><button class="btn btn-warning">Ẩn</button></a>
                                            <a href="#"><button class="btn btn-danger">Xoá</button></a>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Trần Văn Hùng</td>
                                    <td>Sản phẩm chưa tốt lắm</td>
                                    <td>25/3/2025</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#"><button class="btn btn-warning">Ẩn</button></a>
                                            <a href="#"><button class="btn btn-danger">Xoá</button></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- <footer>
    <?php
    include './views/layout/footer.php';
    ?>
  </footer> -->
<!-- Page specific script -->
<script>
    $(document).ready(function() {
        $('.product-image-thumb').on('click', function() {
            var $image_element = $(this).find('img')
            $('.product-image').prop('src', $image_element.attr('src'))
            $('.product-image-thumb.active').removeClass('active')
            $(this).addClass('active')
        })
    })
</script>
<!-- Code injected by live-server -->
</body>

</html>