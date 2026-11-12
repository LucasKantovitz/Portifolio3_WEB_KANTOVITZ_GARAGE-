const formFinalizar = document.getElementById("form-finalizar");

if (formFinalizar) {
    formFinalizar.addEventListener("submit", function (evento) {
        const carrinho = obterCarrinho();

        if (carrinho.length === 0) {
            evento.preventDefault();
            alert("Seu carrinho está vazio!");
            return;
        }

        document.getElementById("itens").value = JSON.stringify(carrinho);
    });
}
