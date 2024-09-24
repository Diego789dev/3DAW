<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $questao = $_POST['pergunta'];
    $options = $_POST['options'];
    
    $file = fopen('questions.txt', 'a');
    fwrite($file, "$questao|".implode(',', $options)."\n");
    fclose($file);

    echo "Pergunta criada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar Pergunta</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Criar Pergunta de Múltipla Escolha</h1>
    <form method="POST">
        <label>Pergunta:</label><br>
        <input type="text" name="pergunta" required><br><br>
        
        <label>Opções (separadas por vírgula):</label><br>
        <input type="text" name="options[]" required><br>
        <input type="text" name="options[]" required><br>
        <input type="text" name="options[]" required><br>
        <input type="text" name="options[]" required><br><br>

        <input type="submit" value="Criar Pergunta">
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
