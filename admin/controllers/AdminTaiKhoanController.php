<?php 
class AdminTaiKhoanController
{
    public $modelTaiKhoan;

    
    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan();
    }

    public function danhSachQuanTri(){
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    public function formAddQuanTri()
    {
        require_once './views/taikhoan/quantri/addQuanTri.php';
        deleteSessionError();
    }

    public function postAddQuanTri()
    {
        // hàm dùng để xử lý thêm dữ liệu
        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // lấy ra dữ liệu
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            // xử lý validate
            $errors = [];
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên không được để trống';
            }
            if (empty($email)) {
                $errors['email'] = 'Email không được để trống';
            }
            $_SESSION['error'] = $errors;
            // không có lỗi thì tiến hành thêm danh mục
            if (empty($errors)) {
                    // Đặt password mặc định - 123456
                    $password = password_hash('123456', PASSWORD_BCRYPT);
                    // var_dump($password);
                    // Khai báo chức vụ
                    $chuc_vu_id = 1;
                    $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                // trả lỗi về form và lỗi
                $_SESSION['flash'] = true;
                header("Location:" . BASE_URL_ADMIN .  '?act=form-them-quan-tri');
                exit();
            }
        }
    }

    public function formLogin(){
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function login(){
        // session_start();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Lấy email và pass gửi lên từ form
            $email    = $_POST['email'] ;
            $password = $_POST['password'];
            // var_dump($email);die;
            // Xử lý thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email,$password);

            if($user == $email){
                // Lưu thông tin vào session
                $_SESSION['user_admin'] = $user;
                header("Location: " . BASE_URL_ADMIN);
                exit();
            }else{
                // Lưu lỗi vào session
                $_SESSION['error'] = $user;
                // var_dump($_SESSION['error']);die
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            } 
        }
    }
}