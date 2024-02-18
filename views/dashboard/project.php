<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor top">
    <div class="content-header navegation-line d-flex align-items-center justify-content-between pt-5 pb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb fs-3 mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard/projects" class="d-flex align-items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
                        </svg>
                        Projects
                    </a>
                </li>
            </ol>
        </nav>
        <button class="btn-add d-flex align-items-center gap-2 p-3 fs-4 fw-bold" id="add-project-task">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
            </svg>
            <span>Add task</span>
        </button>
    </div>

    <div class="w-100 p-3 mt-3 d-flex align-items-center justify-content-end">
        <h4 class="counter fw-semibold" id="count-project-tasks">0 / 0 tasks completed</h4>
    </div>
    <div class="container-project-tasks" id="container-project-tasks">
        
    </div>
</div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
<?php $script .='
<script type="module" src="/build/js/projectTask.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
'; ?>