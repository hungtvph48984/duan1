

    
    public function __construct()
    {
        $this->modelTaiKhoan = new AdminTaiKhoan;
        $this->modelDonHang = new AdminDonHang;
        $this->modelSanPham = new AdminSanPham;
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

    public function resetPassword(){
        $tai_khoan_id = $_GET['id_quan_tri'];
        $tai_khoan = $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id);
        $password = password_hash('123456', PASSWORD_BCRYPT);

        $status = $this->modelTaiKhoan->resetPassword($tai_khoan_id ,$password);
        // var_dump($status);die;
        if ($status && $tai_khoan['chuc_vu_id'] == 1) {
            header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }elseif($status && $tai_khoan['chuc_vu_id'] == 2) {
            header("Location:" . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
            exit();
        }
        else{
            var_dump('Lỗi khi reset tài khoản');die;
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

    public function detailKhachHang(){
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);

        require_once './views/taikhoan/khachhang/detailKhachHang.php';
    }

    public function logout(){
        if(isset($_SESSION['user_admin'])){
           unset($_SESSION['user_admin']);
           header("Location: " . BASE_URL_ADMIN . '?act=login-admin');
        }
    }
    public function formEditCaNhanQuanTri(){
        $email = $_SESSION['user_admin'];
        $thongTin = $this->modelTaiKhoan->getTaiKhoanformEmail($email);
            // var_dump($thongTin);die;
        require_once './views/taikhoan/canhan/EditCaNhan.php';
        deleteSessionError();
    }


    public function postEditMatKhauCaNhan(){
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
           $old_pass     = $_POST['old_pass'];
           $new_pass     = $_POST['new_pass'];
           $confirm_pass = $_POST['confirm_pass'];
        //    var_dump($old_pass);die;

        // Lấy thông tin user từ session
        $user = $this->modelTaiKhoan->getTaiKhoanformEmail($_SESSION['user_admin']);
        // var_dump($user);die;

        $checkPass = password_verify($old_pass, $user['mat_khau']);
        $errors = [];
        if(!$checkPass){
            $errors['old_pass'] = 'Mật khẩu người dùng không đúng';
        }
        if($new_pass !== $confirm_pass){
            $errors['confirm_pass'] = 'Mật khẩu nhập lại không đúng';   
        }
        if(empty($old_pass)){
            $errors['old_pass'] = 'Vui lòng điền trường dữ liệu này';
        }
        if(empty($new_pass)){
            $errors['new_pass'] = 'Vui lòng điền trường dữ liệu này';
        }
        if(empty($confirm_pass)){
            $errors['confirm_pass'] = 'Vui lòng điền trường dữ liệu này';
        }
        $_SESSION['error '] = $errors;

        if(!$errors){
            // Thực hiện đổi mật khẩu
            $hashPass = password_hash($new_pass, PASSWORD_BCRYPT);
            $status   = $this->modelTaiKhoan->resetPassword($user['id'],$hashPass);
            if($status){
                $_SESSION['success'] = "Bạn đã đổi mật khẩu thành công";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
            }
        }else{
            // Lỗi thì lưu vào session
            $_SESSION['flash'] = true;
            header("Location: " . BASE_URL_ADMIN . '?act=form-sua-thong-tin-ca-nhan-quan-tri');
            exit();
        }
    }
}
}
