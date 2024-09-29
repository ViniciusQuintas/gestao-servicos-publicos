<?php
require_once '/xampp/htdocs/gestao-solicitacoes/config/database.php';

class UserModel {
    public function findByUsername($username) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        return $stmt->fetch();
    }
}
?>
