<?php
include "conexao.php";

$mensagem = "";


if (isset($_POST["cadastrar"])) {
    $nome      = mysqli_real_escape_string($conn, $_POST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $imagem    = mysqli_real_escape_string($conn, $_POST["imagem"]);
    $preco     = (float) $_POST["preco"];

    mysqli_query($conn, "INSERT INTO produto (nome, descricao, preco, imagem)
                         VALUES ('$nome', '$descricao', $preco, '$imagem')");

    $mensagem = "Produto cadastrado com sucesso!";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Produto - Kantovitz Garage</title>

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
        <p style="text-align:center; color:#4caf50; margin-top:30px;"><?php echo $mensagem; ?></p>
    <?php } ?>

    <div class="container-contato" style="max-width: 500px;">
        <section class="form-secao">
            <h2>Cadastrar Produto</h2>
            <form class="formulario" method="POST" action="cadastro_produto.php">
                <label>Nome</label>
                <input type="text" name="nome" maxlength="100" required>

                <label>Descrição</label>
                <input type="text" name="descricao" maxlength="255">

                <label>Preço</label>
                <input type="number" name="preco" step="0.01" min="0" required>

                <label>Imagem (exemplo: IMAGENS/kit_turbo.jpg)</label>
                <input type="text" name="imagem" maxlength="150">

                <button type="submit" name="cadastrar" class="btn-enviar">Cadastrar</button>
            </form>
        </section>
    </div>

</main>

<script src="js/script.js"></script>

</body>
</html>