<!-- Página de edição de usuário -->
<?php
include('protect.php');
?>

<!-- Conexão com o banco de dados -->
<?php
include('conexao2.php');

$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location: /somativa2/painel.php");
        exit;
    }

    $id = $_GET["id"];

    $sql = "SELECT * FROM clients WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: /somativa2/painel.php");
        exit;
    }

    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
} else {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    do {
        //validação dos campos
        if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)) {
            $erro = "Todos os campos são obrigatórios.";
            break;
        }

        try {
            //atualizando o usuário no banco de dados
            $sql = "UPDATE clients " .
                "SET name = '$name', email = '$email', phone = '$phone', address = '$address' " .
                "WHERE id = $id";

            $result = $connection->query($sql);

            if (!$result) {
                $erro = "Query inválida: " . $connection->error;
                break;
            }

            $sucesso = "Cliente atualizado com sucessso.";

            header("location: /somativa2/painel.php");
            exit;
        } catch (mysqli_sql_exception $e) {
            //código de erro caso um e-mail já esteja em uso
            if ($e->getCode() == 1062) {
                $erro = "Este e-mail já está cadastrado. Por favor, utilize outro e-mail.";
            }
        }
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - Somativa 2</title>
    <!-- Bootstrap (CSS e JavaScript) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Função JavaScript para cancelar um formulario -->
    <script>
        function cancelar() {
            window.location.href = "/somativa2/painel.php";
        }
    </script>
</head>

<body>
    <div class="container my-5">
        <h2>Editar Cliente</h2>

        <?php
        if (!empty($erro)) {
            echo "
                <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$erro</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nome</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" pattern="[A-Za-záàâãéèêíóôõúç\s]{3,50}" title="O nome deve conter de 3 a 50 letras.">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Digite um e-mail válido.">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contato</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" pattern="[0-9]{11}" title="O contato deve conter 11 dígitos.">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Endereço</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" pattern="^(?![a-zA-Z0-9]+$).+" title="Digite um endereço válido.">
                </div>
            </div>

            <?php
            if (!empty($sucesso)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$sucesso</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }

            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <button type="button" class="btn btn-outline-primary" onclick="cancelar()">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>