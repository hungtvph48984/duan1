<?php

class AdminSanPhamController
{
    public $modelSanPham;
    public $modelDanhMuc;
    public function __construct()
    {
        $this->modelSanPham = new AdminSanPham();
        $this->modelDanhMuc = new AdminDanhMuc();
    }
    public function danhSachSanPham()
    {
        $listSanPham = $this->modelSanPham->getAllSanPham();

        foreach ($listSanPham as &$sanPham) {
            $sanPham['variants'] = $this->modelSanPham->getVariantsBySanPhamId($sanPham['id']);
        }
        unset($sanPham);

        // var_dump($listSanPham); die;

        require_once './views/sanpham/listSanPham.php';
    }

    public function formAddSanPham()
    {
        // hàm dùng để hiển thị form nhập
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/sanpham/addSanPham.php';

        // Xoá session sau khi load lại trang
        deleteSessionError();
    }

    public function postAddSanPham()
    {
        // hàm dùng để xử lý thêm dữ liệu

        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);die;
            // lấy ra dữ liệu
            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            // Biến thể
            $sizes = $_POST['sizes'] ?? [];
            $colors = $_POST['colors'] ?? [];
            $so_luong_variants = $_POST['so_luong_variants'] ?? [];
            // var_dump($_POST['sizes'], $_POST['color'], $_POST['so_luong_variants']); die;



            // Lấy ra hình ảnh sản phẩm
            $hinh_anh = $_FILES['hinh_anh'] ?? null;

            // Lưu hình ảnh vào thư mục
            $file_thumb = uploadFile($hinh_anh, './uploads/');
            // var_dump($file_thumb);

            // Mảng hình ảnh

            $img_array = $_FILES['img_array'];


            // xử lý validate

            $errors = [];

            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
            }

            if (empty($gia_san_pham)) {
                $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
            }

            if (empty($gia_khuyen_mai)) {
                $errors['gia_khuyen_mai'] = 'giá khuyến mãi không được để trống';
            }

            if (empty($so_luong)) {
                $errors['so_luong'] = 'số lượng không được để trống';
            }

            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'ngày nhập được để trống';
            }

            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'danh mục phải chọn';
            }

            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'trạng thái phải chọn';
            }
            // Kiểm tra nếu có dữ liệu biến thể thì kiểm tra biến thể có hợp lệ không
            if (!empty($sizes) || !empty($colors) || !empty($so_luong_variants)) {
                if (
                    !is_array($sizes) || !is_array($colors) || !is_array($so_luong_variants)
                    || count($sizes) !== count($colors) || count($sizes) !== count($so_luong_variants)
                ) {
                    $errors['variants'] = 'Biến thể không phù hợp';
                }
            }



            $_SESSION['error'] = $errors;



            // không có lỗi thì tiến hành thêm sản phẩm 
            if (empty($errors)) {
                // nếu không lỗi thì tiến hành thêm sản phẩm 
                // var_dump('oke');

                $san_pham_id  =   $this->modelSanPham->insertSanPham(
                    $ten_san_pham,
                    $gia_san_pham,
                    $gia_khuyen_mai,
                    $so_luong,
                    $ngay_nhap,
                    $danh_muc_id,
                    $trang_thai,
                    $mo_ta,
                    $file_thumb
                );


                // Thêm biến thể 
                if (!empty($sizes)) {
                    for ($i = 0; $i < count($sizes); $i++) {
                        $this->modelSanPham->insertVariant(
                            $san_pham_id,
                            $sizes[$i],
                            $colors[$i],
                            $so_luong_variants[$i]
                        );
                    }
                }
                // Xử lý thêm album ảnh sản phẩm img_array

                if (!empty($img_array['name'])) {
                    foreach ($img_array['name'] as $key => $value) {

                        $file = [
                            'name' => $img_array['name'][$key],
                            'type' => $img_array['type'][$key],
                            'tmp_name' => $img_array['tmp_name'][$key],
                            'error' => $img_array['error'][$key],
                            'size' => $img_array['size'][$key],
                        ];

                        $link_hinh_anh = uploadFile($file, './uploads/');
                        $this->modelSanPham->insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh);
                    }
                }
                // var_dump($san_pham_id); die;
                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                // trả lỗi về form và lỗi
                // Đặt chỉ thị xoá session sau khi hiển thị form
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=form-them-san-pham');
            }
        }
    }

    public function formEditSanPham()
    {
        // hàm dùng để hiển thị form nhập
        // lấy ra thông tin của danh mục cần sửa 
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
        $listSanPham = $this->modelSanPham->getAllSanPham();
        $listVariant = $this->modelSanPham->getVariantsBySanPhamId($id); // Lấy danh sách biến thể của sản phẩm
        if ($sanPham) {
            require_once './views/sanpham/editSanPham.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }


    public function postEditSanPham()
    {
        // hàm dùng để xử lý thêm dữ liệu

        // kiểm tra xem dữ liệu có phải đc submit lên không
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // var_dump($_POST);
            // die;
            // lấy ra dữ liệu
            // Lấy ra dữ liệu cũ của sản phẩm
            $san_pham_id = $_POST['san_pham_id'] ?? '';
            // Truy vấn dữ liệu cũ của sản phẩm
            $sanPhamOld = $this->modelSanPham->getDetailSanPham($san_pham_id);
            $old_file = $sanPhamOld['hinh_anh']; // Lấy ảnh cũ để sửa ảnh



            $ten_san_pham = $_POST['ten_san_pham'] ?? '';
            $gia_san_pham = $_POST['gia_san_pham'] ?? '';
            $gia_khuyen_mai = $_POST['gia_khuyen_mai'] ?? '';
            $so_luong = $_POST['so_luong'] ?? '';
            $ngay_nhap = $_POST['ngay_nhap'] ?? '';
            $danh_muc_id = $_POST['danh_muc_id'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $hinh_anh = $_FILES['hinh_anh'] ?? null;

            // Biến thể
            $sizes = $_POST['sizes'] ?? [];
            $colors = $_POST['colors'] ?? [];
            $so_luong_variants = $_POST['so_luong_variants'] ?? [];
            $variant_ids = $_POST['variant_ids'] ?? []; // Danh sách ID biến thể từ form


            // xử lý validate

            $errors = [];

            // Logic sửa ảnh

            if (isset($hinh_anh) && $hinh_anh['error'] == UPLOAD_ERR_OK) {
                // upload ảnh mới lên
                $new_file = uploadFile($hinh_anh, './uploads/');

                // Xoá ảnh cũ
                if (!empty($old_file)) {
                    deleteFile($old_file);
                }
            } else {
                $new_file = $old_file;
            }

            if (empty($ten_san_pham)) {
                $errors['ten_san_pham'] = 'tên sản phẩm không được để trống';
            }

            if (empty($gia_san_pham)) {
                $errors['gia_san_pham'] = 'giá sản phẩm không được để trống';
            }

            if (empty($gia_khuyen_mai)) {
                $errors['gia_khuyen_mai'] = 'giá khuyến mãi không được để trống';
            }

            if (empty($so_luong)) {
                $errors['so_luong'] = 'số lượng không được để trống';
            }

            if (empty($ngay_nhap)) {
                $errors['ngay_nhap'] = 'ngày nhập được để trống';
            }

            if (empty($danh_muc_id)) {
                $errors['danh_muc_id'] = 'danh mục phải chọn';
            }

            if (empty($trang_thai)) {
                $errors['trang_thai'] = 'trạng thái phải chọn';
            }








            $_SESSION['error'] = $errors;



            // không có lỗi thì tiến hành thêm sản phẩm 
            if (empty($errors)) {
                // nếu không lỗi thì tiến hành thêm sản phẩm 
                // var_dump('oke');

                $this->modelSanPham->updateSanPham(
                    $san_pham_id,
                    $ten_san_pham,
                    $gia_san_pham,
                    $gia_khuyen_mai,
                    $so_luong,
                    $ngay_nhap,
                    $danh_muc_id,
                    $trang_thai,
                    $mo_ta,
                    $new_file,
                );



                // Lấy danh sách biến thể hiện có trong database
                $existingVariants = $this->modelSanPham->getVariantsBySanPhamId($san_pham_id);
                $existingVariantIds = array_column($existingVariants, 'id');

                // Xoá các biến thể không còn trong form
                foreach ($existingVariantIds as $exsitingId) {
                    if (!in_array($exsitingId, $variant_ids)) {
                        $this->modelSanPham->deleteVariant($exsitingId);
                    }
                }

                // Cập nhật hoặc thêm biến thể 
                if (!empty($sizes)) {
                    for ($i = 0; $i < count($sizes); $i++) {
                        if (isset($variant_ids[$i]) && !empty($variant_ids[$i])) {
                            // Cập nhật biến thể hiện có 
                            $this->modelSanPham->updateVariant(
                                $variant_ids[$i],
                                $sizes[$i],
                                $colors[$i],
                                $so_luong_variants[$i]
                            );
                        } else {
                            // Thêm biến thể mới
                            $this->modelSanPham->insertVariant(
                                $san_pham_id,
                                $sizes[$i],
                                $colors[$i],
                                $so_luong_variants[$i]
                            );
                        }
                    }
                }



                // var_dump($san_pham_id); die;
                header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
                exit();
            } else {
                // trả lỗi về form và lỗi
                // Đặt chỉ thị xoá session sau khi hiển thị form
                $_SESSION['flash'] = true;

                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-san-pham&id_san_pham' . $san_pham_id);
            }
        }
    }

    public function deleteVariant()
    {
        $variant_id =  $_GET['variant_id'] ?? 0;
        $san_pham_id = $_GET['san_pham_id'] ?? 0;

        if ($variant_id && $san_pham_id) {
            $this->modelSanPham->deleteVariant($variant_id);
        }

        header("Location: " . BASE_URL_ADMIN . "?act=form-sua-san-pham&id_san_pham=" . $san_pham_id);
    }




    public function deleteSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);

        // $listAnhSanPham = $this->modelSanPham->getDetailSanPham($id);

        if ($sanPham) {
            deleteFile($sanPham['hinh_anh']);
            $this->modelSanPham->destroySanPham($id);
        }
        header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
        exit();
    }

    public function detailSanPham()
    {
        $id = $_GET['id_san_pham'];

        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        $sanPham['variants'] = $this->modelSanPham->getVariantsBySanPhamId($id); // Gán biến thể vào $sanPham
        if ($sanPham) {
            require_once './views/sanpham/detailSanPham.php';
            deleteSessionError();
        } else {
            header("Location:" . BASE_URL_ADMIN . '?act=san-pham');
            exit();
        }
    }
}
