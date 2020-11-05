<?php
require("../controller/Les.php");

$id = $_GET["id"];

$query = Index("SELECT * FROM alternatif WHERE id_les = $id");
foreach ($query as $row) {
    $row["kode_alternatif"];
    $row["nm_les"];
}

if (isset($_POST["add"])) {
    if (Edit("alternatif", $_POST) > 0) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data berhasil masuk kedalam database',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then(function() {
            window.location.href = 'index.php?halaman=datales';
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data gagal masuk kedalam database',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then(function() {
            window.location.href = 'index.php?halaman=datales';
        });
        </script>";
    }
}
?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="columns">
                <div class="column">
                    <div class="card">
                        <div class="card-header">
                            <p class="card-header-title">Form Ubah Data Alternatif</p>
                            <div class="buttons card-header-icon">
                                <a class="button is-link" href="index.php?halaman=datales">
                                    <ion-icon name="arrow-back-circle" class="mr-2"></ion-icon>Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <form action="" method="post">
                                <div class="field">
                                    <label class="label">Kode Alternatif</label>
                                    <div class="control has-icons-left">
                                        <input type="hidden" value="<?= $row["id_les"]; ?>" name="id_les">
                                        <input class="input" type="text" placeholder="Nama Tempat Les" name="kode_alternatif" value="<?= $row["kode_alternatif"] ?>">
                                        <span class="icon is-small is-left">
                                            <ion-icon name="qr-code"></ion-icon>
                                        </span>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Nama Alternatif</label>
                                    <div class="control has-icons-left">
                                        <input class="input" type="text" placeholder="Nama Tempat Les" name="nm_les" value="<?= $row["nm_les"]; ?>">
                                        <span class="icon is-small is-left">
                                            <ion-icon name="home"></ion-icon>
                                        </span>
                                    </div>
                                </div>
                                <div class="buttons">
                                    <button class="button is-link" type="submit" name="add">
                                        <ion-icon name="save" class="mr-2"></ion-icon>Simpan
                                    </button>
                                    <button class="button is-link" type="reset">
                                        <ion-icon name="refresh-circle" class="mr-2"></ion-icon>Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>