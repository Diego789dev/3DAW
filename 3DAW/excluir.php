<?php
$index = $_GET['index'];
$questions = file('questions.txt');
unset($questions[$index]);
file_put_contents('questions.txt', $questions);

echo "Pergunta excluída com sucesso!";
echo "<br><a href='listar_questoes.php'>Voltar</a>";
?>
