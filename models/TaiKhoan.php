<?php 
class TaiKhoan
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function checkLogin($email, $mat_khau)
    {
        try{
            $sql  = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $user = $stmt->fetch();

            if($user && password_verify($mat_khau, $user['mat_khau'])){
                if($user['chuc_vu_id'] == 2 ){
                    if($user['trang_thai'] == 1){
                        return $user['email']; // trường hợp đăng nhập thành công
                    }else{
                        return "Tài khoản bị cấm";
                    }                   
                }else{
                    return "Tài khoản không có quyền đăng nhập";
                }
            }else{
                return "Bạn đăng nhập sai thông tin mật khẩu hoặc tài khoản";
            }
        }catch(\Exception $e ){
            echo "Lỗi" . $e->getMessage();
            return false;                                           
        }
    }
    
    public function checkDangKy($ho_ten,$email,$mat_khau){
        try{
            $sql  = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt ->execute(['email'=>$email]);

            if($stmt->fetch()){
                return "Email đã được sử dụng";
            }
            // Mã hoá mật khẩu
            $hashedPassword = password_hash($mat_khau, PASSWORD_DEFAULT);
            
            // Thêm tài khoản mới    
            $sql ="INSERT INTO tai_khoans (ho_ten, email, mat_khau, chuc_vu_id, trang_thai)
                    VALUE (:ho_ten, :email, :mat_khau,2,1)";

            $stmt = $this->conn->prepare($sql);
            $stmt ->execute([
                'ho_ten'    =>$ho_ten,
                'email'     =>$email,
                'mat_khau'  =>$hashedPassword
            ]);
            return true;
        }catch(\Exception $e){
            return "Đăng ký thất bại! " .$e->getMessage();
        }
    }
}