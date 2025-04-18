<?php
session_start();

class BinhLuanController {
    public function themBinhLuan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['tai_khoan'])) {
            $sanPhamId = $_POST['san_pham_id'];
            $taiKhoanId = $_SESSION['tai_khoan']['id'];
            $noiDung = trim($_POST['noi_dung']);

            if (!empty($noiDung)) {
                $blModel = new BinhLuan();
                $blModel->insert($sanPhamId, $taiKhoanId, $noiDung);
            }

            header("Location: ?act=san-pham-tri-tiet&id_san_pham=" . $sanPhamId);
        } else {
            echo "Bạn cần đăng nhập để bình luận!";
        }
    }
}
?>