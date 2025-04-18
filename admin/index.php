<?php 
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminSanPhamController.php';
require_once './controllers/AdminDonHangController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/AdminTaiKhoanController.php';

// Require toàn bộ file Models
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanPham.php';
require_once './models/AdminDonHang.php';
require_once './models/AdminTaiKhoan.php';

// Route
$act = $_GET['act'] ?? '/';
if ($act !== 'login-admin' && $act !== 'check-login-admin' && $act !== 'logout-admin'){
    checkLoginAdmin();
}
// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match
match ($act) {
    // route báo cáo thống kê - trang chủ
    '/' => (new AdminBaoCaoThongKeController())->home(),
    'danh-muc' => (new AdminDanhMucController())->danhSachDanhMuc(),
    'form-them-danh-muc' => (new AdminDanhMucController())->formAddDanhMuc(),
    'them-danh-muc' => (new AdminDanhMucController())->postAddDanhMuc(),
    'form-sua-danh-muc' => (new AdminDanhMucController())->formEditDanhMuc(),
    'sua-danh-muc' => (new AdminDanhMucController())->postEditDanhMuc(),
    'xoa-danh-muc' => (new AdminDanhMucController())->deleteDanhMuc(),

       // route sản phẩm
    'san-pham' => (new AdminSanPhamController())->danhSachSanPham(),
    'form-them-san-pham' => (new AdminSanPhamController())->formAddSanPham(),
    'them-san-pham' => (new AdminSanPhamController())->postAddSanPham(),
    'form-sua-san-pham' => (new AdminSanPhamController())->formEditSanPham(),
    'sua-san-pham' => (new AdminSanPhamController())->postEditSanPham(),
    'xoa-san-pham' => (new AdminSanPhamController())->deleteSanPham(),
    'chi-tiet-san-pham' => (new AdminSanPhamController())->detailSanPham(),

    //route bình luận
    // 'update-trang-thai-binh-luan' => (new AdminSanPhamController())->updateTrangThaiBinhLuan(),
     // route quản lý đơn hàng
     'don-hang' => (new AdminDonHangController())->danhSachDonHang(),
     'form-sua-don-hang' => (new AdminDonHangController())->formEditDonHang(),
     'sua-don-hang' => (new AdminDonHangController())->postEditDonHang(),
     'chi-tiet-don-hang' => (new AdminDonHangController())->detailDonHang(),

    // rôute quản lý tài khoản
        // quản lý tài khảon quản trị
        'list-tai-khoan-quan-tri'=>(new AdminTaiKhoanController())->danhSachQuanTri(),   
        'form-them-quan-tri'=>(new AdminTaiKhoanController())->formAddQuanTri(),   
        'them-quan-tri'=>(new AdminTaiKhoanController())->postAddQuanTri(),   

         // router  admin
    'login-admin'         => (new AdminTaiKhoanController())->formLogin(),
    'check-login-admin'   => (new AdminTaiKhoanController())->login(),


    // Router quản lý tài khoản cá nhân (quản trị)
    'form-sua-thong-tin-ca-nhan-quan-tri' => (new AdminTaiKhoanController())->formEditCaNhanQuanTri(),
    // 'sua-thong-tin-ca-nhan-quan-tri'      => (new AdminTaiKhoanController())->postEditCaNhanQuanTri(),
    'sua-mat-khau-ca-nhan-quan-tri'       => (new AdminTaiKhoanController())->postEditMatKhauCaNhan(),
         // router  admin
    'login-admin'         => (new AdminTaiKhoanController())->formLogin(),
    'check-login-admin'   => (new AdminTaiKhoanController())->login(),
    'logout-admin'        => (new AdminTaiKhoanController())->logout(),

    default => function() {
        echo "404 - Không tìm thấy trang";
    }
};

