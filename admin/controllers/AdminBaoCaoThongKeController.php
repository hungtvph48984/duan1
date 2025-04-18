<?php
class AdminBaoCaoThongKeController
{
    public $modelDonHang;
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    public function home()
    {
        if (isset($_SESSION['user_admin'])) {
            // Lấy dữ liệu từ model
            $tongDonHang = $this->modelDonHang->getTongSoDonHang();
            $tongTien = $this->modelDonHang->getTongTien();
            $tongTaiKhoan = $this->modelTaiKhoan->getTongSoTaiKhoan();

            // Truyền dữ liệu sang view
            require_once './views/home.php';
        } else {
            header("Location: " . BASE_URL . '?act=login');
        }
    }
}
