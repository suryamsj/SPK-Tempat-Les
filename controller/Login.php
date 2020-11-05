<?php
function Connect()
{
    return mysqli_connect("localhost", "root", "", "belajar");
}

function Show($query)
{
    $koneksi = Connect();
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function Login($data)
{
    $koneksi = Connect();
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);

    if (Show("SELECT * FROM admin WHERE username='$username' && password='$password'")) {
        header("Location: page/index.php");
        $_SESSION['login'] = true;
        exit;
    } else {
        return [
            'error' => true,
            'pesan' => 'Username / Password Salah'
        ];
    }
}
