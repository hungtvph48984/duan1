<?php 

class HomeController
{
    public $modelSanPham ;
    public $modelTaiKhoan ;

    public function __construct()
    {
      $this -> modelSanPham  = new SanPham();
      $this -> modelTaiKhoan = new TaiKhoan();
    }
    public function home(){
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }

    public function chiTietSanPham(){
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listSanPhamDanhMuc = $this->modelSanPham->listSanPhamDanhMuc($sanPham['danh_muc_id']); 
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $listBinhLuan = $this-> modelSanPham->getBinhLuanFromSanPham($id);
        // var_dump($listSanPhamDanhMuc);
        // die;
        if (count($sanPham)> 0 ) {
          require_once './views/detailSanPham.php';
        }else{
          header("Location: " . BASE_URL);
          exit();
        }
        
    }
    public function trangChu(){
        echo "đây là trang chủ của tôi";
    }

    public function formLogin(){
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }

    public function postLogin(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Lấy email và pass gửi lên từ form
            $email    = $_POST['email'] ;
            $password = $_POST['password'];
            // var_dump($email);die;
            // Xử lý thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email,$password);

            if($user == $email){
                // Lưu thông tin vào session
                $_SESSION['user_client'] = $user;
                header("Location: " . BASE_URL);
                exit();
            }else{
                // Lưu lỗi vào session
                $_SESSION['error'] = $user;
                
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL. '?act=login');
                exit();
            } 
        }
    }

}