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
                    <h1>SỬA SẢN PHẨM <?= $sanPham['ten_san_pham'] ?></h1>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Thông tin sản phẩm</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form action="<?= BASE_URL_ADMIN . '?act=sua-san-pham' ?>" method="POST" enctype="multipart/form-data">



                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                                <label for="ten_san_pham">Tên sản phẩm</label>
                                <input type="text" id="ten_san_pham" name="ten_san_pham" class="form-control" value="<?= $sanPham['ten_san_pham'] ?>">
                                <?php
                                if (isset($_SESSION['error']['ten_san_pham'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['ten_san_pham'] ?></p>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="gia_san_pham">Giá sản phẩm</label>
                                <input type="number" id="gia_san_pham" name="gia_san_pham" class="form-control" value="<?= $sanPham['gia_san_pham'] ?>">
                                <?php
                                if (isset($_SESSION['error']['gia_san_pham'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['gia_san_pham'] ?></p>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="gia_khuyen_mai">Giá khuyến mãi</label>
                                <input type="number" id="gia_khuyen_mai" name="gia_khuyen_mai" class="form-control" value="<?= $sanPham['gia_khuyen_mai'] ?>">
                                <?php
                                if (isset($_SESSION['error']['gia_khuyen_mai'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['gia_khuyen_mai'] ?></p>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="hinh_anh">Hình ảnh</label>
                                <input type="file" id="hinh_anh" name="hinh_anh" class="form-control">
                                <?php
                                if (isset($_SESSION['error']['hinh_anh'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['hinh_anh'] ?></p>
                                <?php } ?>
                            </div>


                            <div class="form-group">
                                <label for="so_luong">Số lượng</label>
                                <input type="number" id="so_luong" name="so_luong" class="form-control" value="<?= $sanPham['so_luong'] ?>">
                                <?php
                                if (isset($_SESSION['error']['so_luong'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['so_luong'] ?></p>
                                <?php } ?>
                            </div>

                            <div class="form-group">
                                <label for="ngay_nhap">Ngày nhập </label>
                                <input type="date" id="ngay_nhap" name="ngay_nhap" class="form-control" value="<?= $sanPham['ngay_nhap'] ?>">
                                <?php
                                if (isset($_SESSION['error']['ngay_nhap'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['ngay_nhap'] ?></p>
                                <?php } ?>
                            </div>


                            <div class="form-group">
                                <label for="danh_muc_id">Danh mục sản phẩm </label>
                                <select name="danh_muc_id" id="danh_muc_id" class="form-control custom-select">
                                    <?php foreach ($listDanhMuc as $danhMuc) : ?>
                                        <option <?= $danhMuc['id'] == $sanPham['danh_muc_id'] ? 'selected' : ''
                                                ?> value="<?= $danhMuc['id']  ?>"><?= $danhMuc['ten_danh_muc']; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php
                                if (isset($_SESSION['error']['danh_muc_id'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['danh_muc_id'] ?></p>
                                <?php } ?>
                            </div>


                            <div class="form-group">
                                <label for="trang_thai">Trạng thái sản phẩm </label>
                                <select name="trang_thai" id="trang_thai" class="form-control custom-select">
                                    <option <?= $sanPham['trang_thai'] == 1 ? 'selected' : ''  ?> value="1">Còn bán</option>
                                    <option <?= $sanPham['trang_thai'] == 2 ? 'selected' : ''  ?> value="2">Dừng bán</option>
                                </select>
                                <?php
                                if (isset($_SESSION['error']['trang_thai'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['trang_thai'] ?></p>
                                <?php } ?>
                            </div>


                            <div class="form-group">
                                <label for="mo_ta">Mô tả </label>
                                <textarea name="mo_ta" id="mo_ta" class="form-control" rows="4"><?= $sanPham['mo_ta'] ?></textarea>
                                <?php
                                if (isset($_SESSION['error']['mo_ta'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['mo_ta'] ?></p>
                                <?php } ?>
                            </div>
                            <!-- Sửa sản phẩm biến thể -->
                            <div class="form-group col-12">
                                <label for="">Biến thể sản phẩm</label>
                                <div id="variantList">
                                    <?php if (!empty($listVariant)) : ?>
                                        <?php foreach ($listVariant as $index => $variant) : ?>
                                            <div class="row mb-2 variant-row" id="variant-<?= $index ?>">
                                                <input type="hidden" name="variant_ids[]" value="<?= $variant['id'] ?>"> <!-- Lưu ID biến thể -->
                                                <div class="col-3">
                                                    <select class="form-control" name="sizes[]" required>
                                                        <option value="" disabled>Chọn size</option>
                                                        
                                                        <option value="S" <?= $variant['size'] == 'S' ? 'selected' : '' ?>>S</option>
                                                        <option value="M" <?= $variant['size'] == 'M' ? 'selected' : '' ?>>M</option>
                                                        <option value="L" <?= $variant['size'] == 'L' ? 'selected' : '' ?>>L</option>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <select class="form-control" name="colors[]" required>
                                                        <option value="" disabled>Chọn màu</option>
                                                        <option value="Đỏ"  <?= $variant['color'] ==   'Đỏ'   ? 'selected' : '' ?>>Đỏ</option>
                                                        <option value="Xanh" <?= $variant['color'] ==  'Xanh' ? 'selected' : '' ?>>Xanh</option>
                                                        <option value="Vàng" <?= $variant['color'] == 'Vàng' ? 'selected' : '' ?>>Vàng</option>
                                                    </select>
                                                </div>

                                                <div class="col-3">
                                                    <input type="number" class="form-control" name="so_luong_variants[]" value="<?= $variant['so_luong'] ?>" required>
                                                </div>

                                                <div class="col-3">
                                                    <button type="button" class="btn btn-danger" onclick="removeVariant('variant-<?= $index ?>', <?= $variant['id'] ?>)">Xoá</button>
                                                </div>

                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                            </div>
                                </div>
                                <button type="button" class="btn btn-info mt-2" onclick="addVariant()">Thêm biến thể</button>
                                <?php if (isset($_SESSION['error']['variants'])) { ?>
                                    <p class="text-danger"><?= $_SESSION['error']['variants'] ?></p>
                                <?php } ?>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                            </div>
                        </div>
                    </form>
                </div>

    </section>
</div>
<input type="hidden" name="delete_variants" id="deleteVariants"> //Lưu danh sách ID biến thể bị xoá
<?php
include './views/layout/footer.php';
?>
<script>
    let variantCount = <?= count($listVariant) ?>;

    function addVariant() {
        variantCount++;
        constVariantList = document.getElementById('variantList');
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
                <button type="button" class="btn btn-danger" onclick="removeVariant('variant-${variantCount}', null)">Xoá</button>
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

</body>

</html>