<?php
    // $msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];
    $msg = "";
    echo "nome: " . $nome . " sigla: " . " carga: " . $carga;
   if (!file_exists("disciplinas.txt")) {
       $arqDisc = fopen("disciplinas.txt","w") or die("erro ao criar arquivo");
       $linha = "nome;sigla;carga\n";
       fwrite($arqDisc,$linha);
       fclose($arqDisc);
   }
   $arqDisc = fopen("disciplinas.txt","a") or die("erro ao criar arquivo");
 //   $arqDisc = fopen("disciplinas.txt","w") or die("erro ao criar arquivo");
     $linha = "nome;sigla;carga\n";
    $linha = $nome . ";" . $sigla . ";" . $carga . "\n";
    fwrite($arqDisc,$linha);
    fclose($arqDisc);
    $msg = "Deu tudo certo!!!";
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Criar Nova Disciplina</h1>
<form action="ex03_IncluirDisciplina.php" method="POST">
    Nome: <input type="text" name="nome">
    <br><br>
    Sigla: <input type="text" name="sigla">
    <br><br>
    Carga Horaria: <input type="text" name="carga">
    <br><br>
    <input type="submit" value="Criar Nova Disciplina">
</form>
<p><?php echo $msg ?></p>
<br>
</body>
</html>