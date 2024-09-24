<?php
$index = $_GET['index'];
$questions = file('questions.txt');
$line = $questions[$index];
list($question, $options) = explode('|', trim($line));
$options = explode(',', $options);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Pergunta</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1><?php echo $question; ?></h1>
    <ul>
        <?php foreach ($options as $option): ?>
            <li><?php echo $option; ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="listar_questoes.php">Voltar</a>
</body>
</html>
