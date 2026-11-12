<?php
include "conexao.php";

$mensagem = "";

if (isset($_GET["sair"])) {
    session_destroy();
    header("Location: conta.php");
    exit;
}

if (isset($_POST["cadastrar"])) {
    $nome  = mysqli_real_escape_string($conn, $_POST["nome"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $existe = mysqli_query($conn, "SELECT codcli FROM cliente WHERE email = '$email'");

    if (mysqli_num_rows($existe) > 0) {
        $mensagem = "Este e-mail já está cadastrado.";
    } else {
        mysqli_query($conn, "INSERT INTO cliente (nome, email, senha) VALUES ('$nome', '$email', '$senha')");

        $_SESSION["codcli"] = mysqli_insert_id($conn);
        $_SESSION["nome"]   = $_POST["nome"];
        header("Location: produtos.php");
        exit;
    }
}

if (isset($_POST["entrar"])) {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    $resultado = mysqli_query($conn, "SELECT * FROM cliente WHERE email = '$email'");
    $cliente   = mysqli_fetch_assoc($resultado);

    if ($cliente && password_verify($_POST["senha"], $cliente["senha"])) {
        $_SESSION["codcli"] = $cliente["codcli"];
        $_SESSION["nome"]   = $cliente["nome"];
        header("Location: produtos.php");
        exit;
    } else {
        $mensagem = "E-mail ou senha incorretos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minha Conta - Kantovitz Garage</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contato.css">
</head>

<body>

<header>

    <a href="index.html">
        <img src="IMAGENS/logotipo.jpg" alt="Kantovitz Garage" class="logo">
    </a>

    <button id="btn-menu">☰</button>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="quem-somos.html">Quem Somos</a></li>
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="contato.html">Contato</a></li>
            <li><a href="carrinho.php">🛒 Carrinho (<span id="contador-carrinho">0</span>)</a></li>
            <li><a href="conta.php">Minha Conta</a></li>
        </ul>
    </nav>

</header>

<main>

    <?php if ($mensagem) { ?>
        <p style="text-align:center; color:#d32f2f; margin-top:30px;"><?php echo $mensagem; ?></p>
    <?php } ?>

    <?php if (isset($_SESSION["codcli"])) { ?>

        <div class="container-contato" style="max-width: 500px;">
            <section class="form-secao">
                <h2>Olá, <?php echo htmlspecialchars($_SESSION["nome"]); ?>!</h2>
                <p style="color:#ccc; margin-bottom:20px;">Você está logado.</p>
                <a href="produtos.php" class="btn-enviar" style="display:block; text-align:center; text-decoration:none;">Ver produtos</a>
                <p style="margin-top:20px;"><a href="conta.php?sair=1" style="color:#d32f2f;">Sair da conta</a></p>
            </section>
        </div>

    <?php } else { ?>

        <div class="container-contato">

            <section class="form-secao">
                <h2>Entrar</h2>
                <form class="formulario" method="POST" action="conta.php">
                    <label>E-mail</label>
                    <input type="email" name="email" required>

                    <label>Senha</label>
                    <input type="password" name="senha" required>

                    <button type="submit" name="entrar" class="btn-enviar">Entrar</button>
                </form>
            </section>

            <section class="form-secao">
                <h2>Cadastrar</h2>
                <form class="formulario" method="POST" action="conta.php">
                    <label>Nome</label>
                    <input type="text" name="nome" required>

                    <label>E-mail</label>
                    <input type="email" name="email" required>

                    <label>Senha</label>
                    <input type="password" name="senha" required>

                    <button type="submit" name="cadastrar" class="btn-enviar">Cadastrar</button>
                </form>
            </section>

        </div>

    <?php } ?>

</main>

<script src="js/script.js"></script>

</body>
</html>
