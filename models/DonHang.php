<?php
class DonHang
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function addDonHang($tai_khoan_id, $ten_nguoi_nhan, $email_nguoi_nhan, $sdt_nguoi_nhan, $dia_chi_nguoi_nhan, $ghi_chu, $tong_tien, $phuong_thuc_thanh_toan_id, $ngay_dat, $trang_thai_id, $ma_don_hang)
    {
        // thêm đơn hàng vào csdl
        try {
            $sql  = "INSERT INTO don_hangs (tai_khoan_id, ten_nguoi_nhan, email_nguoi_nhan, sdt_nguoi_nhan, dia_chi_nguoi_nhan, ghi_chu, tong_tien, phuong_thuc_thanh_toan_id, ngay_dat, trang_thai_id, ma_don_hang) 
        VALUES (:tai_khoan_id, :ten_nguoi_nhan, :email_nguoi_nhan, :sdt_nguoi_nhan, :dia_chi_nguoi_nhan, :ghi_chu, :tong_tien, :phuong_thuc_thanh_toan_id, :ngay_dat, :trang_thai_id, :ma_don_hang)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':tai_khoan_id' => $tai_khoan_id,
                ':ten_nguoi_nhan' => $ten_nguoi_nhan,
                ':email_nguoi_nhan' => $email_nguoi_nhan,
                ':sdt_nguoi_nhan' => $sdt_nguoi_nhan,
                ':dia_chi_nguoi_nhan' => $dia_chi_nguoi_nhan,
                ':ghi_chu' => $ghi_chu,
                ':tong_tien' => $tong_tien,
                ':phuong_thuc_thanh_toan_id' => $phuong_thuc_thanh_toan_id,
                ':ngay_dat' => $ngay_dat,
                ':trang_thai_id' => $trang_thai_id,
                ':ma_don_hang' => $ma_don_hang

            ]);

            return $this->conn->lastInsertId(); // trả về id của đơn hàng vừa thêm vào csdl
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function addChiTietDonHang($don_hang_id, $san_pham_id, $so_luong, $don_gia, $thanh_tien)
    {
        // thêm chi tiết đơn hàng vào csdl
        try {
            $sql  = "INSERT INTO chi_tiet_don_hangs (don_hang_id, san_pham_id, so_luong, don_gia, thanh_tien) 
        VALUES (:don_hang_id, :san_pham_id, :so_luong, :don_gia, :thanh_tien)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':don_hang_id' => $don_hang_id,
                ':san_pham_id' => $san_pham_id,
                ':so_luong' => $so_luong,
                ':don_gia' => $don_gia,
                ':thanh_tien' => $thanh_tien
            ]);
            return true;
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDonHangFromUser($taiKhoanId)
    {
        // thêm chi tiết đơn hàng vào csdl
        try {
            $sql  = "SELECT * FROM don_hangs WHERE tai_khoan_id = :tai_khoan_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':tai_khoan_id' => $taiKhoanId,

            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getTrangThaiDonHang()
    {
        // thêm chi tiết đơn hàng vào csdl
        try {
            $sql  = "SELECT * FROM trang_thai_don_hangs";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getPhuongThucThanhToan()
    {
        // thêm chi tiết đơn hàng vào csdl
        try {
            $sql  = "SELECT * FROM phuong_thuc_thanh_toans";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDonHangById($don_hang_id)
    {
        // thêm chi tiết đơn hàng vào csdl
        try {
            $sql  = "SELECT * FROM don_hangs WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $don_hang_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function getChiTietDonHangByDonHangId($donHangId)
    {
        try {
            $sql  = "SELECT
                    chi_tiet_don_hangs.*,
                    san_phams.ten_san_pham,
                    san_phams.hinh_anh
                    FROM 
                    chi_tiet_don_hangs 
                    JOIN 
                    san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
                    WHERE 
                    chi_tiet_don_hangs.don_hang_id = :don_hang_id ";
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':don_hang_id' => $donHangId]);
    
            // Sửa chỗ này để lấy tất cả sản phẩm trong đơn hàng
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            echo "Lỗi: " . $e->getMessage();
        }
    }
    

    public function updateTrangThaiDonHang($don_hang_id, $trang_thai_don_hang)
    {
        // thêm chi tiết đơn hàng vào csdl
        try {
            $sql  = "UPDATE don_hangs SET trang_thai_id =:trang_thai_id  WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $don_hang_id,
                ':trang_thai_id' => $trang_thai_don_hang
            ]);
            return true;
        } catch (\Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
