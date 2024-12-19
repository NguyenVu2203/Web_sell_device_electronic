<?php
include "./inc/header.php";

if (!isset($_SESSION)) {
    session_start();
}
include "../admin/connect.php";

$error_message = ''; 

if (isset($_POST['btn_dangnhap'])) {
    $tendn = $_POST['txttendn'];
    $mk = $_POST['txtmk'];
    if ($tendn == "" || $mk == "") {
        $error_message = "Tên đăng nhập hoặc mật khẩu không được để trống.";
    } else {
        $sql_dn = "SELECT * from tai_khoan where TenDangNhap='$tendn' and MatKhau='$mk' and TrangThai=1";
        $capcha = $_POST['txtcapcha'];
        if ($capcha == $_SESSION['cap']) {
            $result_dn = mysqli_query($conn, $sql_dn);
            if (mysqli_num_rows($result_dn) > 0) {
                $_SESSION['tendn'] = $tendn;
                echo "<script> window.location.href='home.php'; </script>";
            } else {
                $error_message = "Tên đăng nhập hoặc mật khẩu không chính xác.";
            }
        } else {
            $error_message = "Mã xác nhận không chính xác.";
        }
    }
}
include "Capcha.php";
?>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    background: #2193b0; 
    background: -webkit-linear-gradient(to top, #6dd5ed, #2193b0); 
    background: -o-linear-gradient(to top, #6dd5ed, #2193b0);
    background: -moz-linear-gradient(to top, #6dd5ed, #2193b0);
    background: linear-gradient(to top, #6dd5ed, #2193b0);
}
.form-tt {
    width: 100%;
    max-width: 400px;
    max-height: 80%;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background: #fff;
    text-align: center;
}
.form-tt h2 {
    font-size: 30px;
    color: #7579ff;
    margin-bottom: 30px;
    text-transform: uppercase;
}
.form-tt input[type=text],
.form-tt input[type=password] {
    width: 100%;
    padding: 15px 10px;
    margin-bottom: 15px;
    border: 1px solid #7579ff;
    border-radius: 5px;
    font-size: 16px;
}
.form-tt input[type=submit] {
    background-color: #7579ff;
    color: #fff;
    border: none;
    padding: 15px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}
.form-tt input[type=submit]:hover {
    background-color: #b224ef;
}
.checkbox-container {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 8px;
}
.checkbox-container input[type="checkbox"] {
    margin-right: 10px;
}
.checkbox-text {
    color: #7579ff;
    font-size: 14px;
    padding-top: 8px;
}
.notification {
    margin-top: 20px;
    padding: 10px;
    width: 100%;
    max-width: 400px;
    color: #fff;
    background-color: #ff4d4d;
    border-radius: 5px;
}

.capcha-container {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}
.capcha-input {
    width: 100%;
    padding: 15px 10px;
    border: 1px solid #7579ff;
    border-radius: 5px;
    font-size: 16px;
}
.capcha-display {
    background-color: red;
    color: yellow;
    padding: 15px;
    margin-left: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .form-tt {
        padding: 30px 20px;
    }
    .form-tt h2 {
        font-size: 24px;
        margin-bottom: 20px;
    }
}
</style>

<?php include "./inc/navbar.php"; ?>

<div class="form-container">
    <div class="form-tt">
        <h2>Đăng nhập</h2>
        <form action="dangnhap.php" method="post" name="dang-ky">
            <input type="text" name="txttendn" placeholder="Nhập tên đăng nhập" required />
            <input type="password" name="txtmk" placeholder="Nhập mật khẩu" required />
            <div class="capcha-container">
                <input type="text" name="txtcapcha" class="capcha-input" placeholder="Mã xác nhận" required />
                <div class="capcha-display"><?php echo $_SESSION['cap'];?></div>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="checkbox" name="checkbox">
                <label class="checkbox-text" for="checkbox">Nhớ đăng nhập lần sau</label>
            </div>
            <input type="submit" name="btn_dangnhap" value="Đăng nhập" />
        </form>
        <a href="dangky.php" class="psw-text">Tạo tài khoản mới</a>
        <?php if (!empty($error_message)) { echo "<div class='notification'>$error_message</div>"; } ?>
    </div>
</div>

<?php include "./inc/footer.php"; ?>