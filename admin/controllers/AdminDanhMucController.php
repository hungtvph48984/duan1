<?php

class AdminDanhMucController
{
    public $modelDanhMuc;
    public function __construct()
    {
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function danhSachDanhMuc()
    {
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        require_once './views/danhmuc/listDanhMuc.php';
    }
    public function formAddDanhMuc()
    {
        // hàm dùng để hiển thị form nhập
        require_once './views/danhmuc/addDanhMuc.php';
    }
    public function postAddDanhMuc()
    {
        // hàm dùng để xử lý thêm dữ liệu

        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy ra dữ liệu
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];


            // xử lý validate

            $errors = [];

            if (empty($ten_danh_muc)) {
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
            }
            // không có lỗi thì tiến hành thêm danh mục
            if (empty($errors)) {
                // nếu không lỗi thì tiến hành thêm danh mục
                // var_dump('oke');

                $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            } else {
                // trả lỗi về form và lỗi
                require_once './views/danhmuc/addDanhMuc.php';
            }
        }
    }

    public function formEditDanhMuc()
    {
        // hàm dùng để hiển thị form nhập
        // lấy ra thông tin của danh mục cần sửa 
        $id = $_GET['id_danh_muc'];
        $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        if ($danhMuc) {
            require_once './views/danhmuc/editDanhMuc.php';
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
            exit();
        }
    }
    public function postEditDanhMuc()
    {
        // hàm dùng để xử lý thêm dữ liệu

        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy ra dữ liệu
            $id = $_POST['id'];
            $ten_danh_muc = $_POST['ten_danh_muc'];
            $mo_ta = $_POST['mo_ta'];


            // xử lý validate

            $errors = [];

            if (empty($ten_danh_muc)) {
                $errors['ten_danh_muc'] = 'tên danh mục không được để trống';
            }
            // không có lỗi thì tiến hành thêm danh mục
            if (empty($errors)) {
                // nếu không lỗi thì tiến hành sửa danh mục
                // var_dump('oke');

                $this->modelDanhMuc->updateDanhMuc($id,$ten_danh_muc, $mo_ta);
                header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
                exit();
            } else {
                // trả lỗi về form và lỗi
                $danhMuc = ['id' =>$id,'ten_danh_muc'=> $ten_danh_muc,'mo_ta'=>$mo_ta];
                require_once './views/danhmuc/editDanhMuc.php';
            }
        }
    }


    // public function deleteDanhMuc(){
    //     $id = $_GET['id_danh_muc'];
    //     $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
    //     if ($danhMuc) {
    //         $this->modelDanhMuc->destroyDanhMuc($id);
    //     }
    //         header("Location:" . BASE_URL_ADMIN . '?act=danh-muc');
    //         exit();
        
    // }

    public function deleteDanhMuc()
{
    $id = $_GET['id_danh_muc'];

    $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);

    if ($danhMuc) {
        // Kiểm tra xem có sản phẩm nào thuộc danh mục không
        $productCount = $this->modelDanhMuc->getProductCountByDanhMucId($id);

        if ($productCount == 0) {
            // Không có sản phẩm => cho phép xóa
            $this->modelDanhMuc->destroyDanhMuc($id);
            header("Location:" . BASE_URL_ADMIN . '?act=danh-muc&msg=deleted');
        } else {
            // Có sản phẩm => không cho phép xóa
            header("Location:" . BASE_URL_ADMIN . '?act=danh-muc&error=not_empty');
        }
    } else {
        // Danh mục không tồn tại
        header("Location:" . BASE_URL_ADMIN . '?act=danh-muc&error=not_found');
    }
    exit();
}

}
