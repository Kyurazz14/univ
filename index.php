<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "univ";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("tidak bisa terhubung ke database");
}
$npm    = "";
$nama   = "";
$fakultas = "";
$prodi    = "";
$sukses = "";
$error  = "";

if(isset($_GET['op'])){
    $_op = $_GET['op'];
}else {
    $op = "";
}

if($op == 'update'){
    $id     =$_GET['id'];
    $sql1   ="select * from tb_mahasiswa where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $npm    = $r1['npm'];
    $nama   = $r1['nama'];
    $fakultas = $r1['fakultas'];
    $prodi    = $r1['prodi'];
}
if (isset($_POST['simpan'])) {
    $npm    = $_POST['npm'];
    $nama   = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $prodi    = $_POST['prodi'];

    if ($npm && $nama && $fakultas && $prodi) {
        $sql1 = "insert into tb_mahasiswa(npm,nama,fakultas,prodi) value ('$npm','$nama','$fakultas','$prodi')";
        $q1   = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses         = "Berhasil memasukkan data baru";
        } else {
            $error          = "Gagal memasukkan data";
        }
    } else {
        $error = "Silahkan Masukkan Semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>

                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>

                <?php
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="npm" class="col-sm-2 col-form-label">NPM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="npm" name="npm" value="<?php echo $npm ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">FAKULTAS</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fakultas" name="fakultas" value="<?php echo $fakultas ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="prodi" class="col-sm-2 col-form-label">PRODI</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="prodi" id="prodi">
                                <option value="">-Pilih PRODI-</option>
                                <option value="elektro" <?php if ($prodi == "elektro") echo "selected" ?>>Elektro</option>
                                <option value="sipil" <?php if ($prodi == "sipil") echo "selected" ?>>Sipil</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="simpan data" class="btn btn-primary" />
                    </div>
                </form>

            </div>
        </div>

        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NPM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Prodi</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2   = "select * from tb_mahasiswa order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id    = $r2['id'];
                            $npm    = $r2['npm'];
                            $nama   = $r2['nama'];
                            $fakultas = $r2['fakultas'];
                            $prodi    = $r2['prodi'];
                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $npm ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $fakultas ?></td>
                                <td scope="row"><?php echo $prodi ?></td>
                                <td scope="row">
                                    <a href="index.php?op=update&id=<?php echo $id ?>"><button type="button" class="btn btn-success">Update</button></a>
                                    <button type="button" class="btn btn-danger">Delete</button>

                                </td>
                            </tr>
                        <?php
                        }

                        ?>
                    </tbody>
                    </thead>
                </table>

            </div>
        </div>
    </div>

</body>

</html>