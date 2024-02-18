<?php include_once __DIR__ . '/../header-dashboard.php'; ?>

<div class="contenedor mt-5">
    <?php include_once __DIR__ . '/../../templates/nav.php'; ?>
    <div class="navbar-options mt-5">
        <div class="navegation-line pb-4 d-flex align-items-center justify-content-between gap-3">
            <nav class="" style="height: 20px; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb h-100 fs-3">
                    <li class="breadcrumb-item"><a href="/dashboard/tasks">Your Tasks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Projects</li>
                </ol>
            </nav>
        </div>

        <div class="container-mlg pt-5 pb-5" id="project-container">
            <div class="content-projects grid" id="content-project">

            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>
<?php $script .= '
<script type="module" src="/build/js/projects.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
'; ?>