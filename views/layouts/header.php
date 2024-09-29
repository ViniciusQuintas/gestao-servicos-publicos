<header class="bg-dark text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <h1 class="h4">Gestão de Solicitações</h1>
            <?php elseif ($_SESSION['role'] === 'user'): ?>
                <h1 class="h4">Solicitações de Serviços Públicos</h1>
            <?php endif; ?>
        </div>
        <nav class="d-flex align-items-center">
            <a href="/gestao-solicitacoes/public/index.php?action=logout" class="text-white text-decoration-none">
                Sair <i class="bi bi-box-arrow-right"></i>
            </a>
        </nav>
    </div>
</header>