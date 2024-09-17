<?php
$msg = "";
$alunos = [];
$file = "alunos.txt";

// Função para carregar alunos do arquivo
function carregarAlunos($file) {
    $alunos = [];
    if (file_exists($file)) {
        $arqAluno = fopen($file, "r") or die("Erro ao abrir arquivo.");
        fgets($arqAluno); // Pular cabeçalho
        while (($linha = fgets($arqAluno)) !== false) {
            $alunos[] = explode(";", trim($linha));
        }
        fclose($arqAluno);
    }
    return $alunos;
}

// Função para salvar alunos no arquivo
function salvarAlunos($file, $alunos) {
    $arqAluno = fopen($file, "w") or die("Erro ao abrir arquivo.");
    fwrite($arqAluno, "nome;cpf;matricula;data_nascimento\n");
    foreach ($alunos as $aluno) {
        fwrite($arqAluno, implode(";", $aluno) . "\n");
    }
    fclose($arqAluno);
}

// Processar o formulário de inclusão
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = isset($_POST["nome"]) ? htmlspecialchars(trim($_POST["nome"])) : '';
    $cpf = isset($_POST["cpf"]) ? htmlspecialchars(trim($_POST["cpf"])) : '';
    $matricula = isset($_POST["matricula"]) ? htmlspecialchars(trim($_POST["matricula"])) : '';
    $data_nascimento = isset($_POST["data_nascimento"]) ? htmlspecialchars(trim($_POST["data_nascimento"])) : '';
    $acao = isset($_POST["acao"]) ? htmlspecialchars(trim($_POST["acao"])) : '';
    $index = isset($_POST["index"]) ? intval($_POST["index"]) : -1;

    $alunos = carregarAlunos($file);

    if ($acao == 'incluir') {
        if (empty($nome) || empty($cpf) || empty($matricula) || empty($data_nascimento)) {
            $msg = "Todos os campos devem ser preenchidos.";
        } else {
            $alunos[] = [$nome, $cpf, $matricula, $data_nascimento];
            salvarAlunos($file, $alunos);
            $msg = "Aluno adicionado com sucesso!";
        }
    } elseif ($acao == 'alterar') {
        if ($index >= 0 && $index < count($alunos)) {
            $alunos[$index] = [$nome, $cpf, $matricula, $data_nascimento];
            salvarAlunos($file, $alunos);
            $msg = "Aluno alterado com sucesso!";
        } else {
            $msg = "Índice inválido para alteração.";
        }
    } elseif ($acao == 'excluir') {
        if ($index >= 0 && $index < count($alunos)) {
            array_splice($alunos, $index, 1);
            salvarAlunos($file, $alunos);
            $msg = "Aluno excluído com sucesso!";
        } else {
            $msg = "Índice inválido para exclusão.";
        }
    } elseif ($acao == 'listar') {
        // Listar um aluno específico
        $buscarNome = isset($_POST["buscar_nome"]) ? htmlspecialchars(trim($_POST["buscar_nome"])) : '';
        $buscarMatricula = isset($_POST["buscar_matricula"]) ? htmlspecialchars(trim($_POST["buscar_matricula"])) : '';
        if ($buscarNome || $buscarMatricula) {
            $alunoEncontrado = null;
            foreach ($alunos as $aluno) {
                if ($aluno[0] == $buscarNome || $aluno[2] == $buscarMatricula) {
                    $alunoEncontrado = $aluno;
                    break;
                }
            }
            if ($alunoEncontrado) {
                $msg = "Aluno encontrado: Nome: {$alunoEncontrado[0]}, CPF: {$alunoEncontrado[1]}, Matrícula: {$alunoEncontrado[2]}, Data de Nascimento: {$alunoEncontrado[3]}";
            } else {
                $msg = "Aluno não encontrado.";
            }
        }
    }
}

// Carregar alunos do arquivo
$alunos = carregarAlunos($file);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Alunos</title>
    <style>
        /* Adicione seus estilos aqui */
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Gerenciar Alunos</h1>
            <form action="" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required>
                
                <label for="matricula">Matrícula:</label>
                <input type="text" id="matricula" name="matricula" required>
                
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" required>
                
                <input type="hidden" name="acao" value="incluir">
                <input type="submit" value="Adicionar Aluno">
            </form>
            
            <!-- Formulário para listar um aluno -->
            <form action="" method="POST">
                <h2>Buscar Aluno</h2>
                <label for="buscar_nome">Nome:</label>
                <input type="text" id="buscar_nome" name="buscar_nome">
                
                <label for="buscar_matricula">Matrícula:</label>
                <input type="text" id="buscar_matricula" name="buscar_matricula">
                
                <input type="hidden" name="acao" value="listar">
                <input type="submit" value="Buscar Aluno">
            </form>
            
            <p id="message" class="<?php echo !empty($msg) && strpos($msg, 'sucesso') !== false ? '' : 'error'; ?>"><?php echo $msg; ?></p>
        </div>
        
        <div class="list-container">
            <h2>Alunos Cadastrados</h2>
            <?php if (!empty($alunos)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Matrícula</th>
                            <th>Data de Nascimento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $index => $aluno) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($aluno[0]); ?></td>
                                <td><?php echo htmlspecialchars($aluno[1]); ?></td>
                                <td><?php echo htmlspecialchars($aluno[2]); ?></td>
                                <td><?php echo htmlspecialchars($aluno[3]); ?></td>
                                <td>
                                    <!-- Formulário para alterar e excluir -->
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                                        <input type="hidden" name="nome" value="<?php echo htmlspecialchars($aluno[0]); ?>">
                                        <input type="hidden" name="cpf" value="<?php echo htmlspecialchars($aluno[1]); ?>">
                                        <input type="hidden" name="matricula" value="<?php echo htmlspecialchars($aluno[2]); ?>">
                                        <input type="hidden" name="data_nascimento" value="<?php echo htmlspecialchars($aluno[3]); ?>">
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
                <p>Não há alunos cadastrados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
