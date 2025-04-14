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
          $donGia = $item->gia_khuyen_mai ?? $item->gia_san_pham;
          $this->modelDonHang->addChiTietDonHang(
            $donHang, // id đơn hàng vừa tạo
            $item->san_pham_id, // id sản phẩm
            $item->so_luong, // số lượng sản phẩm trong giỏ hàng
            $donGia,
            $donGia *  $item->so_luong //thành tiền
          );
        }
        //xóa toàn bộ sản phẩm tri tiết giỏ hàng
        $this->modelGioHang->clearDetailGioHang($gioHang['id']);


        // xóa thông tin giỏ hàng người dùng
        $this->modelGioHang->clearGioHang($tai_khoan_id);

        // thêm thành công thì chuyển hướng về lịch sử mua hàng
        header("Location: " . BASE_URL . '?act=lich-su-mua-hang');
        exit();
      } else {
        var_dump('lỗi đặt hàng');
        die;
      }
    }
  }
  public function lichSuMuaHang()
  {
    if (isset($_SESSION['user_client'])) {
      $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
      $tai_khoan_id = $user['id'];

      // lấy ra danh sachs trạng thái đơn hàng
      $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
      $trangThaiDonHang = array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');

      // lấy ra danh sachs phương thức thanh toán
      $arrPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
      $phuongThucThanhToan = array_column($arrPhuongThucThanhToan, 'ten_phuong_thuc', 'id');
      // var_dump($phuongThucThanhToan);die;

      //lấy ra danh sách tất cả trong tài khoản
      $donHangs = $this->modelDonHang->getDonHangFromUser($user['id']);
      // var_dump($donHangs);die;
      require_once './views/lichSuMuaHang.php';
    } else {
      header("Location: " . BASE_URL . '?act=login');
    }
  }

  public function chiTietMuaHang()
  {
    if (isset($_SESSION['user_client'])) {
      $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
      $tai_khoan_id = $user['id'];
      // lấy id đơn hàng chuyển từ url
      $donHangId = $_GET['id'];
      // echo "ID đơn hàng: " . $_GET['id'] . "<br>";


      // lấy ra danh sachs trạng thái đơn hàng
      $arrTrangThaiDonHang = $this->modelDonHang->getTrangThaiDonHang();
      $trangThaiDonHang = array_column($arrTrangThaiDonHang, 'ten_trang_thai', 'id');

      // lấy ra danh sachs phương thức thanh toán
      $arrPhuongThucThanhToan = $this->modelDonHang->getPhuongThucThanhToan();
      $phuongThucThanhToan = array_column($arrPhuongThucThanhToan, 'ten_phuong_thuc', 'id');

      // lấy ra thông tin đơn hàng theo id 
      $donHang = $this->modelDonHang->getDonHangById($donHangId);

      // lấy thông tin sản phẩm của đơn hàng trong bảng chi tiết đơn hàng
      $chiTietDonHang = $this->modelDonHang->getChiTietDonHangByDonHangId($donHangId);

      // echo "<pre>";
      // print_r($donHang);
      // print_r($chiTietDonHang);

      if ($donHang['tai_khoan_id'] != $tai_khoan_id) {
        echo "Bạn không có quyền xem đơn hàng này.";
        exit();
      }
      require_once './views/chiTietMuaHang.php';
    } else {
      header("Location: " . BASE_URL . '?act=login');
    }
  }


  public function huyDonHang()
  {
    if (isset($_SESSION['user_client'])) {
      $user = $this->modelTaiKhoan->getTaiKhoanFromEmail($_SESSION['user_client']);
      $tai_khoan_id = $user['id'];
      // lấy id đơn hàng chuyển từ url
      $donHangId = $_GET['id'];

      //kiểm tra đơn hàng
      $donHang = $this->modelDonHang->getDonHangById($donHangId);

      if ($donHang['tai_khoan_id'] != $tai_khoan_id) {
        echo "Bạn không có quyền hủy đơn hàng này.";
        exit();
      }

      if ($donHang['trang_thai_id'] != 1) {
        echo "chỉ đơn hàng ở trạng thái 'chưa xác nhận' mới có thể hủy.";

        exit();
      }

      //hủy đơn hàng
      $this->modelDonHang->updateTrangThaiDonHang($donHangId, 11);
      header("Location: " . BASE_URL . '?act=lich-su-mua-hang');
      exit();
    } else {
      header("Location: " . BASE_URL . '?act=login');
    }
  }

  public function formDangKy(){
    require_once './views/auth/formDangKy.php';
    deleteSessionError();
}

public function postDangKy(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $ho_ten = $_POST['ho_ten'];
        $email = $_POST['email'];
        $password = $_POST['mat_khau'];
        $re_pass = $_POST['re_mat_khau'];

        if ($password != $re_pass ){
            $_SESSION['error'] = "mật khẩu không trùng khớp";
            $_SESSION['flash'] = true;
            header("Location:" . BASE_URL ."?act=dangky");
            exit();
        }

        $result = $this->modelTaiKhoan->checkDangKy($ho_ten,$email,$password);

        if($result === true){
            $_SESSION['success'] = "Đăng ký thành công! Bạn có thể đăng nhập";
            header("Location: " . BASE_URL . "?act=login");
            exit();
        }else{
            $_SESSION['error'] = $result;
            $_SESSION['flash'] = true;
            header("Location:" . BASE_URL . "?act=dangky");
            exit();
        }
    }
}
}
