<?php require_once("koneksi.php");
    if (!isset($_SESSION)) {
        session_start();

    } 
  
  if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
      $ubah = mysqli_query($koneksi, "UPDATE periksa SET 
                                          id_pasien = '" . $_POST['id_pasien'] . "',
                                          id_dokter = '" . $_POST['id_dokter'] . "',
                                          tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                          catatan = '" . $_POST['catatan'] . "',
                                          obat = '" . $_POST['obat'] . "'
                                          WHERE
                                          id = '" . $_POST['id'] . "'");
      //update
    } else {
      $tambah = mysqli_query($koneksi, "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan, obat)
                      VALUES (
                        '" . $_POST['id_pasien'] . "',
                        '" . $_POST['id_dokter'] . "',
                        '" . $_POST['tgl_periksa'] . "',
                        '" . $_POST['catatan'] . "',
                        '" . $_POST['obat'] . "'
                      )");
    }

    echo "<script>document.location='periksa.php';</script>";
  }

  if (isset($_GET['aksi'])) {
    // Delete
    if ($_GET['aksi'] == 'hapus'){
      $hapus = mysqli_query($koneksi, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
    } 

    echo "<script>document.location='periksa.php';</script>";
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
    	<h2>Data Periksa</h2>

    	<form class="mt-3" method="POST" action="" name="myForm" onsubmit="return(validate());">
    		<?php
        $id_dokter;
        $id_pasien;
        $tgl_periksa = '';
        $catatan = '';
        $obat = '';
				if (isset($_GET['id'])) {
				    $ambil = mysqli_query($koneksi, "SELECT * FROM periksa 
				    WHERE id='" . $_GET['id'] . "'");
				    while ($row = mysqli_fetch_array($ambil)) {
				        $id_dokter = $row['id_dokter'];
                $id_pasien = $row['id_pasien'];
                $tgl_periksa = $row['tgl_periksa'];
                $catatan = $row['catatan'];
                $obat = $row['obat'];
				    }
				?>
				    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
				<?php
				}
        ?>
        <div class="form-group mb-3">
          <label for="inputPasien" class="sr-only">Pasien</label>
            <select class="form-control" name="id_pasien">
                <?php
                $selected = '';
                $pasien = mysqli_query($koneksi, "SELECT * FROM pasien");
                while ($data = mysqli_fetch_array($pasien)) {
                    if ($data['id'] == $id_pasien) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group mb-3">
          <label for="inputDokter" class="sr-only">Dokter</label>
            <select class="form-control" name="id_dokter">
                <?php
                $selected = '';
                $dokter = mysqli_query($koneksi, "SELECT * FROM dokter");
                while ($data = mysqli_fetch_array($dokter)) {
                    if ($data['id'] == $id_dokter) {
                        $selected = 'selected="selected"';
                    } else {
                        $selected = '';
                    }
                ?>
                    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>

        <div class="col mb-3">
            <label for="inputTanggalPeriksa" class="form-label fw-bold">
                Tanggal Periksa
            </label>
            <input type="datetime-local" class="form-control" name="tgl_periksa" id="inputTanggalPeriksa" placeholder="Tanggal Periksa" value="<?= $tgl_periksa ?>">
        </div>

        <div class="mb-3">
          <label for="exampleCatatan" class="form-label">Catatan</label>
          <input type="text" class="form-control" id="exampleCatatan" value="<?php echo $catatan ?>" name="catatan">
        </div>

        <div class="mb-3">
          <label for="exampleObat" class="form-label">Obat</label>
          <input type="text" class="form-control" id="exampleObat" value="<?php echo $obat ?>" name="obat">
        </div>

  		  <button type="submit" class="btn btn-primary px-3 mt-3" name="simpan">Simpan</button>
		  </form>
    </div>

    <div class="container-fluid p-5">
      <table class="table">
        <tbody>
            <?php
            $result = mysqli_query($koneksi, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
              <tr>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo $data['nama_pasien'] ?></td>
                  <td><?php echo $data['nama_dokter'] ?></td>
                  <td><?php echo $data['tgl_periksa'] ?></td>
                  <td><?php echo $data['catatan'] ?></td>
                  <td><?php echo $data['obat'] ?></td>
                  <td>
                      <a class="btn btn-success rounded-pill px-3" 
                      href="periksa.php?page=periksa&id=<?php echo $data['id'] ?>">
                      Ubah</a>
                      <a class="btn btn-danger rounded-pill px-3" 
                      href="periksa.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
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

