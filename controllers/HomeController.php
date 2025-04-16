<?php
class HomeController
{
    public $modelSanPham;
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
    }
    public function home()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();
        // Thêm dòng này để lấy danh sách danh mục
        $listDanhMuc = $this->modelSanPham->getAllDanhMuc();
        require_once './views/home.php';
    }
    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listSanPhamDanhMuc = $this->modelSanPham->listSanPhamDanhMuc($sanPham['danh_muc_id']);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
        if (count($sanPham) > 0) {
            require_once './views/detailSanPham.php';
        } else {
            header("Location: " . BASE_URL);
            exit();
        }
    }
    public function trangChu()
    {
        echo "đây là trang chủ của tôi";
    }
    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }
    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if ($user == $email) {
                $_SESSION['user_client'] = $user;
                header("Location: " . BASE_URL);
                exit();
            } else {
                $_SESSION['error'] = $user;
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
        }
    }
    public function formDangKy()
    {
        require_once './views/auth/formDangKy.php';
        deleteSessionError();
    }
    public function postDangKy()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $password = $_POST['mat_khau'];
            $re_pass = $_POST['re_mat_khau'];

            if ($password != $re_pass) {
                $_SESSION['error'] = "mật khẩu không trùng khớp";
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL . "?act=dangky");
                exit();
            }

            $result = $this->modelTaiKhoan->checkDangKy($ho_ten, $email, $password);

            if ($result === true) {
                $_SESSION['success'] = "Đăng ký thành công! Bạn có thể đăng nhập";
                header("Location: " . BASE_URL . "?act=login");
                exit();
            } else {
                $_SESSION['error'] = $result;
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL . "?act=dangky");
                exit();
            }
        }
    }
    // Thêm hàm xử lý hiển thị sản phẩm theo danh mục
    public function listSanPhamDanhMuc()
    {
        $danh_muc_id = $_GET['danh_muc_id'] ?? 0;
        $listSanPham = $this->modelSanPham->listSanPhamDanhMuc($danh_muc_id);
        $listDanhMuc = $this->modelSanPham->getAllDanhMuc(); // Để hiển thị danh mục trong menu
        require_once './views/home.php'; // Hoặc tạo file mới nếu cần giao diện riêng
    }
    public function logoutClient(){
        session_start();
        if(isset($_SESSION['user_client'])){
           unset($_SESSION['user_client']);
        }
            session_destroy();
           header("Location: " . BASE_URL );
           exit();
        
    }
}