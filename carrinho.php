<?php
include "conexao.php";

$pedidoGravado = false;
$itens = [];

if (isset($_POST["finalizar"]) && isset($_SESSION["codcli"])) {

    $itens  = json_decode($_POST["itens"], true);
    $codcli = (int) $_SESSION["codcli"];
}

if (!empty($itens)) {

    mysqli_query($conn, "INSERT INTO pedido (data, codcliente) VALUES (NOW(), $codcli)");
    $codped = mysqli_insert_id($conn);

    $quantidades = [];
    foreach ($itens as $item) {
        $id = (int) $item["id"];
        $quantidades[$id] = ($quantidades[$id] ?? 0) + 1;
    }

    foreach ($quantidades as $codprod => $qtde) {
        $resultado = mysqli_query($conn, "SELECT preco FROM produto WHERE codprod = $codprod");
        $produto   = mysqli_fetch_assoc($resultado);
        if (!$produto) {
            continue;
        }
        $preco = $produto["preco"];

        mysqli_query($conn, "INSERT INTO detalhes (codped, codprod, qtde, precovenda)
                             VALUES ($codped, $codprod, $qtde, $preco)");
    }

    $pedidoGravado = true;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrinho - Kantovitz Garage</title>

    <link rel="stylesheet" href="css/style.css">
    <style>
        .carrinho-container { max-width: 800px; margin: 50px auto; padding: 0 20px; }
        .carrinho-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2b2b2b;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 15px;
        }
        .carrinho-item .nome { color: #fff; font-weight: bold; }
        .carrinho-item .preco { color: #d32f2f; font-weight: bold; }
        .btn-remover {
            background-color: #444;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-remover:hover { background-color: #d32f2f; }
        .carrinho-total {
            text-align: right;
            font-size: 20px;
            color: #fff;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn-finalizar {
            background-color: #d32f2f;
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
        }
        .btn-finalizar:hover { background-color: #fff; color: #111; }
        .carrinho-vazio { text-align: center; color: #ccc; padding: 40px 0; }
    </style>
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

    <h1 style="text-align:center; margin: 30px 0;">Meu Carrinho</h1>

    <?php if ($pedidoGravado) { ?>
        <p style="text-align:center; color:#4caf50; font-size:20px;">
            Compra finalizada! Pedido nº <?php echo $codped; ?> gravado no banco.
        </p>
        <script>
            localStorage.removeItem("carrinho");
        </script>
    <?php } ?>

    <div class="carrinho-container" id="carrinho-container">
    </div>

    <div class="carrinho-container" style="text-align:right;">
        <?php if (isset($_SESSION["codcli"])) { ?>
            <form method="POST" action="carrinho.php" id="form-finalizar">
                <input type="hidden" name="itens" id="itens">
                <button type="submit" name="finalizar" class="btn-finalizar">Finalizar Compra</button>
            </form>
        <?php } else { ?>
            <p style="color:#ccc;">Para finalizar a compra, <a href="conta.php" style="color:#d32f2f;">faça login</a>.</p>
        <?php } ?>
    </div>

</main>

<script src="js/script.js"></script>
<script src="js/carrinho.js"></script>
<script src="js/finalizar.js"></script>

</body>
</html>
