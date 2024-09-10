<?php
$msg = "";
$disciplinas = [];
$file = "disciplinas.txt";

// Função para carregar disciplinas do arquivo
function carregarDisciplinas($file) {
    $disciplinas = [];
    if (file_exists($file)) {
        $arqDisc = fopen($file, "r") or die("Erro ao abrir arquivo.");
        fgets($arqDisc); // Pular cabeçalho
        while (($linha = fgets($arqDisc)) !== false) {
            $disciplinas[] = explode(";", trim($linha));
        }
        fclose($arqDisc);
    }
    return $disciplinas;
}

// Função para salvar disciplinas no arquivo
function salvarDisciplinas($file, $disciplinas) {
    $arqDisc = fopen($file, "w") or die("Erro ao abrir arquivo.");
    fwrite($arqDisc, "nome;sigla;carga\n");
    foreach ($disciplinas as $disciplina) {
        fwrite($arqDisc, implode(";", $disciplina) . "\n");
    }
    fclose($arqDisc);
}

// Processar o formulário de inclusão
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = isset($_POST["nome"]) ? htmlspecialchars(trim($_POST["nome"])) : '';
    $sigla = isset($_POST["sigla"]) ? htmlspecialchars(trim($_POST["sigla"])) : '';
    $carga = isset($_POST["carga"]) ? htmlspecialchars(trim($_POST["carga"])) : '';
    $acao = isset($_POST["acao"]) ? htmlspecialchars(trim($_POST["acao"])) : '';
    $index = isset($_POST["index"]) ? intval($_POST["index"]) : -1;

    $disciplinas = carregarDisciplinas($file);

    if ($acao == 'incluir') {
        if (empty($nome) || empty($sigla) || empty($carga)) {
            $msg = "Todos os campos devem ser preenchidos.";
        } else {
            $disciplinas[] = [$nome, $sigla, $carga];
            salvarDisciplinas($file, $disciplinas);
            $msg = "Disciplina adicionada com sucesso!";
        }
    } elseif ($acao == 'alterar') {
        if ($index >= 0 && $index < count($disciplinas)) {
            $disciplinas[$index] = [$nome, $sigla, $carga];
            salvarDisciplinas($file, $disciplinas);
            $msg = "Disciplina alterada com sucesso!";
        } else {
            $msg = "Índice inválido para alteração.";
        }
    } elseif ($acao == 'excluir') {
        if ($index >= 0 && $index < count($disciplinas)) {
            array_splice($disciplinas, $index, 1);
            salvarDisciplinas($file, $disciplinas);
            $msg = "Disciplina excluída com sucesso!";
        } else {
            $msg = "Índice inválido para exclusão.";
        }
    } elseif ($acao == 'listar') {
        // Listar uma disciplina específica
        $buscarNome = isset($_POST["buscar_nome"]) ? htmlspecialchars(trim($_POST["buscar_nome"])) : '';
        $buscarSigla = isset($_POST["buscar_sigla"]) ? htmlspecialchars(trim($_POST["buscar_sigla"])) : '';
        if ($buscarNome || $buscarSigla) {
            $disciplinaEncontrada = null;
            foreach ($disciplinas as $disciplina) {
                if ($disciplina[0] == $buscarNome || $disciplina[1] == $buscarSigla) {
                    $disciplinaEncontrada = $disciplina;
                    break;
                }
            }
            if ($disciplinaEncontrada) {
                $msg = "Disciplina encontrada: Nome: {$disciplinaEncontrada[0]}, Sigla: {$disciplinaEncontrada[1]}, Carga Horária: {$disciplinaEncontrada[2]}";
            } else {
                $msg = "Disciplina não encontrada.";
            }
        }
    }
}

// Carregar disciplinas do arquivo
$disciplinas = carregarDisciplinas($file);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Disciplinas</title>
    <style>
        /* Estilos como antes */
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Gerenciar Disciplinas</h1>
            <form action="" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                
                <label for="sigla">Sigla:</label>
                <input type="text" id="sigla" name="sigla" required>
                
                <label for="carga">Carga Horária:</label>
                <input type="text" id="carga" name="carga" required>
                
                <input type="hidden" name="acao" value="incluir">
                <input type="submit" value="Adicionar Disciplina">
            </form>
            
            <!-- Formulário para listar uma disciplina -->
            <form action="" method="POST">
                <h2>Buscar Disciplina</h2>
                <label for="buscar_nome">Nome:</label>
                <input type="text" id="buscar_nome" name="buscar_nome">
                
                <label for="buscar_sigla">Sigla:</label>
                <input type="text" id="buscar_sigla" name="buscar_sigla">
                
                <input type="hidden" name="acao" value="listar">
                <input type="submit" value="Buscar Disciplina">
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
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($disciplinas as $index => $disciplina) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($disciplina[0]); ?></td>
                                <td><?php echo htmlspecialchars($disciplina[1]); ?></td>
                                <td><?php echo htmlspecialchars($disciplina[2]); ?></td>
                                <td>
                                    <!-- Formulário para alterar e excluir -->
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <input type="hidden" name="nome" value="<?php echo htmlspecialchars($disciplina[0]); ?>">
                                        <input type="hidden" name="sigla" value="<?php echo htmlspecialchars($disciplina[1]); ?>">
                                        <input type="hidden" name="carga" value="<?php echo htmlspecialchars($disciplina[2]); ?>">
                                        <input type="hidden" name="acao" value="alterar">
                                        <input type="submit" value="Alterar">
                                    </form>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <input type="hidden" name="acao" value="excluir">
                                        <input type="submit" value="Excluir" onclick="return confirm('Tem certeza que deseja excluir?');">
                                    </form>
                                </td>
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
