<?php
session_start();
class HomeController
{
  public $modelSanPham;
  public $modelTaiKhoan;
  public $modelGioHang;
  public $modelDonHang;

  public function __construct()
  {
    $this->modelSanPham = new SanPham();
    $this->modelTaiKhoan = new TaiKhoan();
    $this->modelGioHang = new GioHang();
    $this->modelDonHang = new DonHang();
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
          $gioHang = ['id' => $gioHangId];
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        } else {
          $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        }

        $san_pham_id = $_POST['san_pham_id'];

        $so_luong = $_POST['so_luong'];

        $checkSanPham = false;
        foreach ($chiTietGioHang as $detail) {
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

  public function gioHang()
  {
    if (isset($_SESSION['user_client'])) {
      $email = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
      // lấy dữ liệu giỏ hàng của người dùng
      $gioHang = $this->modelGioHang->getGioHangFromUser($email['id']);

      if (!$gioHang) {
        $gioHangId = $this->modelGioHang->addGioHang($email['id']);
        $gioHang = ['id' => $gioHangId];
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
      } else {
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
      }
      require_once './views/gioHang.php';
      exit();
    } else {
      header("Location: " . BASE_URL . '?act=login');
    }
  }
  public function thanhToan()
  {
    if (isset($_SESSION['user_client'])) {
      $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
      // lấy dữ liệu giỏ hàng của người dùng
      $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);

      if (!$gioHang) {
        $gioHangId = $this->modelGioHang->addGioHang($user['id']);
        $gioHang = ['id' => $gioHangId];
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
      } else {
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
      }
      require_once './views/thanhToan.php';
      exit();
    } else {
      header("Location: " . BASE_URL . '?act=login');
    }
  }
  public function postThanhToan()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // var_dump($_POST);die;
      $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
      $email_nguoi_nhan = $_POST['email_nguoi_nhan'];
      $sdt_nguoi_nhan = $_POST['sdt_nguoi_nhan'];
      $dia_chi_nguoi_nhan = $_POST['dia_chi_nguoi_nhan'];
      $ghi_chu = $_POST['ghi_chu'];
      $tong_tien = $_POST['tong_tien'];
      $phuong_thuc_thanh_toan_id = $_POST['phuong_thuc_thanh_toan_id'];

      $ngay_dat = date('Y-m-d');
      // var_dump($ngay_dat);die;
      $trang_thai_id = 1;
      $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
      $tai_khoan_id = $user['id'];
      $ma_don_hang = 'DH-' . rand(1000, 9999);
      // thêm đơn hàng vào csdl
      $donHang = $this->modelDonHang->addDonHang(
        $tai_khoan_id,
        $ten_nguoi_nhan,
        $email_nguoi_nhan,
        $sdt_nguoi_nhan,
        $dia_chi_nguoi_nhan,
        $ghi_chu,
        $tong_tien, 
        $phuong_thuc_thanh_toan_id, 
        $ngay_dat,
        $trang_thai_id,
        $ma_don_hang
      );
      
      // var_dump('thêm thành công');die;
      
      // lấy thông tin giỏ hàng của người dùng
      $gioHang = $this->modelGioHang->getGioHangFromUser($tai_khoan_id);
      //lưu sản phẩm vào chi tiết đơn hàng
      if ($donHang) {
        //lấy ra chi tiết toàn bộ sản phẩm trong giỏ hàng
        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        //thêm từng sản phẩm từ giỏ hàngvào bảng tri tiết đơn hàng
        foreach ($chiTietGioHang as $item) {
         $donGia = $item->gia_khuyen_mai?? $item->gia_san_pham;
         $this->modelDonHang->addChiTietDonHang(
          $donHang,// id đơn hàng vừa tạo
          $item->san_pham_id,// id sản phẩm
          $item->so_luong,// số lượng sản phẩm trong giỏ hàng
          $donGia,
          $donGia *  $item->so_luong//thành tiền
         );
        }
        //xóa toàn bộ sản phẩm tri tiết giỏ hàng
        $this->modelGioHang->clearDetailGioHang($gioHang['id']);


        // xóa thông tin giỏ hàng người dùng
        $this->modelGioHang->clearGioHang($tai_khoan_id);

        // thêm thành công thì chuyển hướng về lịch sử mua hàng
        header("Location: " . BASE_URL . '?act=lich-su-mua-hang');
        exit();
      
      }else{
        var_dump('lỗi đặt hàng');die;
      }
     
    }
  }
  public function lichSuMuaHang(){

  }

  public function chiTietMuaHang(){
      
  }

  public function huyDonHang(){
      
  }
}
