<div class="contenedor-sm top">
    <nav class="navegation-bar rounded-3 p-3">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <button type="button" class="btn-add fs-4 d-flex align-items-center gap-2 p-3 fw-semibold" id="<?php echo ($title === 'Tasks' ? 'btn-add-task' : 'btn-add-project'); ?>" aria-label="<?php echo ($title === 'Tasks' ? 'button for add tasks' : 'button for add projects'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="sr-only"><?php echo ($title === 'Tasks' ? 'Add task' : 'Add project') ?></span>
            </button>
            <form class="d-flex align-items-center w-50" role="search">
                <div class="input-group">
                    <input type="text" class="input-nav form-control fs-4 p-2 w-25" id="search-input" placeholder="<?php echo ($title === 'Tasks' ? 'Search tasks...' : 'Search projects..'); ?>" aria-label="Search some task here...">
                    <button class="button-add py-2 px-4 z-0 fs-4" type="button" aria-label="Button for search tasks">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search mb-1" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </nav>
</div>