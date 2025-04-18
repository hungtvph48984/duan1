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
                    <h1>THÊM SẢN PHẨM</h1>
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
                            <h3 class="card-title">Thêm sản phẩm</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?= BASE_URL_ADMIN . '?act=them-san-pham' ?>" method="POST" enctype="multipart/form-data">
                            <div class="row card-body ">
                                <div class="form-group col-12">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" class="form-control" name="ten_san_pham" placeholder="nhập tên sản phẩm">
                                    <?php
                                    if (isset($_SESSION['error']['ten_san_pham'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ten_san_pham'] ?></p>
                                    <?php } ?>
                                </div>


                                <div class="form-group col-6">
                                    <label>Giá sản phẩm </label>
                                    <input type="number" class="form-control" name="gia_san_pham" placeholder="nhập giá sản phẩm">
                                    <?php
                                    if (isset($_SESSION['error']['gia_san_pham'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['gia_san_pham'] ?></p>
                                    <?php } ?>

                                </div>


                                <div class="form-group col-6">
                                    <label>Giá khuyến mãi</label>
                                    <input type="number" class="form-control" name="gia_khuyen_mai" placeholder="nhập giá khuyến mãi">
                                    <?php
                                    if (isset($_SESSION['error']['gia_khuyen_mai'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['gia_khuyen_mai'] ?></p>
                                    <?php } ?>
                                </div>


                                <div class="form-group col-6">
                                    <label>Hình ảnh</label>
                                    <input type="file" class="form-control" name="hinh_anh">
                                    <?php
                                    if (isset($_SESSION['error']['hinh_anh'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['hinh_anh'] ?></p>
                                    <?php } ?>
                                </div>


                                <div class="form-group col-6">
                                    <label>Album ảnh </label>
                                    <input type="file" class="form-control" name="img_array[]">
                                    <?php
                                    if (isset($_SESSION['error']['hinh_anh'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['hinh_anh'] ?></p>
                                    <?php } ?>
                                </div>


                                <div class="form-group col-6">
                                    <label>Số lượng</label>
                                    <input type="number" class="form-control" name="so_luong" placeholder="nhập số lượng sản phẩm">
                                    <?php
                                    if (isset($_SESSION['error']['so_luong'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['so_luong'] ?></p>
                                    <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label>Ngày nhập</label>
                                    <input type="date" class="form-control" name="ngay_nhap">
                                    <?php
                                    if (isset($_SESSION['error']['ngay_nhap'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['ngay_nhap'] ?></p>
                                    <?php } ?>
                                </div>


                                <div class="form-group col-6">
                                    <label>Danh mục</label>
                                    <select class="form-control" name="danh_muc_id">
                                        <option selected disabled>Chọn danh mục sản phẩm</option>
                                        <?php foreach ($listDanhMuc as $danhMuc) : ?>
                                            <option value="<?= $danhMuc['id'] ?> "><?= $danhMuc['ten_danh_muc'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <?php if (isset($_SESSION['error']['danh_muc_id'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['danh_muc_id'] ?></p>
                                    <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="trang_thai">
                                        <option selected disabled>Chọn danh mục sản phẩm</option>
                                        <option value="1">Còn hàng</option>
                                        <option value="2">Dừng bán</option>
                                    </select>
                                    <?php if (isset($_SESSION['error']['trang_thai'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['trang_thai'] ?></p>
                                    <?php } ?>
                                </div>





                                <div class="form-group col-12">
                                    <label>Mô tả</label>
                                    <textarea name="mo_ta" rows="3" class="form-control" id="" placeholder="nhập mô tả"></textarea>
                                </div>

                                <!--  Biến thể sản phẩm -->

                                <div class="form-group col-12">
                                    <label>Biến thể sản phẩm</label>
                                    <div id="variantList"></div>
                                    <button type="button" class="btn btn-info mt-2" onclick="addVariant()">Thêm biến thể</button>
                                    <?php if (isset($_SESSION['error']['variants'])) { ?>
                                        <p class="text-danger"><?= $_SESSION['error']['variants'] ?></p>
                                    <?php } ?>
                                </div>


                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
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
<script>
    let variantCount = 0;

    function addVariant() {
        variantCount++;
        const variantList = document.getElementById('variantList');
        const newVariant = document.createElement('div');
        newVariant.className = 'row mb-2 variant-row';
        newVariant.id = 'variant-' + variantCount;
        newVariant.innerHTML = `
        <div class="col-3">
    <select class="form-control" name="sizes[]" required>
        <option value="" disabled selected>Chọn size</option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
    </select>
</div>

<div class="col-3">
    <select class="form-control" name="colors[]" required>
        <option value="" disabled selected>Chọn màu</option>
        <option value="Đỏ">Đỏ</option>
        <option value="Xanh">Xanh</option>
        <option value="Vàng">Vàng</option>
    </select>
</div>

<div class="col-3">
    <input type="number" class="form-control" name="so_luong_variants[]" placeholder="Số lượng" required>
</div>

<div class="col-3">
    <button type="button" class="btn btn-danger" onclick="removeVariant('variant-${variantCount}')">Xoá</button>
</div>
        `;
        variantList.appendChild(newVariant);
    }

    function removeVariant(variantId) {
        const variantRow = document.getElementById(variantId);
        if (variantRow) {
            variantRow.remove(); // Xoá hàng khỏi biến thể DOM
        }
    }
</script>



