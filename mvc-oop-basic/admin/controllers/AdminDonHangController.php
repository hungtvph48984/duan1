<?php

class AdminDonHangController
{
    public $modelDonHang;
    
    public function __construct()
    {
        $this->modelDonHang = new AdminDonHang();
        
    }
    public function danhSachDonHang()
    {
        
        $listDonHang = $this->modelDonHang->getAllDonHang();
        
        require_once './views/donhang/listDonHang.php';

    }
    public function detailDonHang()
    {
        $don_hang_id = $_GET['id_don_hang'];

        // Lấy thông tin đơn hàng ở bảng don_hangs
        $donHang = $this->modelDonHang->getDetailDonHang($don_hang_id);

        // Lấy danh sách sản phẩm đã đặt của đơn hàng ở bảng chi_tiet_don_hangs

        $sanPhamDonHang = $this->modelDonHang->getListSpDonHang($don_hang_id);
        
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();

        require_once './views/donhang/detailDonHang.php';
    }
    public function formEditDonHang()
    {
        $id = $_GET['id_don_hang'];
        $donHang = $this->modelDonHang->getDetailDonHang($id);
        $listTrangThaiDonHang = $this->modelDonHang->getAllTrangThaiDonHang();
        if ($donHang) {
            require_once './views/donhang/editDonHang.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=don-hang');
            exit();
        }
    }
    public function postEditDonHang()
        {
            // hàm dùng để xử lý thêm dữ liệu

            // kiểm tra xem dữ liệu có phải đc submit lên không
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);
            // die;
                // lấy ra dữ liệu
                
                $don_hang_id = $_POST['don_hang_id'] ?? '';

                $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'] ?? '';
                $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'] ?? '';
                $email_nguoi_nhan = $_POST['email_nguoi_nhan'] ?? '';
                $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'] ?? '';
                $ghi_chu = $_POST['ghi_chu'] ?? '';
                $trang_thai_id = $_POST['trang_thai_id'] ?? '';
                
        


            

                // xử lý validate

                

              
                $errors = [];

                if (empty($ten_nguoi_nhan)) {
                    $errors['ten_nguoi_nhan'] = 'Tên người nhận không được để trống';
                }

                if (empty($sdt_nguoi_nhan)) {
                    $errors['sdt_nguoi_nhan'] = 'Số điện thoại người nhận không được để trống';
                }

                if (empty($email_nguoi_nhan)) {
                    $errors['email_nguoi_nhan'] = 'Email người nhận không được để trống';
                }

                if (empty($dia_chi_nguoi_nhan)) {
                    $errors['dia_chi_nguoi_nhan'] = 'Địa chỉ người nhận không được để trống';
                }
                if (empty($trang_thai_id)) {
                    $errors['trang_thai_id'] = 'Trạng thái đơn hàng';
                }
                
                $_SESSION['error'] = $errors;
                
                // không có lỗi thì tiến hành thêm sản phẩm 
                // var_dump($don_hang_id);die; 
                if (empty($errors)) {
                    // nếu không lỗi thì tiến hành sửa
                    // var_dump('oke');

                $abc = $this->modelDonHang->updateDonHang($don_hang_id,
                                                   $ten_nguoi_nhan,
                                                   $sdt_nguoi_nhan,
                                                   $email_nguoi_nhan,
                                                   $dia_chi_nguoi_nhan,
                                                   $ghi_chu,
                                                   $trang_thai_id
                                                );
                // var_dump($abc);die;


        

                    // var_dump($san_pham_id); die;
                    header("Location:" . BASE_URL_ADMIN . '?act=don-hang');
                    exit();
                } else {
                    // trả lỗi về form và lỗi
                    // Đặt chỉ thị xoá session sau khi hiển thị form
                    $_SESSION['flash'] = true;

                    header("Location: " . BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang'. $don_hang_id);
                    exit();
                }
            }
    }




    // public function deleteSanPham()
    // {
    //     $id = $_GET['id_san_pham'];
    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);

    //     // $listAnhSanPham = $this->modelSanPham->getDetailSanPham($id);

    //     if ($sanPham) {
    //         deleteFile($sanPham['hinh_anh']);
    //         $this->modelSanPham->destroySanPham($id);
    //     }
    //     header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
    //     exit();
    // }

    // public function detailSanPham()
    // {
    //     $id = $_GET['id_san_pham'];

    //     $sanPham = $this->modelSanPham->getDetailSanPham($id);
    //     $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
    //     if ($sanPham) {
    //         require_once './views/sanpham/detailSanPham.php';
    //         deleteSessionError();
    //     } else {
    //         header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
    //         exit();
    //     }
    // }
    
}
