<!-- Página de login do sistema -->
<?php
include('conexao.php');

//verificando se o usuário já cadastrado está preenchendo o login corretamente
if (isset($_POST['email']) || isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Preencha seu e-mail.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else if (strlen($_POST['senha']) == 0) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Preencha sua senha.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        //proteção contra SQL Injection
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        //realizando consulta no banco de dados para verificar se o usuário está cadastrado no sistema
        $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            //verificando se a senha digitada corresponde à senha criptografada no banco de dados
            if (password_verify($senha, $usuario['senha'])) {
                //inicializando a sessão
                if (!isset($_SESSION)) {
                    session_start();
                }

                //definindo variáveis de sessão para dar boas-vindas ao usuário no arquivo painel.php
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['nome'] = $usuario['nome'];

                //redirecionando o usuário para a página inicial do sistema
                header("Location: painel.php");
                exit();
            } else {
                echo "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Falha ao logar! E-mail ou senha incorretos.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        } else {
            echo "
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Falha ao logar! E-mail ou senha incorretos.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }
}

//verificando se o usuário não cadastrado está preenchendo seu cadastro corretamente
if (isset($_POST['nome_criar']) || isset($_POST['email_criar']) || isset($_POST['senha_criar'])) {
    if (strlen($_POST['nome_criar']) == 0) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Preencha seu nome.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else if (strlen($_POST['email_criar']) == 0) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Preencha seu e-mail.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else if (strlen($_POST['senha_criar']) == 0) {
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Preencha sua senha.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        //proteção contra SQL Injection
        $nome = $mysqli->real_escape_string($_POST['nome_criar']);
        $email = $mysqli->real_escape_string($_POST['email_criar']);
        $senha = $mysqli->real_escape_string($_POST['senha_criar']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST["nome_criar"];
            $email = $_POST["email_criar"];
            $senha = $_POST["senha_criar"];

            //criptografando a senha antes de armazenar no banco de dados
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            try {
                //criando o usuário no banco de dados
                $sql = "INSERT INTO usuarios (nome, email, senha) " .
                    "VALUES ('$nome', '$email', '$senha_hash')";
                $result = $mysqli->query($sql);

                if (!$result) {
                    throw new Exception("Erro ao criar conta.");
                }

                $nome = "";
                $email = "";
                $senha = "";

                $sucesso = "Conta criada com sucesso.";
            } catch (mysqli_sql_exception $e) {
                //código de erro caso um e-mail já esteja em uso
                if ($e->getCode() == 1062) {
                    echo "
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Este e-mail já está cadastrado. Por favor, utilize outro e-mail.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Somativa 2</title>
    <!-- Bootstrap (CSS e JavaScript) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Login  -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Acesse sua conta</h1>
                <form class="form-group" action="" method="post">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control" type="text" name="email">
                    </div>
                    <div class="form-group mt-3">
                        <label for="senha">Senha</label>
                        <input class="form-control" type="password" name="senha">
                    </div>
                    <br>
                    <button class="btn btn-primary btn-block" type="submit">Entrar</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Cadastro -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Crie sua conta</h1>
                <form class="form-group" action="" method="post">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input class="form-control" type="text" name="nome_criar" pattern="[A-Za-záàâãéèêíóôõúç\s]{3,50}" title="O nome deve conter de 3 a 50 letras.">
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">E-mail</label>
                        <input class="form-control" type="email" name="email_criar" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Digite um e-mail válido.">
                    </div>
                    <div class="form-group mt-3">
                        <label for="senha">Senha</label>
                        <input class="form-control" type="password" name="senha_criar" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="A senha deve conter pelo menos 8 caracteres, contendo pelo menos um caracter maiúsculo, um minúsculo e um dígito.">
                    </div>
                    <br>
                    <?php
                    //mensagem de sucesso ao criar o usuário corretamente
                    if (!empty($sucesso)) {
                        echo "
                        <div class='row mb-3'>
                            <div class='col-sm-6'>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>$sucesso</strong>
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>
                            </div>
                        </div>
                        ";
                    }
                    ?>
                    <button class="btn btn-primary btn-block" type="submit">Criar</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>