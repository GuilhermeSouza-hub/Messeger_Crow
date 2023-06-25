<?php

    $filter = ['<', '>', '/', '\\', '"', "'", '`', '#', '&', '|', ' '];
    $erro_de_usuario = false;
    $erro_do_ip_existente = false;


    if (isset($_POST['usuario'])) {
        $variavel = str_split($_POST['usuario']);
        $contador = 0;


        while ($contador <= strlen($_POST['usuario'])) {
            foreach ($filter as $char) {
                foreach ($variavel as $adr => $letra) {
                    if ($letra == $char) {
                        header("Location: signup.html");
                        die();
                        break;
                    } else {
                        $contador++;
                    }
                }
            }
        }






        $nick = $_POST['usuario'];
        $passwd = hash("md5", $_POST['senha']);
        $sec_passwd = hash("md5", $_POST['senhasg']);

        #DML
        $host = 'localhost'; //Alterar host no lançamento
        $user = 'DQL_signup';
        $pass = 'e#qZ!iY93mNq5CfD';
        $db = 'MCdb';
        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];



        $link = mysqli_connect($host, $user, $pass, $db);

        if ($link == false) {
            error_log("Algum erro na conexao com o servidor");
            header("Location: PAGINA_500"); // ERRO 500
            die();
        } else {
            if (mysqli_num_rows(mysqli_query($link, "SELECT nick from Cuser WHERE nick='$nick';")) > 0) {
                $erro_de_usuario = true;

            } elseif (mysqli_num_rows(mysqli_query($link, "SELECT nick from Cuser WHERE user_ip='$ip';")) > 0) {
                $erro_do_ip_existente = true;

            } else {
                mysqli_query($link, "INSERT INTO Cuser (nick, passwd, sec_passwd, date, user_ip) VALUES('$nick', '$passwd', '$sec_passwd', '$date', '$ip');");
                header("Location: index.php");
                die();
            }
        }

        mysqli_close($link);

    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="signup.css" />
    <script src="signup.js"></script>
    <title>Signup - MessCrow</title>
</head>

<body>
    <h1 id="title">Registrar-se</h1>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post" autocomplete="off" id="form">
        <div class="hole_div">
            <div class="label_div">
                <label for="usuario" class="label">Usuário</label>
            </div>

            <div class="input_div">
                <input type="text" name="usuario" id="usuario" class="input" onchange="checkAll()" required>
            </div>
        </div>
        <?=($erro_de_usuario) ? '<span class="error_mes" id="usr">Nome de usuário já me uso</span>':'' ?>

        <div class="hole_div">
            <div class="label_div">
                <label for="senha" class="label">Senha</label>
            </div>

            <div class="input_div">
                <input type="password" name="senha" id="senha" class="input" onchange="checkAll()" required>
            </div>
        </div>

        <div class="hole_div" id="senhasg_div">
            <div class="label_div">
                <label for="senhasg" class="label">Senha Segura</label>
            </div>

            <div class="input_div">
                <input type="password" name="senhasg" id="senhasg" class="input" onchange="checkAll()" required>
            </div>

            <div id="diamond"></div>

            <div>
                <button type="button" id="info" onclick="openInfoSS()">?</button>
            </div>
        </div>
        <?=($erro_do_ip_existente) ? '<span class="error_mes" id="spsw">Não foi possível finalizar com o registro </span>':''?>

        <div id="submit">
            <button type="button" class="button_base" id="submitbutton" onclick="trySubmit()">Entrar</button>
        </div>
    </form>
    <h4 id="hint">Já tem uma conta?<br><a id="slink" href="index.php">Entre!</a></h4>

    <div class="popup" id="wcome_pup">
        <div class="info_space">
            <div class="popup_text" id="wcome_title_1">Bem-vindo ao</div>
            <div class="popup_text" id="wcome_title_2">MessengerCrow!</div>
            <div class="popup_text" id="wcome_text">Este site presa principalmente pela liberdade de expressão e
                privacidade de seus usuários de uma forma única. Tudo feito com muita dedicação e comprometimento!</div>
            <button type="button" class="button_base" id="wcome_button" onclick="closeWcome()">Ok</button>
        </div>
    </div>

    <div class="popup" id="info_pup">
        <div class="info_space" id="iinfo_space">
            <div class="popup_text" id="info_text">A “senha de segurança” tem a intenção de proteger seus dados. Ao
                coloca-la para entrar no site todas as suas conversas serão apagadas e a “senha normal” e a “senha de
                segurança” serão trocadas uma pela outra. Estas medidas servem para que suas conversas estejam sempre
                protegidas e que seja indistinguível se você entrou com a “senha normal” ou com a “senha de segurança”.
            </div>
            <button type="button" class="button_base" id="info_button" onclick="closeInfoSS()">Ok</button>
        </div>
    </div>

    <div class="popup" id="error_pup">
        <div class="info_space">
            <div class="popup_text" id="error_text">Nossos corvos não conhecem este método de envio.</div>
            <button type="button" class="button_base" id="error_button" onclick="closeErrorPup()">Ok</button>
        </div>
    </div>
</body>

</html>