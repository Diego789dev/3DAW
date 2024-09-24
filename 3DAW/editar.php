<?php
$index = $_GET['index'];
$questions = file('questions.txt');
$line = $questions[$index];
list($question, $options) = explode('|', trim($line));
$options = explode(',', $options);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $options = $_POST['options'];

    $questions[$index] = "$question|".implode(',', $options)."\n";
    file_put_contents('questions.txt', $questions);
    
    echo "Pergunta editada com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Pergunta</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Editar Pergunta de Múltipla Escolha</h1>
    <form method="POST">
        <label>Pergunta:</label><br>
        <input type="text" name="question" value="<?php echo $question; ?>" required><br><br>
        
        <label>Opções (separadas por vírgula):</label><br>
        <?php foreach ($options as $option): ?>
            <input type="text" name="options[]" value="<?php echo $option; ?>" required><br>
        <?php endforeach; ?><br>

        <input type="submit" value="Editar Pergunta">
    </form>
    <a href="listar_questoes.php">Voltar</a>
</body>
</html>
