<?php
require_once "/xampp/htdocs/gestao-solicitacoes/model/Request.php";
require_once '/xampp/htdocs/gestao-solicitacoes/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RequestController {
    public function index() {
        $requestModel = new RequestModel();
        return $requestModel->all();
    }

    public function store($data) {
        $requestModel = new RequestModel();
        $result = $requestModel->create($data);
        
        if ($result) {
            $toEmail = $_ENV['SMPT_EMAIL_RECIPIENT'];  
            $subject = 'Solicitação Criada com Sucesso';
            $body = 'Sua solicitação de serviço "' . $data['service_type'] . '" foi criada com sucesso. O estado atual é "pendente".';

            $this->sendEmailNotification($toEmail, $subject, $body);
        }
            
        return $result; 
    }

    public function updateStatus($id, $status) {
        $requestModel = new RequestModel();
        $result = $requestModel->updateStatus($id, $status);
        
        if ($result) {
            $request = $this->getRequestById($id);
            $toEmail = $_ENV['SMPT_EMAIL_RECIPIENT'];  
            $subject = 'Atualização de Status da Solicitação';
            $body = 'O status da sua solicitação de serviço "' . $request['service_type'] . '" foi atualizado para "' . $status . '".';

            $this->sendEmailNotification($toEmail, $subject, $body);
        }
        
        return $result;
    }
    
    // gera o relatorioo de tempo médio de resposta por tipo de servico
    public function getAverageResponseTimeReport() {
        $requestModel = new RequestModel();
        return $requestModel->getAverageResponseTimeByServiceType();
    }
    
    // gera o relatorioo de solicitacoes por tipo de servic
    public function getRequestsByServiceType() {
        $requestModel = new RequestModel();
        return $requestModel->getRequestsByServiceType();
    }

    public function delete($id) {
        $requestModel = new RequestModel();
        return $requestModel->delete($id);
    }
    
    public function sendEmailNotification($toEmail, $subject, $body){
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST']; 
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USER']; 
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom($_ENV['SMTP_USER'], 'Sistema de Solicitações');
            $mail->addAddress($toEmail);
    
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
    
            $mail->send();
            echo 'E-mail enviado com sucesso!';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    }
    
    // busca a solicitacao por ID
    private function getRequestById($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM requests WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
}
?>
