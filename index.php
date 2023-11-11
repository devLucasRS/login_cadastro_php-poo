<?php
ob_start();

ini_set('display_errors', 1);
date_default_timezone_set('America/Sao_Paulo');

require_once('lib/class-user.php');

$user = new User();

// Mensagem de debug para verificar se o usuário está logado
//echo "User logged in: " . ($user->_logged_in ? 'true' : 'false');

if ($user->_logged_in) {
    includePage('dashboard', $user);
} else {
    if (isset($_GET['url'])) {
        $url = explode('/', $_GET['url']);
        $page = $url[0];

        switch ($page) {
            case 'register':
                includePage('register', $user);
                break;

            case 'logout':
                $user->sign_out();
                break;

            default:
                // Página de erro ou ação adequada para URLs desconhecidas
                break;
        }
    } else {
        includePage('index', $user);
    }
}

function includePage($pageName, $user) {
    //echo "Including $pageName page."; // Mensagem de debug
    include "lib/pages/$pageName.php";
}
?>
