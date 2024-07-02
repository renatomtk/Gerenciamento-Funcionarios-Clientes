<!-- Arquivo de proteção para que usuários não autenticados não acessem as páginas do sistema -->
<?php
if (!isset($_SESSION)) {
    session_start();
}

//indicando para o usuário retornar à página de login para realizar a autenticação
if (!isset($_SESSION['id'])) {
    echo "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
        <title>Acesso Negado`- Somativa 2</title>
    </head>
    <body>
        <div class='container mt-5'>
            <div class='alert alert-danger' role='alert'>
                Você não pode acessar esta página porque não está logado.
            </div>
            <p><a href='index.php'>Entrar</a></p>
        </div>
    </body>
    </html>";
    exit;
}
