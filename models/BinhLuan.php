<?php
require_once 'core/Database.php';

class BinhLuan extends Database {
    public function getBySanPhamId($sanPhamId) {
        $sql = "SELECT bl.*, tk.ho_ten, tk.anh_dai_dien
                FROM binh_luan bl
                JOIN tai_khoan tk ON bl.tai_khoan_id = tk.id
                WHERE bl.san_pham_id = ? AND bl.trang_thai = 1
                ORDER BY bl.ngay_dang DESC";
        return $this->queryAll($sql, [$sanPhamId]);
    }

    public function insert($sanPhamId, $taiKhoanId, $noiDung) {
        $sql = "INSERT INTO binh_luan (san_pham_id, tai_khoan_id, noi_dung) VALUES (?, ?, ?)";
        return $this->query($sql, [$sanPhamId, $taiKhoanId, $noiDung]);
    }
}

?>