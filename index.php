<?php

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';

// Require toàn bộ file Models
require_once './models/SanPham.php';
require_once './models/TaiKhoan.php';
require_once './models/GioHang.php';

require_once './models/DonHang.php';


// Route
$act = $_GET['act'] ?? '/';
// var_dump($act);
// die();
// if ($_GET['act']) {
//     $act = $_GET['act'];
// }else{
//     $act = '/';
// }

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {

    '/' => (new HomeController())->home(), //trường hợp đặc biệt

    // BASE_URL/?act=tên đường dẫn

    'san-pham-tri-tiet' => (new HomeController())->chiTietSanPham(),
 
    'them-gio-hang' => (new HomeController())->addGioHang(),
    'gio-hang' => (new HomeController())->gioHang(),
    'thanh-toan' => (new HomeController())->thanhToan(),
    'xu-li-thanh-toan' => (new HomeController())->postThanhToan(),
    'lich-su-mua-hang' => (new HomeController())->lichSuMuaHang(),
    'chi-tiet-mua-hang' => (new HomeController())->chiTietMuaHang(),
    'huy-don-hang' => (new HomeController())->huyDonHang(),



    // form login trang chu
    'login'             => (new HomeController())->formLogin(),
    'check-login'       => (new HomeController())->postLogin(),
    'dangky'            =>(new HomeController())->formDangKy(),
    'check-dangky'      =>(new HomeController())->postDangKy(),





        echo "404 - Không tìm thấy trang";
    }
};
