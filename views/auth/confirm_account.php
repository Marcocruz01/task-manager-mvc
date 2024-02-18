<div style="height: 100vh;">
    <!-- Contenido de referencia a formulario-->
    <div class="contenedor-sm h-100 container-auth d-flex align-items-center">
        <div class="container-auth__form shadow-sm rounded-3 border border-ligth-subtle">
            <!-- Formulario  -->
            <form id="form">
                <div class="d-flex justify-content-center align-item-center">
                    <div class="d-flex row gap-2 justify-content-center">
                        <h1 class="fs-1 text-center text-secondary-emphasis fw-bold mb-0">Confirmation of your account</h1>
                    </div>
                </div>
                <?php require_once __DIR__ . '/../templates/alerts.php'; ?>
                <div class="d-grid">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-dark fs-4 py-3 px-5 text-uppercase btn-login" id="btn-login" type="submit">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $script = '<script src="/build/js/loader.js"></script>'; ?>