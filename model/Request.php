<?php
require_once '/xampp/htdocs/gestao-solicitacoes/config/database.php';

class RequestModel {
    public function all() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM requests');
        return $stmt->fetchAll();
    }

    public function create($data) {
        global $pdo;
        $stmt = $pdo->prepare('INSERT INTO requests (service_type, description, address, lat, lng) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([$data['service_type'], $data['description'], $data['address'], $data['lat'], $data['lng']]);
    }

    public function updateStatus($id, $status) {
        global $pdo;
        
        if ($status === 'concluído') {
            $stmt = $pdo->prepare('UPDATE requests SET status = ?, closed_at = NOW() WHERE id = ?');
        } else {
            $stmt = $pdo->prepare('UPDATE requests SET status = ? WHERE id = ?');
        }
        
        return $stmt->execute([$status, $id]);
    }

    public function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare('DELETE FROM requests WHERE id = ?');
        return $stmt->execute([$id]);
    }
    
    // tempo medio de resposta por tipo de serviço
    public function getAverageResponseTimeByServiceType() {
        global $pdo;
        $stmt = $pdo->query('
            SELECT service_type, 
                   AVG(DATEDIFF(closed_at, created_at)) as average_response_time 
            FROM requests 
            WHERE status = "concluído"
            GROUP BY service_type
        ');
        return $stmt->fetchAll();
    }
    
    // solicitacoes por tipo de servico
    public function getRequestsByServiceType() {
        global $pdo;
        $stmt = $pdo->query('SELECT service_type, COUNT(*) as total FROM requests GROUP BY service_type');
        return $stmt->fetchAll();
    }
    
}
?>
