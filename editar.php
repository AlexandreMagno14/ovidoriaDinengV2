<?php
include 'conexao.php';

// Verifica se a conexão com o banco de dados foi estabelecida
if ($conn === null) {
    die('Erro ao conectar com o banco de dados.');
}

// Descrições dos status
$descricao = array(
    "Recebida" => "Denúncia recebida ao órgão competente para análise.",
    "Em análise" => "Denúncia em análise pelo órgão competente.",
    "Em processo" => "Denúncia em processo de investigação.",
    "Concluída" => "Denúncia concluída e resolvida.",
    "Arquivada" => "Denúncia arquivada por falta de provas ou por não ter sido possível identificar o autor."
);

// Verifica se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta as informações da denúncia com base no ID
    $stmt = $conn->prepare("SELECT * FROM registros WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $denuncia = $result->fetch_assoc();
    } else {
        echo "Denúncia não encontrada.";
        exit;
    }

    // Atualiza o status e a descrição se o formulário de status for enviado
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $descricao_status = $descricao[$status]; // Obtém a descrição correspondente ao status

        try {
            $update_stmt = $conn->prepare("UPDATE registros SET status_denuncia = ?, descricao = ? WHERE ID = ?");
            $update_stmt->bind_param("ssi", $status, $descricao_status, $id);
            $update_stmt->execute();

            $mensagem = 'Status e descrição atualizados com sucesso!';
            // Atualiza os dados da denúncia após a atualização do status
            $stmt->execute(); // Atualiza o resultado

            $result = $stmt->get_result(); // Atualiza o resultado
            $denuncia = $result->fetch_assoc(); // Atualiza a variável $denuncia
        } catch (Exception $e) {
            $mensagem = 'Erro ao atualizar status e descrição: ' . $e->getMessage();
        }
    }

    // Cadastra uma nova observação se o formulário de observações for enviado
    if (isset($_POST['cadastrar_observacao'])) {
        $observacao = $_POST['observacao'];
        $data = date("Y-m-d"); // Data atual

        try {
            $insert_stmt = $conn->prepare("INSERT INTO observacoes_denuncias (id_denuncia, observacao, data) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("iss", $id, $observacao, $data);
            $insert_stmt->execute();

            $mensagem_observacao = 'Observação cadastrada com sucesso!';
        } catch (Exception $e) {
            $mensagem_observacao = 'Erro ao cadastrar observação: ' . $e->getMessage();
        }
    }

    // Consulta as observações associadas à denúncia
    $observacoes_stmt = $conn->prepare("SELECT * FROM observacoes_denuncias WHERE id_denuncia = ?");
    $observacoes_stmt->bind_param("i", $id);
    $observacoes_stmt->execute();
    $observacoes_result = $observacoes_stmt->get_result();

    // Determine se deve mostrar observações
    $show_observacoes = ($observacoes_result->num_rows > 0 || isset($mensagem_observacao));

} else {
    echo "ID não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Denúncia - Dineng Ouvidoria</title>
    <link rel="stylesheet" href="Denuncia.css">
    <script src="tabela_de_denuncias.js" defer></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 100px;
        }
        .header h1 {
            margin: 10px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        .status-buttons {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .back-button img {
            margin-right: 10px;
        }
        .form-observacao {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo">
        <h1 class="dineng1">Denúncia</h1>
    </div>

    <div class="container">
        <form action="" method="post">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($denuncia['ID']); ?></td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <td><?php echo htmlspecialchars($denuncia['nome']); ?></td>
                </tr>
                <tr>
                    <th>Descrição da Denúncia</th>
                    <td><?php echo htmlspecialchars($denuncia['Denuncia']); ?></td>
                </tr>
                <tr>
                    <th>Data de Envio</th>
                    <td><?php echo date("d/m/Y", strtotime(htmlspecialchars($denuncia['dataregistro']))); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?php echo htmlspecialchars($denuncia['status_denuncia']); ?></td>
                </tr>
                <tr>
                    <th>Descrição do Status</th>
                    <td><?php echo htmlspecialchars($denuncia['descricao']); ?></td>
                </tr>
            </table>

            <div class="status-buttons">
                <?php if ($denuncia['status_denuncia'] == 'Recebida'): ?>
                    <button type="submit" name="status" value="Em análise" class="btn btn-primary">Em análise</button>
                <?php elseif ($denuncia['status_denuncia'] == 'Em análise'): ?>
                    <button type="submit" name="status" value="Em processo" class="btn btn-secondary">Em processo</button>
                    <button type="submit" name="status" value="Arquivada" class="btn btn-danger">Arquivada</button>
                <?php elseif ($denuncia['status_denuncia'] == 'Em processo'): ?>
                    <button type="submit" name="status" value="Concluída" class="btn btn-success">Concluída</button>
                    <button type="submit" name="status" value="Arquivada" class="btn btn-danger">Arquivada</button>
                <?php elseif ($denuncia['status_denuncia'] == 'Arquivada' || $denuncia['status_denuncia'] == 'Concluída'): ?>
                    <button type="submit" name="status" value="Em análise" class="btn btn-primary">Em análise</button>
                <?php endif; ?>
            </div>

            <?php if (isset($mensagem)): ?>
                <div class="alert alert-info"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <!-- Formulário para cadastrar nova observação -->
            <div class="form-observacao">
                <h2>Cadastrar Nova Observação</h2>
                <form action="" method="post">
                    <input type="hidden" name="id_denuncia" value="<?php echo htmlspecialchars($denuncia['ID']); ?>">
                    <div class="form-group">
                        <label for="observacao">Observação:</label>
                        <textarea id="observacao" name="observacao" rows="4"></textarea>
                    </div>
                    <button type="submit" name="cadastrar_observacao" class="btn btn-primary">Cadastrar Observação</button>
                </form>

                <?php if (isset($mensagem_observacao)): ?>
                    <div class="alert alert-info"><?php echo $mensagem_observacao; ?></div>
                <?php endif; ?>
            </div>

            <!-- Exibir observações se houver -->
            <?php if ($show_observacoes): ?>
                <div class="form-observacao">
                    <h2>Observações</h2>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $observacoes_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($row['data'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['observacao']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Botão Voltar -->
            <div class="back-button">
                <a href="tabela de denuncias.php">
                    <img src="imagens botoes/de-volta (1).png" alt="Voltar">
                </a>
            </div>
        </form>
    </div>
</body>
</html>
