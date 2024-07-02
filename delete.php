<!-- Página de exclusão de usuário -->
<?php
include('protect.php');
?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    //conexão com o banco de dados
    include('conexao2.php');

    //deletando o cliente do banco de dados
    $sql = "DELETE FROM clients WHERE id=$id";
    $connection->query($sql);
}

//redirecionando o usuário novamente ao painel
header("location: /somativa2/painel.php");
exit;
