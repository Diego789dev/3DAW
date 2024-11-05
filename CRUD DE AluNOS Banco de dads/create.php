<?php
// create.php
include 'db.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$idade = $_POST['idade'];

$stmt = $pdo->prepare("INSERT INTO alunos (nome, email, idade) VALUES (?, ?, ?)");
$stmt->execute([$nome, $email, $idade]);

echo "Aluno adicionado com sucesso!";
?>
