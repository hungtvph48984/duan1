<?php
session_start();
class HomeController
{
  public $modelSanPham;
  public $modelTaiKhoan;
  public $modelGioHang;

  public function __construct()
  {
    $this->modelSanPham = new SanPham();
    $this->modelTaiKhoan = new TaiKhoan();
    $this->modelGioHang = new GioHang();
  }
  public function home()
  {
    $listSanPham = $this->modelSanPham->getAllSanPham();
    require_once './views/home.php';
  }
  public function chiTietSanPham()
  {
    $id = $_GET['id_san_pham'];
    $sanPham = $this->modelSanPham->getDetailSanPham($id);
    $listSanPhamDanhMuc = $this->modelSanPham->listSanPhamDanhMuc($sanPham['danh_muc_id']);
    $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);
    // var_dump($listSanPhamDanhMuc);
    // die;
    if (count($sanPham) > 0) {
      require_once './views/detailSanPham.php';
    } else {
      header("Location: " . BASE_URL);
      exit();
    }
  }
  public function formLogin()
  {
    require_once './views/auth/formLogin.php';
    deleteSessionError();
  }

  public function postLogin()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Lấy email và pass gửi lên từ form
      $email    = $_POST['email'];
      $password = $_POST['password'];
      // var_dump($email);die;
      // Xử lý thông tin đăng nhập
      $user = $this->modelTaiKhoan->checkLogin($email, $password);

      if ($user == $email) {
        // Lưu thông tin vào session
        $_SESSION['user_client'] = $user;
        header("Location: " . BASE_URL);
        exit();
      } else {
        // Lưu lỗi vào session
        $_SESSION['error'] = $user;

        $_SESSION['flash'] = true;

        header("Location: " . BASE_URL . '?act=login');
        exit();
      }
    }
  }

  public function addGioHang()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_SESSION['user_client'])) {
        $email = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
        // var_dump($email['id']);
        // die;
        // lấy dữ liệu giỏ hàng của người dùng
        $gioHang = $this->modelGioHang->getGioHangFromUser($email['id']);

        if (!$gioHang) {
          $gioHangId = $this->modelGioHang->addGioHang($email['id']);
          $gioHang=['id'=>$gioHangId];
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        }else{
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        }
        
        $san_pham_id = $_POST['san_pham_id'];

        $so_luong = $_POST['so_luong'];

        $checkSanPham = false;
        foreach($chiTietGioHang as $detail) {
          if ($detail->san_pham_id == $san_pham_id) {
            $newSoLuong = $detail->so_luong + $so_luong;
            $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
            $checkSanPham = true;
            break;
          }
        }
        if (!$checkSanPham) {
          $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
        }
        // var_dump('thêm giỏ hàng thành công');
        header("Location: " . BASE_URL . '?act=gio-hang');
      } else {
        header("Location: " . BASE_URL . '?act=login');

        // var_dump('lỗi chưa đăng nhập');
        // die;
      }
    }
  }

  public function gioHang(){
      if (isset($_SESSION['user_client'])) {
        $email = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
        // lấy dữ liệu giỏ hàng của người dùng
        $gioHang = $this->modelGioHang->getGioHangFromUser($email['id']);

        if (!$gioHang) {
          $gioHangId = $this->modelGioHang->addGioHang($email['id']);
          $gioHang=['id'=>$gioHangId];
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
          
        }else{
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        }
        require_once './views/gioHang.php';
        exit();
      } else {
        header("Location: " . BASE_URL . '?act=login');

      }
    }
}
