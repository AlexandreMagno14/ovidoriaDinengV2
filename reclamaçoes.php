<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reclamação - Dineng Ouvidoria</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="Denuncia.css">
    <link rel="stylesheet" href="chat.css"> <!-- Referência para o arquivo CSS do chatbot padronizado -->
    <script src="chat.js" defer></script> <!-- Referência para o arquivo JavaScript do chatbot -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .header {
            position: relative;
        }
        .back-arrow-container {
            position: absolute;
            top: 10px;
            left: 10px;
        }
       
    </style>
</head>
<body>
    <div class="header text-center">
        <div class="back-arrow-container">
            <a href="javascript:history.back()" class="back-arrow">
                <img src="imagens botoes/de-volta (1).png" alt="Voltar" style="height: 40px;">
            </a>
        </div>
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" style="height: 100px;">
        <h1 class="dineng1">Reclamação</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="Fala dineng.php">Home</a>
        <a class="navbar-brand" href="sugestoes.php">Sugestões</a>
        <a class="navbar-brand active" href="solicitaçoes.php">Solicitações</a>
    </nav>
    <div class="container mt-4 mb-4">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="card-title text-center">Envie sua Denuncia</h2>
                <form action="respostta.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Seu nome">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Seu e-mail">
                    </div>
                    <div class="form-group">
                        <label for="Denuncia">Reclamação:</label>
                        <textarea id="Denuncia" name="Denuncia" class="form-control" rows="4" placeholder="Descreva sua Reclamação" required maxlength="2000"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="anonimo" value="on" class="form-check-input" id="anonimo">
                        <label class="form-check-label" for="anonimo">Anônimo</label>
                    </div>
                    <div class="form-group">
                        <label for="arquivo">Selecione o arquivo:</label>
                        <input type="file" name="arquivo" class="form-control-file">
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Enviar" class="btn btn-success btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer text-center mt-4">
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

    <script>
        function toggleChat() {
            const chatContainer = document.getElementById('chat-container');
            chatContainer.style.display = chatContainer.style.display === 'none' || chatContainer.style.display === '' ? 'flex' : 'none';
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
</body>
</html>

