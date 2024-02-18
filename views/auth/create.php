<div style="height: 100vh;">
    <!-- Contenido de referencia a formulario-->
    <div class="contenedor-sm h-100 container-auth d-flex justify-content-center align-items-center">
        <!-- Contenedor donde van los circulos -->
        <div class="container-auth__pre-form p-3 position-relative d-flex justify-content-center align-items-center">
            <!-- Contenido Formulario  -->
            <div class="container-auth__form shadow z-1 rounded-3 border border-secondary-subtle">
                <!-- Formulario  -->
                <form action="/create-account" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <h1 class="fs-1 text-center text-secondary-emphasis fw-bold mb-0">Sign Up</h1>
                        <p class="fs-3 text-center text-secondary-emphasis">Start by registering your account and get the most out of the app.</p>
                    </div>
                    <div class="d-flex pt-3 g-4 row">
                        <div class="col-md">
                            <label for="name" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Name</label>
                            <input class="form-control fs-4 p-3 border border-secondary-subtle" type="text" value="<?php echo $user->name; ?>" name="name" id="name" title="Your name." placeholder="Your name here." autocomplete="name">
                        </div>
                        <div class="col-md">
                            <label for="lastName" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Last name</label>
                            <input class="form-control fs-4 p-3 border border-secondary-subtle" type="text" value="<?php echo $user->last_name; ?>" name="last_name" id="lastName" title="Your last_name" placeholder="Your last name here." autocomplete="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Email</label>
                            <div class="input-group ">
                                <span for="email" class="input-group-text py-2 px-4 fs-3 border border-secondary-subtle bg-dark text-white">@</span>
                                <input class="form-control fs-4 p-3 border border-secondary-subtle" type="email" value="<?php echo $user->email; ?>" id="email" name="email" title="Your email" placeholder="Your email here." autocomplete="email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Password</label>
                            <div class="container-auth__password position-relative">
                                <input class="form-control fs-4 p-3 border border-secondary-subtle" type="password" name="password" id="password" title="Your password" placeholder="Your password here." autocomplete="new-password">
                                <button type="button" id="mostrar" class="container-auth__btn-password position-absolute top-50 end-0 translate-middle-y p-4 rounded-end fs-4 bg-transparent">Show</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password2" class="form-label text-white fs-3 text-secondary-emphasis fw-bold">Repeat Password</label>
                            <div class="container-auth__password position-relative">
                                <input class="form-control fs-4 p-3 border border-secondary-subtle" type="password" name="password2" id="password2" title="Repeat your password" placeholder="Repeat password here." autocomplete="new-password">
                                <button type="button" id="mostrar2" class="container-auth__btn-password position-absolute top-50 end-0 translate-middle-y p-4 rounded-end fs-4 bg-transparent">Show</button>
                            </div>
                        </div>
                    </div>
                    <?php require_once __DIR__ . '/../templates/alerts.php' ?>
                    <div class="d-flex justify-content-end mt-3 gap-3">
                        <a href="/" class="btn btn-outline-dark fs-4 py-3 px-5 text-uppercase btn-registro" type="submit">Login</a>
                        <button class="btn btn-dark text-white fs-4 py-3 px-5 text-uppercase" id="registro" type="submit">Sign in</button>
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