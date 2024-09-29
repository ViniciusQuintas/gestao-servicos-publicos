<?php
session_start();
require_once '/xampp/htdocs/gestao-solicitacoes/controllers/RequestController.php';
require_once '/xampp/htdocs/gestao-solicitacoes/controllers/AuthController.php';

if (!isset($_SESSION['logged_in'])) {
    $action = 'login'; 
} else {
    $action = $_GET['action'] ?? ($_SESSION['role'] === 'admin' ? 'admin' : 'user');
}


switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new RequestController();
            $controller->store($_POST);
            header('Location: index.php?action=user');
            exit;
        } 
        
        header('Location: index.php?action=user');
        break;
    
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new RequestController();
            $controller->updateStatus($_GET['id'], $_POST['status']);
            header('Location: index.php?action=admin');
            exit;
        }
        break;
    
    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new RequestController();
            $controller->delete($_GET['id']);
            header('Location: index.php?action=admin');
            exit;
        }
        break;
        
    case 'admin':
        $controller = new RequestController();
        $requests = $controller->index();
        include '../views/requests/admin.php';
        break;
        
    case 'user':
        $controller = new RequestController();
        $requests = $controller->index();
        include '../views/requests/user.php';
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new AuthController();
            if ($auth->login($_POST['username'], $_POST['password'])) {
                if ($_SESSION['role'] === 'admin') {
                    header('Location: index.php?action=admin');
                } else {
                    header('Location: index.php?action=user');
                }
            } else {
                $_SESSION['login_error'] = 'Login falhou. Verifique suas credenciais.';
                include '../views/auth/login.php'; 
            }
        } else {
            include '../views/auth/login.php';
        }
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        header('Location: index.php?action=login');
        exit;
        break;

    default:
        header('Location: index.php?action=login');
        exit;
        break;
}
?>
