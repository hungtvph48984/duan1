<?php
require_once 'layout/header.php';
?>
<?php
require_once 'layout/menu.php';
?>
<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <!-- product details wrapper start -->
                <div class="col-lg-12 order-1 order-lg-2">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">

                                    <div class="pro-large-img ">
                                        <img src="<?= BASE_URL . $sanPham['hinh_anh'] ?>" alt="product-details" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="#"><?= $sanPham['ten_danh_muc'] ?></a>
                                    </div>
                                    <h3 class="product-name"><?= $sanPham['ten_san_pham'] ?></h3>
                                    <div class="ratings d-flex">

                                        <div class="pro-review">
                                            <?php $countComment = count($listBinhLuan); ?>
                                            <span><?= $countComment . ' Bình luận' ?></span>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <?php if ($sanPham['gia_khuyen_mai']) { ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']) . 'đ'; ?></span>
                                            <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></del></span>
                                        <?php
                                        } else { ?>
                                            <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></span>
                                        <?php } ?>
                                    </div>

                                    <div class="availability">
                                        <i class="fa fa-check-circle"></i>
                                        <span><?= 'Số lượng:' . $sanPham['so_luong']   ?></span>
                                    </div>
                                    <p class="pro-desc"><?= 'Mô tả :'  . $sanPham['mo_ta'] ?></p>
                                    <form action="<?= BASE_URL.'?act=them-gio-hang' ?>" method="post">
                                        <div class="quantity-cart-box d-flex align-items-center">
                                            <h6 class="option-title">Số lượng:</h6>
                                            <div class="quantity">
                                                <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'];?>">
                                                <div class="pro-qty"><input type="text" value="1" name="so_luong"></div>
                                            </div>
                                            <div class="action_link">
                                               <button class="btn btn-cart2">Thêm giỏ hàng</button> 
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->
                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab">
                                        <li>
                                            <a class="active" data-bs-toggle="tab" href="#tab_three">Bình luận (<?= $countComment ?>) </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">
                                        <div class="tab-pane fade show active" id="tab_one">
                                        <div class="tab-pane fade show active" id="tab_three">

<?php foreach ($listBinhLuan as $binhLuan): ?>
    <div class="total-reviews">
        <div class="rev-avatar">
            <img src="<?= $binhLuan['anh_dai_dien'] ?>" alt="avatar" />
        </div>
        <div class="review-box">
            <div class="post-author">
                <p><strong><?= $binhLuan['ho_ten'] ?? 'Khách hàng' ?></strong> - <?= $binhLuan['ngay_dang'] ?></p>
            </div>
            <p><?= $binhLuan['noi_dung'] ?></p>
        </div>
    </div>
<?php endforeach; ?>

<div class="review-form mt-4">
    <?php if (isset($_SESSION['tai_khoan'])): ?>
        <form action="?act=them-binh-luan" method="POST" class="review-form">
            <div class="form-group row">
                <div class="col">
                    <label class="col-form-label"><span class="text-danger">*</span>
                        Nội dung bình luận</label>
                    <textarea class="form-control" name="noi_dung" required></textarea>
                    <input type="hidden" name="san_pham_id" value="<?= $sanPham['id'] ?>">
                </div>
            </div>
            <div class="buttons mt-2">
                <button class="btn btn-sqr" type="submit">Bình Luận</button>
            </div>
        </form>
    <?php else: ?>
        <p>Bạn cần <a href="?act=login">đăng nhập</a> để bình luận.</p>
    <?php endif; ?>
</div>
</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product details reviews end -->
                    </div>
                    <!-- product details wrapper end -->
                </div>
            </div>
        </div>
        
        <!-- page main wrapper end -->

        <!-- related products area start -->
        <section class="related-products section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- section title start -->
                        <div class="section-title text-center">
                            <h2 class="title">Sản phẩm liên quan</h2>
                        </div>
                        <!-- section title start -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-carousel-4 slick-row-10 slick-arrow-style">
                            <!-- product item start -->
                            <?php foreach ($listSanPhamDanhMuc as $key => $sanPham): ?>
                                <!-- product item start -->
                                <div class="product-item">
                                    <figure class="product-thumb">
                                        <a href="<?= '?act=san-pham-tri-tiet&id_san_pham=' . $sanPham['id']; ?>">
                                            <img class="pri-img" src="<?php echo $sanPham['hinh_anh']; ?>" alt="product">
                                            <img class="sec-img" src="<?php echo $sanPham['hinh_anh']; ?>" alt="product">


                                        </a>
                                        <div class="product-badge">

                                            <?php
                                            //giới hạn sản phẩm mớimới
                                            $ngayNhap = new DateTime($sanPham['ngay_nhap']);
                                            $ngayHienTai = new DateTime();
                                            $tinhNgay = $ngayHienTai->diff($ngayNhap);
                                            if ($tinhNgay->days <= 7) { ?>
                                                <div class="product-label new">
                                                    <span>mới</span>
                                                </div>
                                            <?php
                                            } ?>
                                            <?php
                                            if ($sanPham['gia_khuyen_mai']) { ?>
                                                <div class="product-label discount">
                                                    <span>giảm giá</span>
                                                </div>
                                            <?php } ?>

                                        </div>

                                        <div class="cart-hover">
                                            <button class="btn btn-cart">Xem tri tiết</button>
                                        </div>
                                    </figure>
                                    <div class="product-caption text-center">

                                        <h6 class="product-name">
                                            <a href="<?= '?act=san-pham-tri-tiet&id_san_pham=' . $sanPham['id']; ?>">
                                                <?= $sanPham['ten_san_pham'] ?>
                                            </a>
                                        </h6>
                                        <div class="price-box">
                                            <?php if ($sanPham['gia_khuyen_mai']) { ?>
                                                <span class="price-regular"><?= formatPrice($sanPham['gia_khuyen_mai']) . 'đ'; ?></span>
                                                <span class="price-old"><del><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></del></span>
                                            <?php
                                            } else { ?>
                                                <span class="price-regular"><?= formatPrice($sanPham['gia_san_pham']) . 'đ'; ?></span>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- related products area end -->
</main>
<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>