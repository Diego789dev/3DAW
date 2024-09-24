<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $file = fopen('usuario.txt', 'a');
    fwrite($file, "$username|$password\n");
    fclose($file);

    echo "Usuário cadastrado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Cadastrar Usuário</h1>
    <form method="POST">
        <label>Nome de Usuário:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Senha:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Cadastrar Usuário">
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
