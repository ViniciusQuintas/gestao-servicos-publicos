<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de Serviços</title>
    <link rel="stylesheet" href="/xampp/htdocs/gestao-solicitacoes/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
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
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include '/xampp/htdocs/gestao-solicitacoes/views/layouts/header.php'; ?>
    <?php 
        require_once '/xampp/htdocs/gestao-solicitacoes/vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../../');
        $dotenv->load();
        $apiKey = $_ENV['GOOGLE_MAPS_API_KEY'];
    ?>
    
    <main class="container">
        <div class="d-flex justify-content-between mt-5 align-items-center mb-4">
            <h3>Solicitações Enviadas:</h3>
                <!-- Botão para abrir o modal -->
            <button type="button" class="btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#novaSolicitacaoModal">
                Nova Solicitação
            </button>
        </div>
           
        <div class="modal fade" id="novaSolicitacaoModal" tabindex="-1" aria-labelledby="novaSolicitacaoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="novaSolicitacaoModalLabel">Nova Solicitação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <form action="/gestao-solicitacoes/public/index.php?action=create" method="POST">
                            <div class="mb-3">
                                <label for="service_type" class="form-label">Tipo de Serviço:</label>
                                <select class="form-control" id="service_type" name="service_type" required>
                                    <option value="" disabled selected>Selecione um serviço...</option>
                                    <option value="Reparo de Iluminação Pública">Reparo de Iluminação Pública</option>
                                    <option value="Coleta de Lixo">Coleta de Lixo</option>
                                    <option value="Limpeza de Praça">Limpeza de Praça</option>
                                    <option value="outro">Outro (digite abaixo)</option>
                                </select>
                                <input type="text" class="form-control mt-2" id="new_service" name="new_service" placeholder="Digite um novo serviço" style="display: none;">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição:</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                           <div class="mb-3">
                                <label for="address" class="form-label">Endereço:</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div id="map"></div>
                            <input type="hidden" id="lat" name="lat">
                            <input type="hidden" id="lng" name="lng">
                            
                            <button type="submit" class="btn btn-primary mt-4">Enviar Solicitação</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            
        <table class="table table-light table-hover text-center">
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Endereço</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= $request['service_type']; ?></td>
                        <td><?= $request['description']; ?></td>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    
    <script>
    const serviceSelect = document.getElementById('service_type');
    const newServiceInput = document.getElementById('new_service');

    serviceSelect.addEventListener('change', () => {
        if (serviceSelect.value === 'outro') {
            newServiceInput.style.display = 'block';
            newServiceInput.focus();
        } else {
            newServiceInput.style.display = 'none';
        }
    });

    let map, marker, geocoder;

    const initMap = () => {
        const defaultLocation = { lat: -20.728855, lng: -42.864969 };
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLocation,
            zoom: 13,
        });

        geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
        });

        google.maps.event.addListener(marker, 'dragend', (event) => {
            document.getElementById("lat").value = event.latLng.lat();
            document.getElementById("lng").value = event.latLng.lng();
            geocodeLatLng(event.latLng);
        });

        map.addListener('click', (event) => {
            placeMarker(event.latLng);
        });

        document.getElementById('address').addEventListener('blur', () => {
            const address = document.getElementById('address').value;
            geocodeAddress(address);
        });
    };

    window.initMap = initMap;

    const placeMarker = (location) => {
        marker.setPosition(location);
        map.panTo(location);
        document.getElementById("lat").value = location.lat();
        document.getElementById("lng").value = location.lng();
        geocodeLatLng(location);
    };

    const geocodeLatLng = (latlng) => {
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                    document.getElementById("address").value = results[0].formatted_address;
                } else {
                    alert("Nenhum resultado encontrado.");
                }
            } else {
                alert("Falha na geocodificação: ", status);
            }
        });
    };

    const geocodeAddress = (address) => {
        geocoder.geocode({ 'address': address }, (results, status) => {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);
                marker.setPosition(results[0].geometry.location);
                document.getElementById("lat").value = results[0].geometry.location.lat();
                document.getElementById("lng").value = results[0].geometry.location.lng();
            } else {
                alert('Endereço não encontrado: ', status);
            }
        });
    };

    const loadScript = (src) => {
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = src;
        document.body.appendChild(script);
    };

    window.onload = () => {
        const apiKey = "<?= $_ENV['GOOGLE_MAPS_API_KEY']; ?>";
        loadScript(`https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`);
    };
</script>

</body>
</html>