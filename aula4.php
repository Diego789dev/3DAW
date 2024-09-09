<?php
$msg = ""; 
$disciplinas = []; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = isset($_POST["nome"]) ? htmlspecialchars(trim($_POST["nome"])) : '';
    $sigla = isset($_POST["sigla"]) ? htmlspecialchars(trim($_POST["sigla"])) : '';
    $carga = isset($_POST["carga"]) ? htmlspecialchars(trim($_POST["carga"])) : '';
    
    if (empty($nome) || empty($sigla) || empty($carga)) {
        $msg = "Todos os campos devem ser preenchidos.";
    } else {
       
        $file = "disciplinas.txt";
        
       
        if (!file_exists($file)) {
            $arqDisc = fopen($file, "w") or die("Erro ao criar arquivo.");
            $linha = "nome;sigla;carga\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);
        }

        $arqDisc = fopen($file, "a") or die("Erro ao abrir arquivo.");
        $linha = $nome . ";" . $sigla . ";" . $carga . "\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);

        $msg = "Disciplina adicionada com sucesso!";
    }
}

if (file_exists("disciplinas.txt")) {
    $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo.");
    fgets($arqDisc);
    while (($linha = fgets($arqDisc)) !== false) {
        $disciplinas[] = explode(";", trim($linha));
    }
    fclose($arqDisc);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Disciplina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%;
            max-width: 1200px;
            display: flex;
            gap: 20px;
            
        }
        .form-container{
        border-right: 2px solid #333;
        }
        .form-container, .list-container {
            flex: 1;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        p {
            text-align: center;
            font-weight: bold;
            color: #4CAF50;
        }
        .error {
            color: #ff4c4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Criar Nova Disciplina</h1>
            <form action="" method="POST" onsubmit="clearMessage()">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                
                <label for="sigla">Sigla:</label>
                <input type="text" id="sigla" name="sigla" required>
                
                <label for="carga">Carga Horária:</label>
                <input type="text" id="carga" name="carga" required>
                
                <input type="submit" value="Criar Nova Disciplina">
            </form>
            <p id="message" class="<?php echo !empty($msg) && strpos($msg, 'sucesso') !== false ? '' : 'error'; ?>"><?php echo $msg; ?></p>
        </div>
        <div class="list-container">
            <h2>Disciplinas Cadastradas</h2>
            <?php if (!empty($disciplinas)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Sigla</th>
                            <th>Carga Horária</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($disciplinas as $disciplina) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($disciplina[0]); ?></td>
                                <td><?php echo htmlspecialchars($disciplina[1]); ?></td>
                                <td><?php echo htmlspecialchars($disciplina[2]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Não há disciplinas cadastradas.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
