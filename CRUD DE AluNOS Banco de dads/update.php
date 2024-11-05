<?php
// update.php
include 'db.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$idade = $_POST['idade'];

$stmt = $pdo->prepare("UPDATE alunos SET nome = ?, email = ?, idade = ? WHERE id = ?");
$stmt->execute([$nome, $email, $idade, $id]);

echo "Aluno atualizado com sucesso!";
?>
