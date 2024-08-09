<?php
session_start(); // Inicia a sessão no início do script
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Denuncia - Dineng Ouvidoria</title>
    <link rel="stylesheet" href="sugest.css">
    <script src="tabela de denuncias.js" defer></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .nav {
            display: flex;
            justify-content: center;
        }
        table {
            margin: 0 auto;
        }
    </style>
</head>
<body>

    </a>
    <div class="header">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" style="height: 100px;">
        <h1 class="dineng1">Acesso Administrativo</h1>
    </div>
    <div class="nav">
       
    </div>
    <div class="container" id="myGroup">
        <h1>Tabelas:</h1>
        <div class="d-flex mb-3">
            <button class="btn btn-outline-primary me-2" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                Tabela de Denúncias
            </button>
            <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample3">
                Tabela de Reclamações
            </button>
                <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4">
                    Cadastro de Usuário
                </button>
                </button>
                <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample5">
                    Sair
                </button>

        </div>

        <div class="collapse" id="collapseExample2" data-parent="#myGroup">
            <div class="card card-body">
                <h2 class="text-center">Tabela de Denúncias</h2>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Denúncia</th>
                            <th>Data de Envio</th>
                            <th>Status</th>
                            <th>Arquivo</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql_query = $conn->query("SELECT * FROM registros") or die($conn->error);
                    while ($arquivos = $sql_query->fetch_assoc()) {
                        if ($arquivos !== null) { ?>
                            <tr>
                                <td><?php echo $arquivos['ID']; ?></td>
                                <td><?php echo $arquivos['nome']; ?></td>
                                <td><?php echo $arquivos['Denuncia']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($arquivos['dataregistro'])); ?></td>
                                <td id="status-<?php echo $arquivos['ID']; ?>"><?php echo $arquivos['status_denuncia']; ?></td>
                                <td>
                                    <a class='btn btn-lg btn-primary' href='<?php echo $arquivos['arquivo_nome']; ?>'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='20' fill='currentColor' class='bi bi-archive' viewBox='0 0 16 16'>
                                            <path d='M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 12.5v-10z'/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a class='btn btn-lg btn-primary' href='editar.php?id=<?php echo $arquivos['ID']; ?>'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                            <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5v-.5h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5v-.5h-.293l6.5 6.5z'/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="collapse" id="collapseExample3" data-parent="#myGroup">
            <div class="card card-body">
                <h2 class="text-center">Tabela de Reclamações</h2>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Reclamação</th>
                            <th>Data de Envio</th>
                            <th>Status</th>
                            <th>Arquivo</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql_query = $conn->query("SELECT * FROM `registros de reclamacoes`") or die($conn->error);
                    while ($arquivos1 = $sql_query->fetch_assoc()) {
                        if ($arquivos1 !== null) { ?>
                            <tr>
                                <td><?php echo $arquivos1['ID']; ?></td>
                                <td><?php echo $arquivos1['nome']; ?></td>
                                <td><?php echo $arquivos1['Reclamacao']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($arquivos1['datareclamacao'])); ?></td>
                                <td id="status-<?php echo $arquivos1['ID']; ?>"><?php echo $arquivos1['status_reclamacao']; ?></td>
                                <td>
                                    <a class='btn btn-lg btn-primary' href='<?php echo $arquivos1['arquivo_nome1']; ?>'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='20' fill='currentColor' class='bi bi-archive' viewBox='0 0 16 16'>
                                            <path d='M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 0 12.5v-10z'/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a class='btn btn-lg btn-primary' href='editar reclamaçoes.php?id=<?php echo $arquivos1['ID']; ?>'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='20' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                            <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5v-.5h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5v-.5h-.293l6.5 6.5z'/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="collapse" id="collapseExample4" data-parent="#myGroup">
    <div class="card card-body">
        <h2 class="text-center">Cadastro de Usuário</h2>
        <a class="btn btn-success btn-sm" href="cadastro.php">
            <!-- SVG (opcional) -->
            Cadastro
        </a>
    </div>
</div>

<div class="collapse" id="collapseExample5" data-parent="#myGroup">
    <div class="card card-body">
        <h2 class="text-center">SAIR</h2>
        <a class="btn btn-danger btn-sm" href="sair.php" role="button">
            <!-- SVG -->
            Sair
        </a>
    </div>
</div>



</body>
</html>
