<?php 

class HomeController
{ 
    public $modelSanPham ;

    public function __construct()
    {
      $this -> modelSanPham = new SanPham();
    }
    public function home(){
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }
    public function chiTietSanPham(){
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        // $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        // $listBinhLuan = $this-> modelSanPham->getBinhLuanFromSanPham($id);
        if (count($sanPham)> 0 ) {
          require_once './views/detailSanPham.php';
        }else{
          header("Location: " . BASE_URL);
          exit();
        }
        
    }

}