<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugestao - Dineng Ouvidoria</title>
    <link rel="stylesheet" href="Denuncia.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="denuncia.js" defer></script>
    <link rel="stylesheet" href="chat.css">
    <script src="chat.js" defer></script>
</head>
<body class="d-flex flex-column min-vh-100">



    <!-- Cabeçalho -->
    <div class="header text-center mb-3">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" class="img-fluid" style="height: 100px;">
        <h1 class="dineng1">Sugestao</h1>
    </div>

    <!-- Navegação -->
    <div class="nav d-flex justify-content-around mb-4">
        <a href="Fala dineng.php" class="btn btn-link">Home</a>
        <a href="sugestoes.php" class="btn btn-link">Sugestões</a>
        <a href="rastreamento.php" class="btn btn-link">Solicitações</a>
    </div>

    <!-- Contêiner Principal -->
    <div class="main flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="content mx-auto p-4 bg-light rounded text-center" style="width: 300px; height: 300px;">
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexao.php";
    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $Sugestao = trim($_POST['Sugestao']);
    $arquivo = $_FILES['arquivo'];
    $anonimo = isset($_POST['anonimo']) ? 'on' : 'off';
    $dataregistro = date('Y-m-d H:i:s');

    if ($anonimo == 'on') {
        $nome = 'Anônimo';

        // Consulta corrigida para verificar registros existentes
        $sql = "SELECT * FROM `registros de sugestoes` WHERE nome = 'Anônimo'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $suffix = $count + 1;
            $nome = 'Anônimo_' . $suffix;
        }

        $email = 'anonimo';

        // Consulta corrigida para verificar registros existentes
        $sql = "SELECT * FROM `registros de sugestoes` WHERE email = 'anonimo'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            $suffix = $count + 1;
            $email = 'anonimo_' . $suffix;
        }
    }

    // Consulta corrigida para verificar arquivos existentes
    $sql = "SELECT * FROM `registros de sugestoes` WHERE nome = '$nome' OR arquivo_nome LIKE '%$nome%'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $suffix = $count + 1;
        $arquivo_nome = $nome . "_Sugestao_" . $suffix . "." . pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    } else {
        $arquivo_nome = $nome . "_Sugestao." . pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    }

    $Cod_Denuncia = strtoupper(substr(md5(uniqid()), 0, 2) . rand(100000, 999999));

    $status_denuncia = "Recebida";

    $status_etapas = array(
        "Recebida",
        "Em análise",
        "Em processo",
        "Concluída",
        "Arquivada"
    );

    $descricao = array(
        "Recebida" => " Denúncia recebida ao órgão competente para análise.",
        "Em análise" => "Denúncia em análise pelo órgão competente.",
        "Em processo" => "Denúncia em processo de investigação.",
        "Concluída" => "Denúncia concluída e resolvida.",
        "Arquivada" => "Denúncia arquivada por falta de provas ou por não ter sido possível identificar o autor."
    );

    $user_folder = "arquivos/" . $nome;
    if (!file_exists($user_folder)) {
        if (!mkdir($user_folder, 0777, true)) {
            die("Erro ao criar diretório: " . error_get_last()['message']);
        }
    }

    if (!empty($arquivo['name'])) {
        $arquivo_tipo = $arquivo['type'];
        $arquivo_tmp = $arquivo['tmp_name'];
        $arquivo_destino = $user_folder . "/" . $arquivo_nome;
        if (move_uploaded_file($arquivo_tmp, $arquivo_destino)) {
            $link_arquivo = $arquivo_destino;
            // Consulta de inserção corrigida
            $sql = "INSERT INTO `registros de sugestoes` (nome, email, Sugestao, arquivo_nome, Cod_Sugestao, status_sugestao, descricao, dataregistroSugestao) 
                    VALUES ('$nome', '$email', '$Sugestao', '$link_arquivo', '$Cod_Sugestao', '$status_sugestao', '" . $descricao[$status_sugestao] . "', '$dataregistroSugestao')";
        } else {
            die("Erro ao uploadar arquivo: " . error_get_last()['message']);
        }
    } else {
        // Consulta de inserção corrigida
        $sql = "INSERT INTO `registros de sugestoes` (nome, email, Sugestao, Cod_Sugestao, status_sugestao, descricao, dataregistroSugestao) 
                VALUES ('$nome', '$email', '$Sugestao', '$Cod_Sugestao', '$status_sugestao', '" . $descricao[$status_sugestao] . "', '$dataregistroSugestao')";
    }

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Sugestao enviada com sucesso! Seu código de rastreamento é: <strong>$Cod_Sugestao</strong></div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao enviar Sugestao: " . mysqli_error($conn) . "</div>";
    }

    mysqli_close($conn);
}
?>

            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <div class="footer text-center mt-auto py-3">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Logo" style="height: 20px;">
        &copy; 2024 Dineng Ouvidoria. Todos os direitos reservados.
    </div>

    <!-- Botão de Chat -->
    <div class="chat-button" id="chat-button" onclick="toggleChat()">
        <img src="imagens botoes/chat-bot.png" alt="Chat Icon" class="img-fluid">
    </div>

    <!-- Container do Chatbot -->
    <div class="chat-container" id="chat-container">
        <div id="chat-box" class="chat-box"></div>
        <div class="input-container">
            <input type="text" id="user-input" class="form-control" placeholder="Digite sua pergunta...">
            <button type="button" class="btn btn-primary mt-2" onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
</head>
<body>
    <div class="header text-center">
        <div class="back-arrow-container">
            <a href="Denúncia.php" class="back-arrow">
                <img src="imagens botoes/de-volta (1).png" alt="Voltar" style="height: 40px;">
            </a>
        </div>