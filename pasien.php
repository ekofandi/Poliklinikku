<?php require_once("koneksi.php");
    if (!isset($_SESSION)) {
        session_start();

    } 
  
  if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
      $ubah = mysqli_query($koneksi, "UPDATE pasien SET 
                                          nama = '" . $_POST['nama'] . "',
                                          alamat = '" . $_POST['alamat'] . "',
                                          no_hp = '" . $_POST['no_hp'] . "',
                                          WHERE
                                          id = '" . $_POST['id'] . "'");
      //update
    } else {
      $tambah = mysqli_query($koneksi, "INSERT INTO pasien (nama, alamat, no_hp)
                      VALUES (
                        '" . $_POST['nama'] . "',
                        '" . $_POST['alamat'] . "',
                        '" . $_POST['no_hp'] . "'
                      )");
    }

    echo "<script>document.location='pasien.php';</script>";
  }

  if (isset($_GET['aksi'])) {
    // Delete
    if ($_GET['aksi'] == 'hapus'){
      $hapus = mysqli_query($koneksi, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    } 

    echo "<script>document.location='pasien.php';</script>";
  }
  
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary ps-5">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Poliklinik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="dokter.php">Dokter</a></li>
                <li><a class="dropdown-item" href="pasien.php">Pasien</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="periksa.php">Periksa</a>
            </li>
          </ul>
          <ul class="navbar-nav right-menu me-5">
            <li class="nav-item d-flex align-items-center">
              <a href="login.php" class="btn btn-secondary" style="border-radius: 100px">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    
    <div class="p-5">
    	<h2>Pasien</h2>

    	<form class="mt-3" method="POST" action="" name="myForm" onsubmit="return(validate());">
    		<?php
        $nama = '';
        $alamat = '';
        $no_hp = '';
				if (isset($_GET['id'])) {
				    $ambil = mysqli_query($koneksi, "SELECT * FROM pasien 
				    WHERE id='" . $_GET['id'] . "'");
				    while ($row = mysqli_fetch_array($ambil)) {
				        $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
				    }
				?>
				    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
				<?php
				}
        ?>
  		  <div class="mb-3">
  		    <label for="exampleInputName" class="form-label">Nama</label>
  		    <input type="name" class="form-control" id="exampleInputName" value="<?= $nama ?>" name="nama">
  		  </div>

  		  <div class="mb-3">
  		    <label for="exampleInputAddress" class="form-label">Alamat</label>
  		    <input type="address" class="form-control" id="exampleInputAddress" value="<?= $alamat ?>" name="alamat">
  		  </div>

  		  <div class="mb-3">
  		    <label for="exampleInputPhone" class="form-label">No. Hp</label>
  		    <input type="phone" class="form-control" id="exampleInputPhone" value="<?= $no_hp ?>" name="no_hp">
  		  </div>

  		  <button type="submit" class="btn btn-primary px-3 mt-3" name="simpan">Simpan</button>
		  </form>
    </div>

    <div class="container-fluid p-5">
      <table class="table">
        <tbody>
            <?php 
              $result = mysqli_query($koneksi, "SELECT * FROM pasien");
              $no = 1;
              while ($data = mysqli_fetch_array($result)) { ?>
              <tr>
                <td>
                  <?php echo $no++ ?>
                </td>
                <td>
                  <?php echo $data['nama'] ?>
                </td>
                <td>
                  <?php echo $data['alamat'] ?>
                </td>
                <td>
                  <?php echo $data['no_hp'] ?>
                </td>
                <td>
                  <a href="index.php?page=pasien&id=<?php echo $data['id'] ?>" class="btn btn-success">Ubah</a>
                  <a href="index.php?page=pasien&id=<?php echo $data['id'] ?>&aksi=hapus" class="btn btn-danger">Hapus</a>
                </td>
              </tr>     
            <?php 
              }
             ?>
        </tbody>
      </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

