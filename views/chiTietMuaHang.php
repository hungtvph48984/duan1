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
                                <li class="breadcrumb-item active" aria-current="page">đơn hàng chi tiết</li>
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
                    <div class="col-lg-7">
                        <!-- thông tin sản phẩm đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="5">thông tin sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <th>hình ảnh</th>
                                        <th>sản phẩm</th>
                                        <th>đơn giá</th>
                                        <th>số lượng</th>
                                        <th>thành tiền</th>
                                    </tr>
                                    <?php foreach ($chiTietDonHang as $item): ?>
                                        <tr >
                                            <td>
                                                <img class="img-fluid" src="<?= BASE_URL.$item['hinh_anh'] ?>" alt="Product" width="100">
                                            </td>
                                            <td style="word-wrap: break-word; white-space: normal; max-width: 200px;"><?= $item['ten_san_pham'] ?></td>
                                            <td><?= number_format( $item['don_gia'],0,',','.' )?>.đ</td>
                                            <td><?= $item['so_luong'] ?></td>
                                            <td><?=  number_format( $item['thanh_tien'],0,',','.' ) ?>.đ</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-lg-5">
                        <!-- thông tin đơn hàng -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">thông tin sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th> mã đơn hàng:</th>
                                        <td><?= $donHang['ma_don_hang'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>người nhận:</th>
                                        <td><?= $donHang['ten_nguoi_nhan'] ?></td>
                                    </tr>
                                    <tr>
                                        <th> Email:</th>
                                        <td><?= $donHang['email_nguoi_nhan'] ?></td>
                                    </tr>
                                    <tr>
                                        <th> Số điện thoại:</th>
                                        <td><?= $donHang['sdt_nguoi_nhan'] ?></td>
                                    </tr>
                                    <tr>
                                        <th> địa chỉ:</th>
                                        <td><?= $donHang['dia_chi_nguoi_nhan'] ?></td>
                                    </tr> 
                                    <tr>
                                        <th> ngày đặt:</th>
                                        <td><?= $donHang['ngay_dat'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>ghi chú:</th>
                                        <td><?= $donHang['ghi_chu'] ?></td>
                                    </tr>
                                    <tr>
                                        <th> tổng tiền:</th>
                                        <td><?=  number_format( $donHang['tong_tien'],0,',','.' ) ?>đ</td>
                                    </tr>
                                    <tr>
                                        <th> phương thức thanh toán:</th>
                                        <td><?= $phuongThucThanhToan[$donHang['phuong_thuc_thanh_toan_id']] ?></td>
                                    </tr>
                                    <tr>
                                        <th> trạng thái đơn hàng:</th>
                                        <td><?= $trangThaiDonHang[$donHang['trang_thai_id']] ?></td>
                                    </tr>
                                </tbody>
                            </table>
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