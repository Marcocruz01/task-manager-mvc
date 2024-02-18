<div style="height: 100vh;">
    <!-- Contenido de referencia a formulario-->
    <div class="contenedor-sm h-100 container-auth d-flex justify-content-center align-items-center">
        <!-- Contenedor donde van los circulos -->
        <div class="container-auth__pre-form p-3 position-relative d-flex justify-content-center align-items-center">
            <!-- Contenido Formulario  -->
            <div class="container-auth__form shadow z-1 rounded-3 border border-secondary-subtle">
                <!-- Formulario  -->
                <form method="POST">
                    <div class="d-flex flex-column my-3 gap-3">
                        <h1 class="fs-1 text-center text-secondary-emphasis fw-bold">Recover Password</h1>
                        <p class="fs-3 text-center text-secondary-emphasis">Do not worry if you forgot your password, here you can enter a new one and continue browsing the app.</p>
                    </div>
                    <div class="d-flex pt-3 g-4 row">
                        <div class="mb-3">
                            <label for="password" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Password</label>
                            <div class="container-auth__password position-relative">
                                <input class="form-control fs-4 p-3 border border-secondary-subtle" type="password" name="password" id="password" title="Your password" placeholder="Your password here.">
                                <button type="button" id="mostrar" class="container-auth__btn-password position-absolute top-50 end-0 translate-middle-y p-4 rounded-end fs-4 bg-transparent">Show</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password2" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Repeat Password</label>
                            <div class="container-auth__password position-relative">
                                <input class="form-control fs-4 p-3 border border-secondary-subtle" type="password" name="password2" id="password2" title="Repeat your password" placeholder="Repeat password here.">
                                <button type="button" id="mostrar2" class="container-auth__btn-password position-absolute top-50 end-0 translate-middle-y p-4 rounded-end fs-4 bg-transparent">Show</button>
                            </div>
                        </div>
                    </div>
                    <?php require_once __DIR__ . '/../templates/alerts.php' ?>
                    <div class="d-grid mt-3 gap-3">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-dark fs-4 py-3 px-5 text-uppercase btn-login" id="btn-login" type="submit">Restore</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $script = '
            <script src="/build/js/password.js"></script>
            <script src="/build/js/loader.js"></script>';
?>