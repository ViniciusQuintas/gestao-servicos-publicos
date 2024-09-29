<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .status-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .status-pendente { background-color: gray; }
        .status-andamento { background-color: orange; }
        .status-concluido { background-color: green; }
    </style>
</head>
<body>
    <?php include '/xampp/htdocs/gestao-solicitacoes/views/layouts/header.php'; ?>
    <main class="container">
        <h3 class="mb-4 mt-5">Solicitações:</h3>
        <table class="table table-light table-hover text-center">
            <thead>
                <tr>
                    <th>Tipo de serviço</th>
                    <th>Descrição</th>
                    <th>Endereço</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?= $request['service_type'] ?></td>
                    <td><?= $request['description'] ?></td>
                    <td><a href="https://www.google.com/maps/search/?api=1&query=<?= $request['lat'] ?>,<?= $request['lng'] ?>" target="_blank"><?= $request['address']; ?></a></td>
                    <td class="text-capitalize">
                        <?php
                            $statusClass = '';
                            switch ($request['status']) {
                                case 'pendente':
                                    $statusClass = 'status-pendente';
                                    break;
                                case 'em andamento':
                                    $statusClass = 'status-andamento';
                                    break;
                                case 'concluído':
                                    $statusClass = 'status-concluido';
                                    break;
                            }
                        ?>
                        <span class="status-dot <?= $statusClass ?>"></span>
                        <?= $request['status'] ?>
                    </td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $request['id'] ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $request['id'] ?>">
                            <i class="bi bi-trash"></i>
                        </button>                        
                    </td>
                </tr>

                <div class="modal fade" id="editModal<?= $request['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="index.php?action=edit&id=<?= $request['id'] ?>" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Editar Solicitação</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="status">Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="pendente" <?= $request['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                        <option value="em andamento" <?= $request['status'] === 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
                                        <option value="concluído" <?= $request['status'] === 'concluído' ? 'selected' : '' ?>>Concluído</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteModal<?= $request['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Excluir Solicitação</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Tem certeza de que deseja excluir esta solicitação?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="index.php?action=delete&id=<?= $request['id'] ?>" method="POST">
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h3 class="mb-4 mt-5">Relatórios:</h3>
        <div class="pb-5">
            <button class="btn btn-info text-white d-block mb-3" data-bs-toggle="modal" data-bs-target="#reportModalTime">
                Tempo médio de resposta por tipo de serviço <i class="bi bi-clock-history ms-2"></i>
            </button>
            <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#reportModalType">
                Solicitações por tipo de serviço <i class="bi bi-file-earmark-bar-graph ms-2"></i>
            </button>
        </div>
        
    </main>
    
    <div class="modal fade" id="reportModalTime" tabindex="-1" aria-labelledby="reportModalTimeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalTimeLabel">Relatório de tempo médio de resposta por tipo de serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        require_once "/xampp/htdocs/gestao-solicitacoes/controllers/RequestController.php";
                        
                        $controller = new RequestController();
                        $responseTimeReport = $controller->getAverageResponseTimeReport();
                    ?>
                    <table class="table table-light table-hover text-center">
                        <thead>
                            <tr>
                                <th>Tipo de Serviço</th>
                                <th>Tempo Médio de Resposta (dias)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($responseTimeReport as $row): ?>
                            <tr>
                                <td><?= $row['service_type'] ?></td>
                                <td><?= $row['average_response_time'] ? number_format($row['average_response_time'], 2) : 'N/A' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportModalType" tabindex="-1" aria-labelledby="reportModalTypeLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalTypeLabel">Relatório de solicitações por tipo de serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                        require_once "/xampp/htdocs/gestao-solicitacoes/controllers/RequestController.php";
                        
                        $controller = new RequestController();
                        $reportData = $controller->getRequestsByServiceType();
                    ?>
                    <table class="table table-light table-hover text-center">
                        <thead>
                            <tr>
                                <th>Tipo de Serviço</th>
                                <th>Número de Solicitações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData as $row): ?>
                            <tr>
                                <td><?= $row['service_type'] ?></td>
                                <td><?= $row['total'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
