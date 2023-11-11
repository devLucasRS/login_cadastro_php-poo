<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Presença do objeto $user
$user = new stdClass();
$user->_logged_in = true;

if ($user->_logged_in) {
    //echo "logado";
} else {
    Header("../index.php"); //Manda o usuario para a home se nao estiver logado!
}
?>
<title>Nao acredito que deu certo</title>

<h1>alsdkals</h1>