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
                                <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">giỏ hàng</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding">
        <div class="container">
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Cart Table Area -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">ảnh sản phẩm</th>
                                        <th class="pro-title">tên sản phẩm</th>
                                        <th class="pro-price">giá</th>
                                        <th class="pro-quantity">số lượng</th>
                                        <th class="pro-subtotal">tổng tiền</th>
                                        <th class="pro-remove">thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $tongGioHang = 0;
                                    foreach ($chiTietGioHang as $key => $sanPham): ?>

                                        <tr>
                                            <td class="pro-thumbnail"><img class="img-fluid" src="<?= BASE_URL . $sanPham->hinh_anh ?>" alt="product" /></td>

                                            <td class="pro-title"><a href="#"><?= $sanPham->ten_san_pham ?></a></td>
                                            <?php if ($sanPham->gia_khuyen_mai) { ?>
                                                <td class="pro-price"><span><?= formatPrice($sanPham->gia_khuyen_mai) ?>.đ</span></td>
                                            <?php } else { ?>
                                                <td class="pro-price"><span><?= formatPrice($sanPham->gia_san_pham) ?>.đ</span></td>

                                            <?php } ?>


                                            <td class="pro-quantity">
                                                <div class="pro-qty"><input type="text" value="<?= $sanPham->so_luong ?>"></div>
                                            </td>
                                            <td class="pro-subtotal"><span>
                                                    <?php
                                                    $tongTien = 0;
                                                    if ($sanPham->gia_khuyen_mai) {
                                                        $tongTien = $sanPham->gia_khuyen_mai * $sanPham->so_luong;
                                                    } else {
                                                        $tongTien = $sanPham->gia_san_pham * $sanPham->so_luong;
                                                    }
                                                    $tongGioHang += $tongTien;
                                                    echo formatPrice($tongTien) . '.đ';
                                                    ?>
                                                </span></td>
                                            <td class="pro-remove"><a href="#"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Cart Update Option -->
                        <div class="cart-update-option d-block d-md-flex justify-content-between">
                            <div class="apply-coupon-wrapper">

                            </div>
                            <div class="cart-update">
                                <a href="#" class="btn btn-sqr">Update Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5 ml-auto">
                        <!-- Cart Calculation Area -->
                        <div class="cart-calculator-wrapper">
                            <div class="cart-calculate-items">
                                <h6>Tổng đơn hàng</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền sản phẩm</td>
                                            <td><?= formatPrice($tongGioHang) . 'đ' ?></td>
                                        </tr>
                                        <tr>
                                            <td>Phí vận chuyển</td>
                                            <td>30.000 đ</td>
                                        </tr>
                                        <tr class="total">
                                            <td>Tổng tiền thanh toán</td>
                                            <td class="total-amount"><?= formatPrice($tongGioHang + 30000) . 'đ' ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <a href="checkout.html" class="btn btn-sqr d-block">Tiến hành thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart main wrapper end -->
</main>
<?php require_once 'layout/miniCart.php'; ?>
<?php require_once 'layout/footer.php'; ?>
