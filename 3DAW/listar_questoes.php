<?php
$questions = file('questions.txt');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Listar Perguntas</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Lista de Perguntas</h1>
    <ul>
        <?php foreach ($questions as $index => $line): ?>
            <?php list($question, $options) = explode('|', trim($line)); ?>
            <li>
                <?php echo $question; ?> 
                <a href="ver.php?index=<?php echo $index; ?>">Ver</a>
                <a href="editar.php?index=<?php echo $index; ?>">Editar</a>
                <a href="excluir.php?index=<?php echo $index; ?>">Excluir</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php">Voltar</a>
</body>
</html>
