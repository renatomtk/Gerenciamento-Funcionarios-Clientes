<!-- Arquivo de logout para encerrar a sessão do usuário -->
<?php
if (!isset($_SESSION)) {
    session_start();
}

//encerrando a sessão
session_destroy();

//retornando o usuário para a página de login do sistema
header("Location: index.php");
