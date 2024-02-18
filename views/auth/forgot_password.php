<div style="height: 100vh;">
    <!-- Contenido de referencia a formulario-->
    <div class="contenedor-sm h-100 container-auth d-flex justify-content-center align-items-center">
        <!-- Contenedor donde van los circulos -->
        <div class="container-auth__pre-form p-3 position-relative d-flex justify-content-center align-items-center">
            <!-- Contenido Formulario  -->
            <div class="container-auth__form shadow z-1 rounded-3 border border-secondary-subtle">
                <!-- Formulario  -->
                <form action="/forgot-password" method="POST" novalidate>
                    <div class="d-flex row gap-2 justify-content-center">
                        <h1 class="fs-1 text-center text-secondary-emphasis fw-bold">Forgot Password</h1>
                        <p class="text-center fs-3 text-secondary-emphasis">Enter your email, We can send you the instructions.</p>
                    </div>
                    <div class="col-md mb-4 mt-5">
                        <label for="email" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Email</label>
                        <div class="input-group ">
                            <span for="email" class="input-group-text py-2 px-4 fs-3 border border-secondary-subtle bg-dark text-white">@</span>
                            <input title="Tu correo eléctronico" type="email" id="email" name="email" class="form-control fs-4 p-3 border border-dark-subtle" placeholder="Your email here.">
                        </div>
                    </div>
                    <?php require_once __DIR__ . '/../templates/alerts.php'; ?>
                    <div class="d-grid mt-3 gap-3">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-dark fs-4 py-3 px-5 text-uppercase btn-login" id="btn-login" type="submit">send instructions</button>
                        </div>
                    </div>
                    <div class="container text-center mt-5">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <p class="fs-4 text-secondary-emphasis">¿Do you already have an account? <a href="/" class="text-secondary-emphasis fw-bold link-login">Login</a></p>
                            <p class="fs-4 text-secondary-emphasis">¿Don`t you have an account yet? <a href="/create-account" class="text-secondary-emphasis fw-bold link-login">Register</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$script = '
    <script src="/build/js/loader.js"></script>
'
?>