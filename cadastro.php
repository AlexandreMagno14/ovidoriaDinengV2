<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário - Dineng Ouvidoria</title>
    <link rel="stylesheet" href="sugest.css">
    <script src="cadastro.js" defer></script> <!-- Inclua seu script JavaScript aqui, se necessário -->
</head>
<body>
    <div class="header">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" style="height: 100px;">
        <h1 class="dineng1">Cadastro de Usuário</h1>
    </div>
    
    <?php 
    require 'conexao para cadastro.php';
    

    session_start();
    if ($_SESSION['logado']):
?>

<div class="container container-cadastro">

    <h2>Cadastro de usuário</h2>
    <form action="" method="POST">
        <p>Nome:<input type="text" name="nome" placeholder="Digite seu nome"></p>
        <p>Email:<input type="text" name="email" placeholder="Digite seu email"></p>
        <p>Matricula:<input type="text" name="matricula" placeholder="Digite seu número de matricula"></p>
        <p>Usuário: <span id='aviso-usuario'></span>

            <input type="text" name="usuario" placeholder="Digite um usuário único">
        </p>
        <p>Senha: <input type="password" name="senha" placeholder="Digite sua senha aqui"></p>
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>

</div>

<?php 
    else:
        login_necessario();
    endif
?>
<?php 
$cadastrado = false;
$usuario_existente = false;
require 'conexao2.php';

if (isset($_POST['cadastrar'])) {

    if (existe_usuario($_POST['usuario'])) {
        aviso_usuario_existente();
    } else {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $matricula = $_POST['matricula']; // Corrigido para minúscula
        $usuario = $_POST['usuario'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $cadastro = $conexao->prepare(
            "INSERT INTO `usuarios da empresa` (nome, email, matricula, usuario, senha) VALUES (:nome, :email, :matricula, :usuario, :senha);" // Corrigido o nome da tabela e a variável matricula
        );
    
        $cadastro->bindValue(":nome", $nome);
        $cadastro->bindValue(":email", $email);
        $cadastro->bindValue(":matricula", $matricula); // Corrigido para minúscula
        $cadastro->bindValue(":usuario", $usuario);
        $cadastro->bindValue(":senha", $senha);
        try {
            $cadastro->execute();
            $cadastrado = true;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

}

if ($cadastrado):
?>

<script>
alert('Cadastrado com sucesso!')
header('location:login.php');
</script>

<?php 
endif
?>
