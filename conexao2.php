<!-- Arquivo de conexão ao banco dados somativa2_crud !-->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "somativa2_crud";

//instanciando o banco de dados
$connection = new mysqli($servername, $username, $password, $database);
