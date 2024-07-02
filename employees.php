<!-- Página de painel dos funcionários (CRUD) -->
<?php
include('protect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários - Somativa 2</title>
    <!-- Bootstrap (CSS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <!-- Mensagem de boas-vindas ao usuário -->
        <?php
        if (isset($_SESSION['nome'])) {
            echo "<h1 class='lead'>Bem-vindo ao painel, <strong>{$_SESSION['nome']}</strong>!</h1>";
        }
        ?>
        <!-- Logout do sistema -->
        <p><a href="logout.php" class="btn btn-dark">Sair</a></p>
    </div>

    <div class="container my-5">
        <h2>Funcionários</h2>
        <a class="btn btn-primary" href="/somativa2/employees_create.php" role="button">Novo Funcionário</a>
        <a class="btn btn-primary" href="/somativa2/painel.php" role="button">Voltar</a>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Contato</th>
                    <th>Endereço</th>
                    <th>Criado em</th>
                    <th>ID do Cliente</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <!-- Conexão com o banco de dados -->
                <?php
                include('conexao2.php');

                //mensagem de falha caso não seja possível se conectar ao banco de dados
                if ($connection->connect_error) {
                    die("Falha na conexão com o banco de dados: " . $connection->connect_error);
                }

                //realizando o SELECT de todos os clientes no banco de dados 
                $sql = "SELECT * FROM employees";
                $result = $connection->query($sql);

                if (!$result) {
                    die("Query inválida: " . $connection->error);
                }

                //exibindo na tela do usuário todos os registros encontrados
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[email]</td>
                        <td>$row[phone]</td>
                        <td>$row[address]</td>
                        <td>$row[created_at]</td>
                        <td>$row[client_id]</td>                       
                        <td>
                        <a class='btn btn-primary btn-sm' href='/somativa2/employees_edit.php?id=$row[id]'>Editar</a>
                        <a class='btn btn-danger btn-sm' href='/somativa2/employees_delete.php?id=$row[id]'>Deletar</a>
                        </td>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>