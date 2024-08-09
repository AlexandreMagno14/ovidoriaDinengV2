<?php 

    try {
        $conexao = new PDO('mysql: host =  dinsis.mysql.uhserver.com; dbname=dinsis', 'dineng', 'Dineng@2024');
    }  catch (Exception $erro) {
            echo $erro -> getMessage();
            echo "<br>";
            echo $erro -> getCode();
        }

    

?>