<?php
require_once "/xampp/htdocs/gestao-solicitacoes/model/UserModel.php";

class AuthController {
    public function login($username, $password) {
        $userModel = new UserModel();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }

    public function logout() {
        session_destroy();
        unset($_SESSION['logged_in']);
    }
}
?>
