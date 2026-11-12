<?php
$host  = "localhost";
$user  = "root";
$senha = "sua_senha";
$banco = "kantovitz_garage";

try {
    $conn = mysqli_connect($host, $user, $senha, $banco);
} catch (mysqli_sql_exception $e) {
    die("Erro ao conectar no banco: " . $e->getMessage() .
        "<br>Confira a senha em conexao.php e se você já executou o banco.sql no MySQL Workbench.");
}

mysqli_set_charset($conn, "utf8mb4");

session_start();

if (isset($_SESSION["codcli"])) {
    $codcli = (int) $_SESSION["codcli"];
    $existe = mysqli_query($conn, "SELECT codcli FROM cliente WHERE codcli = $codcli");
    if (mysqli_num_rows($existe) == 0) {
        session_unset();
    }
}
?>
