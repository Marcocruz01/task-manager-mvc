<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="contenedor top">
    <h1 class="fw-bold title-account  fs-1 mb-3">Password Information</h1>
    <p class="fs-4 description-account-help">To change the password you need to provide the current password to make the change successful.</p>

    <div class="navegations border-bottom">
        <nav class="my-4" style="height: 20px; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb h-100 fs-3">
                <li class="breadcrumb-item"><a href="/dashboard/account">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Password</li>
            </ol>
        </nav>
    </div>

    <form class="" action="/dashboard/password" method="POST">
        <div class="accordion contenedor-sm mt-5" id="accordionExample">
            <div class="accordion-item mb-3">
                <h2 class="accordion-header">
                    <button class="accordion-button fs-3 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Password
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="profile-information">
                            <div class="mb-3 fs-4">
                                <label for="current_password" class="form-label fw-bold">Current password</label>
                                <input type="password" class="form-control input-text fs-4 p-3" id="current_password" name="current_password" placeholder="Your current password">
                            </div>
                            <div class="mb-3 fs-4">
                                <label for="new_password" class="form-label fw-bold">New password</label>
                                <input type="password" class="form-control input-text fs-4 p-3" id="new_password" name="new_password" placeholder="Your new password">
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