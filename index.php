<?php
    //koneksi database
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die (mysqli_error($koneksi));
    
    //jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //pengujian data diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //data akan diedit
                        $edit = mysqli_query($koneksi, " UPDATE tsiswa set
                                                         nim = '$_POST[tnim]',
                                                         nama = '$_POST[tnama]',
                                                         alamat = '$_POST[talamat]',
                                                         prodi = '$_POST[tprodi]'
                                                         WHERE id_siswa = '$_GET[id]'
                                                       ");
            if($edit) //jika edit sukses
            {
            echo "<script>
            alert('Edit data berhasil!');
            document.location='index.php';
            </script>";
            } else {
            echo "<script>
            alert('Edit data Gagal!');
            document.location='index.php';
            </script>";
            }
        }else {
            //data akan disimpan baru
                        $simpan = mysqli_query($koneksi, "INSERT INTO tsiswa(nim, nama, alamat, prodi)
                        VALUES ('$_POST[tnim]','$_POST[tnama]','$_POST[talamat]','$_POST[tprodi]')
            ");
            if($simpan) //jika simpan sukses
            {
            echo "<script>
            alert('Simpan data berhasil!');
            document.location='index.php';
            </script>";
            } else {
            echo "<script>
            alert('Simpan data Gagal!');
            document.location='index.php';
            </script>";
            }
                    }


       
    }

    //pengujian jika tombol edit&hapus di klik
    if(isset($_GET['hal']))
    {
        //pengujian data yang diedit
        if($_GET['hal'] == "edit")
        {
            //tampilkan data yang diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM tsiswa WHERE id_siswa = '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan, maka data ditampung kedalam variabel
                $vnim = $data['nim'];
                $vnama = $data['nama'];
                $valamat = $data['alamat'];
                $vprodi = $data['prodi'];
            }
        }else if($_GET['hal'] == "hapus") {
                //persiapan hapus data
                $hapus = mysqli_query($koneksi, "DELETE FROM tsiswa WHERE id_siswa = '$_GET[id]' ");
                if($hapus){
                        echo "<script>
                    alert('Hapus data berhasil!');
                    document.location='index.php';
                </script>";
                }
        }
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Pendaftaran</title>
  </head>
  <body>
        <div class="container">
        <h1 class="text-center mt-3">Pendaftaran</h1>

        <!-- Awal Card Form -->
            <div class="card">
        <div class="card-header bg-primary text-white">
            Formulir
        </div>
        <div class="card-body">
           <form method="post" action="">
            <div class="form-group">
                <label><b>Nim</b></label>
                <input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Masukkan nim" required>
             </div>
             <div class="form-group">
                <label><b>Nama</b></label>
                <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama" required>
             </div>
             <div class="form-group">
                <label><b>Alamat</b></label>
                <textarea class="form-control" name="talamat" placeholder="Masukkan alamat"><?=@$valamat?></textarea>
             </div>
             <div class="form-group">
                <label><b>Program Studi</b></label>
                <select class="form-control" name="tprodi">
                    <option value="<?=@$vprodi?>"><?=@$vprodi?></option>
                    <option value="RPL-SMK">RPL-SMK</option>
                    <option value="TKJ-SMK">TKJ-SMK</option>
                    <option value="TSM-SMK">TSM-SMK</option>
                 </select>
             </div>

             <button type="submit" class="btn btn-success" name="bsimpan">Daftarkan</button>
             <button type="reset" class="btn btn-danger" name="breset">Batalkan</button>

           </form>
        </div>
        </div>
    <!-- Akhir Card Form -->

    <!-- Awal Card Table -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white">
             Siswa yang Terdaftar
        </div>
        <div class="card-body">
           <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Nim</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Program Studi</th>
                <th>Setting</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tsiswa order by id_siswa desc");
                while ($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['nim']?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['alamat']?></td>
                <td><?=$data['prodi']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id_siswa']?>" class="btn btn-warning"> Edit </a>
                    <a href="index.php?hal=hapus&id=<?=$data['id_siswa']?>" onclick= "return confirm('Apakah anda ingin menghapus?')" class="btn btn-danger"> Hapus </a>
                </td>
            </tr>
            <?php endwhile; //penutup perulangan while ?>

           </table>
        </div>
        </div>
    <!-- Akhir Card Table -->




    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>