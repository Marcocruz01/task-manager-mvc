<div style="height: 100vh;">
    <!-- Contenido de referencia a formulario-->
    <div class="contenedor-sm h-100 container-auth d-flex align-items-center justify-content-center">
        <!-- Contenedor donde van los circulos -->
        <div class="container-auth__pre-form p-3 position-relative d-flex justify-content-center align-items-center">
            <!-- Contenido Formulario  -->
            <div class="container-auth__form shadow z-1 rounded-3 border border-secondary-subtle">
                <!-- Formulario  -->
                <form action="/" method="POST" id="form">
                    <div class="d-flex row gap-2 justify-content-center">
                        <h1 class="fs-1 text-center text-secondary-emphasis fw-bold">Login in the App</h1>
                        <p class="text-center fs-3 text-secondary-emphasis">Enter with your email and start creating your new tasks.</p>
                    </div>
                    <div class="col-md mt-5">
                        <label for="email" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Email</label>
                        <div class="input-group ">
                            <span for="email" class="input-group-text py-2 px-4 fs-3 border border-secondary-subtle bg-dark text-white">@</span>
                            <input class="form-control fs-4 p-3 border border-secondary-subtle" style="zoom: 1; transform: scale(1);" type="email" id="email" name="email" title="Your email." placeholder="Your email here." autocomplete="name">
                        </div>
                    </div>
                    <div class="d-flex pt-3 g-1 row">
                        <div class="mb-3">
                            <label for="password" class="form-label fs-3 text-secondary-emphasis fw-bold">Password</label>
                            <div class="container-auth__password position-relative">
                                <input class="form-control fs-4 p-3 border border-secondary-subtle" type="password" name="password" id="password" title="Your password" placeholder="Your password here." autocomplete="email">
                            </div>
                        </div>
                    </div>
                    <?php require_once __DIR__ . '/../templates/alerts.php' ?>
                    <div class="d-grid mt-3 gap-3">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-dark fs-4 py-3 px-5 text-uppercase btn-login" id="btn-login" type="submit">Login</button>
                        </div>
                    </div>
                    <div class="container text-center mt-5">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <p class="fs-4 text-secondary-emphasis">¿Do you haven`t an account? <a href="/create-account" class="text-secondary-emphasis fw-bold link-login">Register</a></p>
                            <p class="fs-4 text-secondary-emphasis">¿Do you forgot your password? <a href="/forgot-password" class="text-secondary-emphasis fw-bold link-login">Recover</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $script = '<script src="/build/js/loader.js"></script>';?>