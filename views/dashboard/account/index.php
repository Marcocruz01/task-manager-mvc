<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="contenedor top">
    <h1 class="title-account fw-bold fs-1 mb-3">Account Information</h1>
    <p class="fs-3 description-account-help">Edit the information you used to set up your To Do List account.</p>

    <div class="navegations border-bottom">
        <nav class="my-4 d-flex justify-content-between" style="height: 20px; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb h-100 fs-3">
                <li class="breadcrumb-item active" aria-current="page">Your Account</li>
            </ol>
        </nav>
    </div>
    <div class="mt-3">
        <a class="fs-3" href="/dashboard/password">Do you want to change your password?</a>
    </div>
    <form action="/dashboard/account" method="POST">
        <div class="accordion contenedor-sm mt-5" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fs-3 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Profile
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <div class="profile-information">
                            <div class="mb-3 fs-4">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control input-text fs-4 p-3" id="name" name="name" placeholder="Your name" value="<?php echo $user->name; ?>" autocomplete="name">
                            </div>
                            <div class="mb-3 fs-4">
                                <label for="last_name" class="form-label fw-bold">Last name</label>
                                <input type="text" class="form-control input-text fs-4 p-3" id="last_name" name="last_name" placeholder="Your lastname" value="<?php echo $user->last_name; ?>" autocomplete="last name">
                            </div>
                            <div class="mb-3 fs-4">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="text" class="form-control input-text fs-4 p-3" id="email" name="email" placeholder="Your email" value="<?php echo $user->email; ?>" autocomplete="email">
                            </div>
                            <div class="mb-3 fs-4">
                                <label for="position" class="form-label fw-bold">Position</label>
                                <input type="text" class="form-control input-text fs-4 p-3" id="position" name="position" placeholder="Your position" value="<?php echo $user->position; ?>" autocomplete="position">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-3">
                <?php include_once __DIR__ . '../../../templates/alerts.php'; ?>
            </div>
            <div class="w-100 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4 py-3 fw-bold fs-4">Save changes</button>
            </div>
        </div>
    </form>
    <!-- .title::after {
        width: 18px;
        height: 18px;
        animation: pulse 1s linear infinite;
    } -->
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>