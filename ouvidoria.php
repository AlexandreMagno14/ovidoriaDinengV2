<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fala Dineng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="ouvidoriainterna.css">
    <link rel="stylesheet" href="chat.css"> <!-- Referência para o arquivo CSS do chatbot padronizado -->
<script src="chat.js" defer></script> <!-- Referência para o arquivo JavaScript do chatbot -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="ouvidoria interna.js" defer></script> <!-- Referência para o arquivo JavaScript externo -->
</head>
<body>
    <!-- Cabeçalho -->
    <header class="header text-center py-3">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" style="height: 100px;">
        <h1 class="dineng1">OUVIDORIA</h1>
    </header>

    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand" href="#">Menu</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="Fala dineng.php">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="Denúncia.php">Denúncia</a></li>
                <li class="nav-item"><a class="nav-link" href="rastreamento.php">Solicitações</a></li>
                <li class="nav-item"><a class="nav-link" href="sugestoes.php">Sugestão</a></li>
            </ul>
        </div>
    </nav>

    <!-- Caixa de Mensagem Principal -->
    <div class="container my-4">
        <div class="menu-box text-center ">
            <h4>O QUE VOCÊ QUER FAZER?</h4>
            <p>Ajude a aprimorar os serviços públicos por meio de reclamações,<br>ou sugestões, ou ainda, registre uma denúncia.</p>
        </div>
    </div>

    <!-- Botão de Voltar -->
    <div class="container my-2">
        <div class="back-arrow-container text-center">
            <a href="javascript:history.back()" class="back-arrow">
                <img src="imagens botoes/de-volta (1).png" alt="Voltar" style="height: 40px;">
            </a>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container my-4">
        <div class="row">
            <div class="col-md-6 col-lg- mb-6">
                <div class="subtitle text-center">
                    <a href="rastreamento.php">
                        <div class="subtitle-content">
                            <img src="imagens botoes/solicitaçao-removebg-preview.png" alt="Solicitações Imagem" class="subtitle-img img-fluid">
                            <h3>Solicitações</h3>
                        </div>
                    </a>
                    <p><br>Solicite a adoção de providências por parte de uma Ouvidoria.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg- mb-6">
                <div class="subtitle text-center">
                    <a href="reclamaçoes.php">
                        <div class="subtitle-content">
                            <img src="imagens botoes/reclamaçoes-removebg-preview.png" alt="Reclamações Imagem" class="subtitle-img img-fluid">
                            <h3>Reclamações</h3>
                        </div>
                    </a>
                    <p><br>Manifeste sua insatisfação com o serviço da Dineng.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg- mb-6">
                <div class="subtitle">
                    <a href="Denúncia.php">
                        <div class="subtitle-content">
                            <img src="imagens botoes/denuncia-removebg-preview.png" alt="Denúncias Imagem" class="subtitle-img img-fluid">
                            <h3>Denúncias</h3>
                        </div>
                    </a>
                    <p>Comunique uma irregularidade, um ato ilícito ou uma violação de direitos na administração da Dineng Engenharia.</p>
                </div>
            </div>

            <div class="col-md-6 col-lg- mb-6">
                <div class="subtitle text-center">
                    <a href="sugestoes.php">
                        <div class="subtitle-content">
                            <img src="imagens botoes/sugestao-removebg-preview.png" alt="Sugestões Imagem" class="subtitle-img img-fluid">
                            <h3>Sugestões</h3>
                        </div>
                    </a>
                    <p><br>Envie uma ideia ou proposta de melhoria para os serviços da Dineng Engenharia.</p>
                </div>
            </div>
        </div>

        <!-- Link para Perguntas Frequentes -->
        <div class="container mt-3 text-left">
            <a href="Perguntas frequentes.php" class="faq-box ">Perguntas Frequentes</a>
        </div>

    </div>

    <!-- Rodapé -->
    <footer class="footer text-center py-2 text-white">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Logo" style="height: 20px;">
        &copy; 2024 Dineng Ouvidoria. Todos os direitos reservados.
    </footer>

    <!-- Botão de Chat -->
    <div class="chat-button" id="chat-button" onclick="toggleChat()">
        <img src="imagens botoes/chat-bot.png" alt="Chat Icon" class="img-fluid">
    </div>

    <!-- Container do Chatbot -->
    <div class="chat-container" id="chat-container">
        <div id="chat-box" class="chat-box"></div>
        <div class="input-container">
            <input type="text" id="user-input" placeholder="Digite sua pergunta...">
            <button type="button" onclick="sendMessage()">Enviar</button>
        </div>
    </div>
</body>
</html>
<script>
    function toggleChat() {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.style.display = chatContainer.style.display === 'none' || chatContainer.style.display === '' ? 'block' : 'none';
    }

    function sendMessage() {
        const input = document.getElementById('user-input');
        const chatBox = document.getElementById('chat-box');
        if (input.value.trim()) {
            const message = document.createElement('div');
            message.textContent = input.value;
            chatBox.appendChild(message);
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }
</script>
<style>
.faq-box {
    background-color: #005a8b;
    color: #ffffff;
    padding: 10px;
    text-align: center;
    font-size: 1.2rem;
    box-sizing: initial;
    border: 6px solid transparent;
    text-decoration: none;
    display: inline-block;
    border-radius: 30px;
    transition: background-color 0.3s ease;
    margin: 20px -200px;

}
.faq-box:hover {
    background-color: #003f5c;
}

</style>