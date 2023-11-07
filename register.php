<?php
include 'koneksi.php';
session_start();
 
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
 
if (isset($_POST['submit'])) {

    // Filter data yang diinputkan
    $nama = $_POST['nama'];
    $username = $_POST['username'];

    // Enkripsi Password
    $password = hash('sha256', $_POST['password']); // Hash the input password using SHA-256
    $cpassword = hash('sha256', $_POST['cpassword']); // Hash the input confirm password using SHA-256
 
    $cek_user = mysqli_query($koneksi,"SELECT * FROM user WHERE username = '$username'");
    $cek_login = mysqli_num_rows($cek_user);

    if ($cek_login > 0) {
        # Untuk mengecek data user telah terdaftar 
        echo "<script>
            alert('Username telah Terdaftar');
            window.Location = 'registrasi.php';
        </script>";
    } else{
        if ($password != $cpassword) {
            # Untuk mengecek data user jika data tidak sesuai
            echo "<script>
            alert('Password yang dimasukkan tidak sesuai');
            window.Location = 'registrasi.php';
            </script>";
        } else{
            mysqli_query($koneksi,"INSERT INTO user VALUES('','$nama','$username','$password')");
            echo "<script>
            alert('User berhasil ditambahkan');
            window.Location = 'login.php';
            </script>";
        }
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css" >
    <title>Poliklinik Register</title>
</head>
<body>
    <div class="container kotak_login">
        <p class="login-text tulisan_login">Register</p>

        <form action="" method="POST" class="login-email">

                <label>Nama Lengkap</label>
                <input type="text" class="form_login" placeholder="Masukkan Nama Lengkap...." name="nama" required="required">
            
                <label>Username</label>
                <input type="text" class="form_login" placeholder="Masukkan Username...." name="username" required="required">

            <!-- <div class="input-group">
                <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
            </div> -->
                <label>Password</label>
                <input type="password" class="form_login" placeholder="Masukkan Password...." name="password" required="required">
            
                <label>Confirm Password</label>
                <input type="password" class="form_login" placeholder="Confirm Password...." name="cpassword" required="required">
            
            <div class="input-group">
                <button name="submit" class="tombol_login">Register</button>
            </div>
            <p class="login-register-text mt-3" style="font-size: 16px;">Anda sudah punya akun? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>