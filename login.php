<?php
session_start();
require_once("conexao.php");

$mensagem = "";

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = $pdo->prepare(
        "SELECT * FROM usuarios WHERE email = ?"
    );
     
    $sql->execute([$email]);
    $usuario = $sql->fetch();
   
    if($usuario){
        if(password_verify($senha, $usuario["senha"])){
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nome"] = $usuario["nome"];
            $_SESSION["cargo"] = $usuario["cargo"];

            if($usuario["cargo"] == "Administrador"){
                header("Location:index.php");
            }else{
                header("Location:index.php");
            }
            exit;
        } else{
            $mensagem = "Senha Incorreta.";
        }
    } else {
        $mensagem = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - HQ Mania</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="formulario login">
        <h1>LOGIN</h1>

        <?php if ($mensagem != "") { ?>
            <p class="mensagem">
                <?= $mensagem ?>
            </p>

        <?php } ?>

        <form method="POST">

            <label>E-mail</label>
            <input type="email" name="email" required placeholder="exemplo@dominio.com" >

            <label>Senha</label>
            <input type="password" name="senha" required >

            <button type="submit">
                ENTRAR
            </button>

        </form>

        <p>
            Ainda não tem uma conta?

            <a href="cadastro.php">
                Cadastre-se
            </a>
        </p>

    </div>

</body>

</html>