<?php
function Koneksi()
{
    return mysqli_connect("localhost", "root", "", "belajar");
}

function Index($query)
{
    $koneksi = Koneksi();
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function Add($table, $data)
{
    $koneksi = Koneksi();
    $kode = htmlspecialchars($data["kode_alternatif"]);
    $tempatles = htmlspecialchars($data["nm_les"]);
    $query = "INSERT INTO $table VALUES (null, '$kode', '$tempatles')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function Edit($table, $data)
{
    $koneksi = Koneksi();
    $idles = htmlspecialchars($data["id_les"]);
    $kode = htmlspecialchars($data["kode_alternatif"]);
    $tempatles = htmlspecialchars($data["nm_les"]);
    $query = "UPDATE $table SET kode_alternatif = '$kode', nm_les = '$tempatles' WHERE id_les = $idles";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function Delete($table, $tableid, $id)
{
    $koneksi = Koneksi();
    $query = "DELETE FROM $table WHERE $tableid = $id";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}
