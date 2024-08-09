<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dineng Ouvidoria</title>
    <link rel="stylesheet" href= "sugest.css">
    <script src="denuncia.js" defer></script>
</head>
<body>
    <div class="header">
        <img src="imagens botoes/Dineng_Logo_02.png" alt="Dineng Logo" style="height: 100px;">
        <h1 class="dineng1">Login</h1>
    </div>
<body>

    <?php 
        require 'conexao para cadastro.php';
        session_start();
            
        if ($_SESSION['logado'] !=true):
    ?>


    <div class="container container-login">
        <form action="" method="POST">
            <center>
                <h2>login</h2>
            </center>
            <h3>Login</h3>
            <p>Usuário<input type="text" name="usuario" placeholder="Digite seu usuário..." value=<?php if (isset( $_COOKIE['usuario'] )) {
                        echo $_COOKIE['usuario'];
                        } ?>></p>
            <p>Senha<input type="password" name="senha" placeholder="Digite sua senha..."></p>
            <div id='aviso'></div>
            <input type="submit" name="entrar" value="Entrar">
        </form>
    </div>


    <?php 
        else:
            header('location:tabela de denuncias.php');
        endif;
    ?>

</body>

</html>
<?php 

    if(isset($_POST['entrar'])) {
        require 'conexao2.php';

        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        setcookie('usuario', $usuario);

        if ($usuario == 'admin' AND $senha == 'admin' ) {
            $_SESSION['logado'] = true;
            header('location:tabela de denuncias.php');
        }

        $dados = $conexao->prepare("SELECT senha, nome FROM `usuarios da empresa` WHERE usuario = :usuario;");
        $dados->bindValue(':usuario', $usuario);
        $dados->execute();

        if ($dados->rowCount() > 0) {
            $senha_bd = $dados->fetchAll(PDO::FETCH_OBJ);

            foreach ($senha_bd as $user) {
                if (password_verify($senha, $user->senha)){
                    echo "Tudo certo!";
                    setcookie('nome', $user->nome);
                    $_SESSION['logado'] = true;
                    header('location:tabela de denuncias.php');

                } else {
                    // Defina a função aviso_usuario_senha_incorretos() em algum lugar do seu código
                    // aviso_usuario_senha_incorretos();
                    echo "Usuário e/ou senha incorretos!";
                }
            }
        } else {
            // Defina a função aviso_usuario_senha_incorretos() em algum lugar do seu código
            // aviso_usuario_senha_incorretos();
            echo "Usuário e/ou senha incorretos!";
        }

    }

?>