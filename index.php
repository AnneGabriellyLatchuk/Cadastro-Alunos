<?php

session_start(); 
require_once 'Aluno.php'; 
require_once 'CadastroAlunos.php'; 
require_once 'Usuario.php'; 

// verifica se foi enviado o formulário

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (Usuario::autenticar($username, $password)) {
        $_SESSION['loggedin'] = true; // Define como logada
        $_SESSION['username'] = $username; // armazena o nome de usuário 
    } else {
        $loginError = "Usuário ou senha inválidos.";
    }
}

// verifica se usuário deseja sair

if (isset($_GET['logout'])) {
    session_destroy(); 
    header("Location: index.php"); // retorna para a página de login
    exit;
}

// verifica se o usuário está logado

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (isset($loginError)) echo "<p>$loginError</p>"; ?> 
        <form method="post">
            Usuário: <input type="text" name="username" required><br>
            Senha: <input type="password" name="password" required><br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>
</html>
<?php
    exit; // bloqueia restante do código se usuário não estiver logado
}

$cadastro = new CadastroAlunos(); 
$cadastro->carregarAlunos(); 

// verifica envio do formulário usuário

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $curso = $_POST['curso'];

    $aluno = new Aluno($nome, $matricula, $curso); 
    $cadastro->cadastrarAluno($aluno); 
}

// verifica envio de formulário para remover aluno

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remover'])) {
    $matricula = $_POST['matricula'];
    $cadastro->removerAluno($matricula); 
}

$alunos = $cadastro->listarAlunos(); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Alunos</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Cadastro de Alunos</h1>
    <a href="index.php?logout=true">Logout</a>
    <form method="post">
        Nome: <input type="text" name="nome" required><br>
        Matrícula: <input type="text" name="matricula" required><br>
        Curso: <input type="text" name="curso" required><br>
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>
    <h2>Lista de Alunos</h2>
    <ul>
        <?php foreach ($alunos as $aluno): ?>
            <li>
                <?php echo $aluno->getNome() . ' - ' . $aluno->getMatricula() . ' - ' . $aluno->getCurso(); ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="matricula" value="<?php echo $aluno->getMatricula(); ?>">
                    <input type="submit" name="remover" value="Remover">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>