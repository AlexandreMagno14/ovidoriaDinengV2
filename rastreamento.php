<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="r.css"> <!-- Referência ao CSS principal -->
    <link rel="stylesheet" href="chat.css"> <!-- Referência ao CSS do chatbot padronizado -->
    <script src="chat.js" defer></script> <!-- Referência ao JavaScript do chatbot -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="rastear.js" defer></script> <!-- Referência ao JavaScript da página de rastreamento -->
    <style>
        .navbar-custom {
            background-color: #0077b6;
        }
        .form-inline {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.3rem; /* Aumenta o tamanho da fonte */
        }
        .form-control {
            font-size: 1.5rem; /* Aumenta o tamanho da fonte */
        }
        .btn-primary {
            font-size: 1.4rem; /* Aumenta o tamanho da fonte */
        }
    </style>
</head>
<body>
    <!-- Cabeçalho -->
    <header class="header text-center py-4">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" style="height: 100px;">
        <h1 class="dineng1">Rastrear Solicitação</h1>
    </header>

    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <a class="navbar-brand" href="#">Dineng Ouvidoria</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="Fala dineng.php">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="Denúncia.php">Denúncia</a></li>
                <li class="nav-item"><a class="nav-link active" href="rastreamento.php">Solicitações</a></li>
                <li class="nav-item"><a class="nav-link" href="sugestoes.php">Sugestão</a></li>
            </ul>
        </div>
    </nav>

    <!-- Botão de Voltar -->
    <div class="back-arrow-container text-center my-3">
        <a href="javascript:history.back()" class="back-arrow">
            <img src="imagens botoes/de-volta (1).png" alt="Voltar" style="height: 40px;">
        </a>
    </div>

    <main class="container mt-4">
        <section class="rastreamento">
            <form class="form-inline mb-5" method="get" action="">
                <label for="codigo_rastreamento" class="mr-2"><h2>Código de Rastreamento:</h2></label>
                <input type="text" id="codigo_rastreamento" name="codigo_rastreamento" class="form-control mr-2" required>
                <button type="submit" class="btn btn-primary">Rastrear</button>
            </form>

            <?php
            include "conexao.php";

            function consultarDenuncia($conn, $codigoRastreamento) {
                $sql = "SELECT * FROM registros WHERE Cod_Denuncia =?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $codigoRastreamento);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }

            function consultarReclamacao($conn, $codigoRastreamento) {
                $sql = "SELECT * FROM `registros de reclamacoes` WHERE Cod_Reclamacao =?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $codigoRastreamento);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }

            function consultarSugestao($conn, $codigoRastreamento) {
                $sql = "SELECT * FROM `registros de sugestoes` WHERE Cod_Sugestao =?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $codigoRastreamento);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result;
            }

            function exibirResultados($result, $tipo) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<h2>". $tipo. " Encontrada</h2>";

                        if ($tipo == "Denúncia") {
                            echo "<p>Código de Rastreamento: ". $row['Cod_Denuncia']. "</p>";
                            echo "<p>Status: ". $row['status_denuncia']. "</p>";
                            $dataRegistro = new DateTime($row['dataregistro']);
                            echo "<p>Data de Registro: ". $dataRegistro->format('d/m/Y'). "</p>";
                            echo "<p>Descrição: ". $row['descricao']. "</p>";
                        } elseif ($tipo == "Reclamação") {
                            echo "<p>Código de Rastreamento: ". $row['Cod_Reclamacao']. "</p>";
                            echo "<p>Status: ". $row['status_reclamacao']. "</p>";
                            $dataRegistro = new DateTime($row['datareclamacao']);
                            echo "<p>Data de Registro: ". $dataRegistro->format('d/m/Y'). "</p>";
                            echo "<p>Descrição: ". $row['descricao']. "</p>";
                        } elseif ($tipo == "Sugestão") {
                            echo "<p>Código de Rastreamento: ". $row['Cod_Sugestao']. "</p>";
                            echo "<p>Status: ". $row['status_Sugestao']. "</p>";
                            $dataRegistro = new DateTime($row['dataregistroSugestao']);
                            echo "<p>Data de Registro: ". $dataRegistro->format('d/m/Y'). "</p>";
                            echo "<p>Descrição: ". $row['descricao']. "</p>";
                        }
                    }
                } else {
                    echo "<p>Nenhum resultado encontrado.</p>";
                }
            }

            if (isset($_GET['codigo_rastreamento'])) {
                $codigoRastreamento = $_GET['codigo_rastreamento'];

                if (preg_match('/^[A-Z0-9]+$/', $codigoRastreamento)) {
                    $resultDenuncia = consultarDenuncia($conn, $codigoRastreamento);
                    $resultReclamacao = consultarReclamacao($conn, $codigoRastreamento);
                    $resultSugestao = consultarSugestao($conn, $codigoRastreamento);

                    if ($resultDenuncia->num_rows > 0) {
                        exibirResultados($resultDenuncia, "Denúncia");
                    } elseif ($resultReclamacao->num_rows > 0) {
                        exibirResultados($resultReclamacao, "Reclamação");
                    } elseif ($resultSugestao->num_rows > 0) {
                        exibirResultados($resultSugestao, "Sugestão");
                    } else {
                        echo "<p>Nenhum resultado encontrado.</p>";
                    }
                } else {
                    echo "<p>Código de rastreamento inválido.</p>";
                }
            } else {
                echo "<p>Preencha o campo de código de rastreamento.</p>";
            }
            ?>

            <p><h3>Se você não tiver o código de rastreamento, por favor, entre em contato conosco.</h3></p>
        </section>
    </main>

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
</body>
</html>
