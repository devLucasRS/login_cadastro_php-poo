<?php
header('Content-type: text/html; charset=utf-8');
setlocale(LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'Portuguese_Brazil');
date_default_timezone_set('America/Sao_Paulo');
$system_date = date("Y-m-d H:i:s");

define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'chamados');

// Create connection with SQL
$conn = new PDO("mysql:host=".DB_HOSTNAME.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);

// User Class
class User {
    public $_logged_in = false;
    public $_is_admin = false;

    private $_cookie_user_id = "c_user_id";
    private $_cookie_user_token = "c_user_token";

    private function _show_error_message($message) {
            echo '
            <div class="notification is-danger">
                <p>' . $message . '</p>
            </div>';
        }
    

    public function __construct() {
        global $conn;
        if (isset($_COOKIE['c_user_id']) && isset($_COOKIE['c_user_token'])) {
            $user_id = $_COOKIE['c_user_id'];
            $res = $conn->query("SELECT * FROM users WHERE user_id = '$user_id'");
            $row = $res->fetch(PDO::FETCH_OBJ);
            if ($res->rowCount() > 0) {
                $this->_logged_in = true;
            } else {
                echo 'USUARIO INVALIDO OR BANNED';
            }
        }
    }

    public function sign_up($user_login, $user_email, $user_name, $user_password) {
        global $conn;
        $user_key = md5($user_email);
        $password = sha1(md5($user_password));
        $system_date = date("Y-m-d H:i:s");

        $res = $conn->query("SELECT * FROM users WHERE user_login = '$user_login' OR user_email = '$user_email'");
        $row = $res->fetch(PDO::FETCH_OBJ);

        if ($res->rowCount() <= 0) {
            $stmt = $conn->prepare("INSERT INTO `users` (`user_id`, `user_key`, `user_login`, `user_email`, `user_name`, `user_password`, `user_token`, `user_create_data`, `user_last_login`, `user_coins`, `user_active`) 
            VALUES (NULL, '$user_key', '$user_login', '$user_email', '$user_name', '$password', '', '$system_date', '', '0', '0')");
            
            if ($stmt->execute()) {
                $this->_set_cookies($row->user_id, $remember);
                header("Location: ../");
            }
        } else {
            echo '
            <div class="notification is-danger">
                <p>Usuário ou email já usados!</p>
            </div>';
        }
    }

    public function sign_in($user_email, $password, $remember = false) {
        global $conn;
    
        $hashed_password = sha1(md5($password));
    
        $stmt = $conn->prepare("SELECT * FROM users WHERE (user_login = :user_email OR user_email = :user_email) AND user_password = :password");
        $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_OBJ);
    
        if ($user) {
            // Login successful
            $this->_set_cookies($user->user_id, $remember);
            header("Location: /dashboard.php");
            exit(); // Importante: encerre a execução após redirecionar
        } else {
            // Login failed
            $this->_show_error_message("Credenciais inválidas. Por favor, tente novamente.");
        }
    }
    



    public function sign_out() {
        global $conn, $system_date;
        session_destroy();
        $user_id = $_COOKIE[$this->_cookie_user_id];
        unset($_COOKIE[$this->_cookie_user_id]);
        unset($_COOKIE[$this->_cookie_user_token]);
        setcookie($this->_cookie_user_id, NULL, -1, '/');
        setcookie($this->_cookie_user_token, NULL, -1, '/');
        $conn->query("UPDATE users SET user_last_login = '$system_date' WHERE user_id = '$user_id'");
        header("Location: ../");
    }

    public function _set_cookies($user_id, $remember = false, $path = '/') {
        global $conn;

        $token = md5(time());
        $stmt = $conn->prepare("UPDATE users SET user_token = :token WHERE user_id = :user_id");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        if ($remember) {
            $expire = time() + 2592000; // 30 days
            setcookie($this->_cookie_user_id, $user_id, $expire, $path);
            setcookie($this->_cookie_user_token, $token, $expire, $path);
        } else {
            setcookie($this->_cookie_user_id, $user_id, 0, $path);
            setcookie($this->_cookie_user_token, $token, 0, $path);
        }
    }

    public function _getMyName() {
        global $conn;

        if (isset($_COOKIE['c_user_id']) && isset($_COOKIE['c_user_token'])) {
            $user_id = $_COOKIE['c_user_id'];
            $res = $conn->query("SELECT * FROM users WHERE user_id = '$user_id'");
            $row = $res->fetch(PDO::FETCH_OBJ);

            if ($res->rowCount() > 0) {
                $name = $row->user_name;
                echo $name;
            } else {
                echo '404';
            }
        } else {
            __('Not Logged');
        }
    }

    public function _getMyCoins() {
        global $conn;

        if (isset($_COOKIE['c_user_id']) && isset($_COOKIE['c_user_token'])) {
            $c_user_token = $_COOKIE['c_user_token'];
            $res = $conn->query("SELECT * FROM users WHERE user_token = '$c_user_token'");
            $row = $res->fetch(PDO::FETCH_OBJ);

            if ($res->rowCount() > 0 && isset($row->user_coins)) {
                $info = $row->user_coins;
                echo $info;
            }
        }
    }
}

   
