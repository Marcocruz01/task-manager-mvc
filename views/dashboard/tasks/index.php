<?php include_once __DIR__ . '/../header-dashboard.php'; ?>
<div class="contenedor mt-5">
    <?php include_once __DIR__ . '/../../templates/nav.php'; ?>

    <div class="navbar-options mt-5">
        <div class="navbar-options__nav-options  pb-4 d-flex align-items-center justify-content-between gap-3">
            <nav class="" style="height: 20px; --bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb h-100 fs-3">
                    <li class="breadcrumb-item"><a href="/dashboard/projects">Your Projects</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tasks</li>
                </ol>
            </nav>
            <div class="content-options d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon w-6 h-6 mt-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <select class="form-select select fs-4 fw-semibold py-2" name="filters" id="filters" aria-label="Default select example">
                        <option disabled selected>Filter tasks by</option>
                        <option id="pending" value="pending">Pending</option>
                        <option id="completed" value="completed">Completed</option>
                        <option id="low" value="low">Low priority</option>
                        <option id="medium" value="medium">Medium priority</option>
                        <option id="high" value="high">High priority</option>
                        <option id="all" value="">All tasks</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="container-mlg pt-5 pb-5" id="task-container">
            <div class="content-task grid" id="content-task">

            </div>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../footer-dashboard.php'; ?>
<?php $script .='
<script type="module" src="/build/js/tasks.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
'; ?>