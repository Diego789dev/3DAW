<?php
include 'db.php';

$id = $_POST['id'];

$stmt = $pdo->prepare("DELETE FROM alunos WHERE id = ?");
$stmt->execute([$id]);

echo "Aluno excluído com sucesso!";
?>
