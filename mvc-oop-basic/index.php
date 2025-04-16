<?php 
session_start();
// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';


// Require toàn bộ file Models
require_once './models/SanPham.php';
require_once './models/TaiKhoan.php';


// Route
$act = $_GET['act'] ?? '/';


match ($act) {
    '/' =>(new HomeController())->home(), 
  

    'san-pham-tri-tiet' =>(new HomeController())->chiTietSanPham(),
    'danh-muc' => (new HomeController())->listSanPhamDanhMuc(),
    // Auth
    'login'             =>(new HomeController())->formLogin(),
    'check-login'       =>(new HomeController())->postLogin(),
    'dangky'            =>(new HomeController())->formDangKy(),
    'check-dangky'      =>(new HomeController())->postDangKy(),
    'logout-client'     =>(new HomeController())->logoutClient(),

    default => function() {
        echo "404 - Không tìm thấy trang";
    }
};
