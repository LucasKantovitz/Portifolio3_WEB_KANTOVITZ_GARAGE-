<?php
include "conexao.php";

$resultado = mysqli_query($conn, "SELECT codprod AS id, nome, descricao, preco, imagem FROM produto");

$produtos = [];
while ($linha = mysqli_fetch_assoc($resultado)) {
    $linha["preco"] = (float) $linha["preco"];
    $produtos[] = $linha;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produtos - Kantovitz Garage</title>

    <link rel="stylesheet" href="css/style.css">
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

    <h1 style="text-align:center; margin: 30px 0 10px;">Produtos</h1>
    <p style="text-align:center;"><a href="cadastro_produto.php" style="color:#d32f2f;">Cadastrar novo produto</a></p>

    <div class="lista-produtos" id="lista-produtos">
    </div>

</main>


<script>
    const produtosBanco = <?php echo json_encode($produtos); ?>;
</script>
<script src="js/script.js"></script>
<script src="js/produtos_banco.js"></script>

</body>
</html>
