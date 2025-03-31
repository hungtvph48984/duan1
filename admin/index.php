<?php 
session_start();
// Require file Common
require_once '../commons/env.php'; // Khai báo biến môi trường
require_once '../commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/AdminDanhMucController.php';
require_once './controllers/AdminSanPhamController.php';
require_once './controllers/AdminBaoCaoThongKeController.php';
require_once './controllers/AdminTaiKhoanController.php';




// Require toàn bộ file Models
require_once './models/AdminDanhMuc.php';
require_once './models/AdminSanPham.php';
require_once './models/AdminTaiKhoan.php';


// Route
$act = $_GET['act'] ?? '/';
// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    //router báo cáo thống kê - trang chủ
    '/' => (new AdminBaoCaoThongKeController())->home(),


    // '/' => (new AdminDanhMucController())->danhSachDanhMuc(), // Ví dụ hiển thị danh mục mặc định
    'danh-muc'           => (new AdminDanhMucController())->danhSachDanhMuc(),
    'form-them-danh-muc' => (new AdminDanhMucController())->formAddDanhMuc(),
    'them-danh-muc'      => (new AdminDanhMucController())->postAddDanhMuc(),
    'form-sua-danh-muc'  => (new AdminDanhMucController())->formEditDanhMuc(),
    'sua-danh-muc'       => (new AdminDanhMucController())->postEditDanhMuc(),
    'xoa-danh-muc'       => (new AdminDanhMucController())->deleteDanhMuc(),

       // route sản phẩm
    'san-pham'           => (new AdminSanPhamController())->danhSachSanPham(),
    'form-them-san-pham' => (new AdminSanPhamController())->formAddSanPham(),
    'them-san-pham'      => (new AdminSanPhamController())->postAddSanPham(),
    'form-sua-san-pham'  => (new AdminSanPhamController())->formEditSanPham(),
    'sua-san-pham'       => (new AdminSanPhamController())->postEditSanPham(),
    'xoa-san-pham'       => (new AdminSanPhamController())->deleteSanPham(),
    'chi-tiet-san-pham'  => (new AdminSanPhamController())->detailSanPham(),

    // router quản lý tài khoản
    'list-tai-khoan-quan-tri' =>(new AdminTaiKhoanController())->danhSachQuanTri(),
    'form-them-quan-tri'      =>(new AdminTaiKhoanController())->formAddQuanTri(),
    'them-quan-tri'           =>(new AdminTaiKhoanController())->postAddQuanTri(),

    // router
    'login-admin'         => (new AdminTaiKhoanController())->formLogin(),
    'check-login-admin'   => (new AdminTaiKhoanController())->login(),


        
};

