<?php session_start();
class AdminTaiKhoanController{

    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;

    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan;
        $this->modelDonHang = new AdminDonHang;
        $this->modelSanPham = new AdminSanPham;
    }

    public function danhSachQuanTri()
    {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);

        require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    public function formAddQuanTri()
    {
        require_once './views/taikhoan/quantri/addQuanTri.php';

        deleteSessionError();
    }

    public function postAddQuanTri(){
        // Hàm này dùng để xử lý thêm dữ liệu
        // var_dump($_POST); die;

        // Kiểm tra xem dữ liệu có được submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy ra dữ liệu

            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];

            // Tạo 1 mảng trống để chứa dữ liệu
            $errors = [];
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên không được để trống';
            }
            if (empty($email)) {
                $errors['email'] = 'Email không được để trống';
            }

            $_SESSION['error'] = $errors;

            // Nếu không có lỗi thì tiến hành thêm tài khoản
            if (empty($errors)) {
                //  Nếu không có lỗi thì tiến hành thêm tài khoản
                // đặt password mặc định - 123@123ab
                $password = password_hash('123456', PASSWORD_BCRYPT);

                // Khai báo chức vụ
                $chuc_vu_id = 1;
                // var_dump($password); die;
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);

                header("Location: "  . '?act=list-tai-khoan-quan-tri');
                exit();
            }else{
                // Trả về form  và lỗi
                $_SESSION['flash'] = true;

                header("Location: " . '?act=form-them-quan-tri');
                exit();
            }
        }
    }

    public function formEditQuanTri(){
        $id_quan_tri = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
        // var_dump($quanTri);die;
        require_once './views/taikhoan/quantri/editQuanTri.php';

        deleteSessionError();
    }

    public function postEditQuanTri()
    {
       
        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // var_dump($_POST);
        // die;
            // lấy ra dữ liệu
            
            $quan_tri_id = $_POST['quan_tri_id'] ?? '';

            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
        
            $errors = [];

            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên người dùng không được để trống';
            }
            if (empty($email)) {
                $errors['email'] = 'Email người dùng không được để trống';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Vui Lòng chọn trạng thái';
            }
            
            $_SESSION['error'] = $errors;
         
            if (empty($errors)) {
            $this->modelTaiKhoan->updateTaiKhoan($quan_tri_id,
                                               $ho_ten,
                                               $email,
                                               $so_dien_thoai,
                                               $trang_thai
                                            );
            // var_dump($abc);die;

                // var_dump($san_pham_id); die;
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            } else {
                // trả lỗi về form và lỗi
                // Đặt chỉ thị xoá session sau khi hiển thị form
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri'. $quan_tri_id);
                exit();
            }
        }
    }


    public function danhSachKhachHang()
    {
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);
        
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }


    public function formEditKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        require_once './views/taikhoan/khachhang/editKhachHang.php';

        deleteSessionError();
    }

    public function postEditKhachHang()
    {
       
        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // var_dump($_POST);
        // die;
            // lấy ra dữ liệu
            
            $khach_hang_id = $_POST['khach_hang_id'] ?? '';

            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $ngay_sinh = $_POST['ngay_sinh'] ?? '';
            $gioi_tinh = $_POST['gioi_tinh'] ?? '';
            $dia_chi = $_POST['dia_chi'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
        
            $errors = [];

            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên người dùng không được để trống';
            }

            if (empty($email)) {
                $errors['email'] = 'Email người dùng không được để trống';
            }

            if (empty($ngay_sinh)) {
                $errors['ngay_sinh'] = 'Ngày sinh người dùng không được để trống';
            }
            
            if (empty($gioi_tinh)) {
                $errors['gioi_tinh'] = 'Giới tính người dùng không được để trống';
            }
            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'Vui Lòng chọn trạng thái';
            }
            
            $_SESSION['error'] = $errors;
         
            if (empty($errors)) {
            $this->modelTaiKhoan->updateKhachHang($khach_hang_id,
                                               $ho_ten,
                                               $email,
                                               $so_dien_thoai,
                                               $ngay_sinh,
                                               $gioi_tinh,
                                               $dia_chi,
                                               $trang_thai
                                            );
            // var_dump($abc);die;

                // var_dump($san_pham_id); die;
                header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            } else {
                // trả lỗi về form và lỗi
                // Đặt chỉ thị xoá session sau khi hiển thị form
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang'. $khach_hang_id);
                exit();
            }
        }
    }

    public function deltailKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getdetailTaiKhoan($id_khach_hang);

        $listDonHang = $this->modelDonHang->getDonHangFromKhachHang($id_khach_hang);

        $listBinhLuan = $this->modelSanPham->getBinhLuanFromKhachHang($id_khach_hang);
        require_once './views/taikhoan/khachhang/detailKhachHang.php';
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

            if($user){
                // Lưu thông tin vào session
                $_SESSION['user_admin'] = $user;
                header("Location: " . BASE_URL_ADMIN);
                exit();
            }else{
                // Lưu lỗi vào session
                $_SESSION['error'] = $user;
                
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
                exit();
            } 
        }
    }
}

?>