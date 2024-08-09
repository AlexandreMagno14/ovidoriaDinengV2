<?php
// Configurações do banco de dados
$db_host = 'dinsis.mysql.uhserver.com';
$db_username = 'dineng';
$db_password = 'Dineng@2024';
$db_name = 'dinsis';

// Criar conexão
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}


