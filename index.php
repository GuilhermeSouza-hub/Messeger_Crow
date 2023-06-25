<?php
        $filter = ['<', '>', '/', '\\', '"', "'", '`', '#', '&', '|', ' '];
        $error_usuario = false;



        if (isset($_POST['usuario'])) {
            $variavel = str_split($_POST['usuario']);
            $contador = 0;

            while ($contador <= strlen($_POST['usuario'])) {
                foreach ($filter as $char) {
                    foreach ($variavel as $adr => $letra) {
                        if ($letra == $char) {
                            header("Location: index.php");
                            die();
                        } else {
                            $contador++;
                        }
                    }
                }
            }
        

        $nick = $_POST['usuario'];
        $senha = hash('md5', $_POST['senha']);

        #DQL
        $host = 'localhost'; //Alterar host no lançamento
        $user = 'DML_login';
        $pass = '^rQ$vUK$vpS6ezuj';
        $db = 'MCdb';
        

        $link = mysqli_connect($host, $user, $pass, $db);

        if ($link == false) {
            error_log("Algum erro na conexao com o servidor");
            header("Location: PAGINA_500"); // ERRO 500
            die();
        } else {
            if (mysqli_num_rows(mysqli_query($link, "SELECT nick from Cuser WHERE nick='$nick' and sec_passwd='$senha';")) == 1) {
                mysqli_close($link);
                header("Locationd: PAGINA_LIMPA");//Onde a pagina do usuario estara com as mensagens apagadas
                die();
            } elseif (mysqli_num_rows(mysqli_query($link, "SELECT nick from Cuser WHERE nick='$nick' and passwd='$senha';")) == 1) {
                mysqli_close($link);
                header("Location: PAGINA_DE_USUARIO");
                die();
            } else {
                $error_usuario = true;
                mysqli_close($link);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="login.css" />
    <script src="login.js"></script>
    <title>Login - MessCrow</title>
</head>

<body>
    <h1 id="title">Entrar</h1>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post" autocomplete="off" id="form">
        <div class="hole_div" id="usuario_div">
            <div class="label_div">
                <label for="usuario" class="label">Usuário</label>
            </div>

            <div class="input_div">
                <input type="text" name="usuario" id="usuario" class="input" onchange="checkAll()" required>
                
            </div>
        </div>

        <div class="hole_div" id="senha_div">
            <div class="label_div">
                <label for="senha" class="label">Senha</label>
            </div>

            <div class="input_div">
                <input type="password" name="senha" id="senha" class="input" onchange="checkAll()" required>
            </div>
        </div>
        <?=($error_usuario) ? '<span class="error_mes" id="usr">Nossos corvos não conhecem esse contato(Usuário e/ou senha inválida)</span>':'' ?>
        <div id="submit">
            <button type="button" class="button_base" id="submitbutton" onclick="trySubmit()">Entrar</button>
        </div>
    </form>
    <h4 id="hint">Ainda não tem uma conta?<br><a id="slink" href="signup.php">Registre-se!</a></h4>

    <div class="popup" id="error_pup">
        <div class="info_space">
            <div class="popup_text" id="error_text">Nossos corvos não conhecem este método de envio.</div>
            <button type="button" class="button_base" id="error_button" onclick="closeErrorPup()">Ok</button>
        </div>
    </div>
</body>

</html>