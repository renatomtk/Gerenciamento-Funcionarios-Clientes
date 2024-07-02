<!-- Arquivo de conexão ao banco dados somativa2_login !-->
<?php
$usuario = 'root';
$senha = '';
$database = 'somativa2_login';
$host = 'localhost';

//instanciando o banco de dados
$mysqli = new mysqli($host, $usuario, $senha, $database);

//mensagem de erro caso não seja possível se conectar ao banco de dados
if ($mysqli->error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
}
