<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM alunos");
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($alunos);
?>