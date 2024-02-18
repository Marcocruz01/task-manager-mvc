<aside class="sidebar z-2" id="sidebar">
    <div class="sidebar__header d-flex justify-content-center align-items-center">
        <a href="/dashboard" class="text-uppercase title-sidebar fs-3 fw-bold">task manager</a>
    </div>
    <div class="panel-user mt-5 d-flex flex-column justify-content-center align-items-center w-100 pb-4">
        <div class="panel-user__picture w-100 text-center">
            <picture>
                <source srcset="/build/img/user/portrait.webp" type="image/webp">
                <img src="/build/img/user/portrait.jpg" alt="chico rizado alegre guapo cruza el pecho de brazos y sonriendo como persona confiada profesional" class="panel-user__image bg-body-tertiary rounded-circle shadow-sm img-thumbnail" width="100" loading="lazy">
            </picture>
        </div>
        <div class="panel-user__info-account mt-3 text-center">
            <h3 class="panel-user__name fw-bold"><?php echo $_SESSION['name'] . " " . $_SESSION['last_name']; ?></h3>
            <div class="panel-user__position d-flex align-items-center justify-content-center gap-2 mb-2">
                <h3 class="panel-user__position fw-semibold mb-0" id="my-position"><?php echo $_SESSION['position']; ?></h3>
                <a href="/dashboard/account" class="edite-account" id="edite-account" title="Edite Account">
                    <span class="visually-hidden">Account</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" heigth="16" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                    </svg>
                </a>

            </div>
            <h4 class="panel-user__email fs-5"><?php echo $_SESSION['email']; ?></h4>
            <div class="panel-user__options mt-5 d-flex justify-content-center gap-5 w-100 align-items-center">
                <a href="/dashboard/account" class="panel-user__btns account rounded-2 p-3" id="account" title="Edite Account">
                    <span class="visually-hidden">Account</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 01-.517.608 7.45 7.45 0 00-.478.198.798.798 0 01-.796-.064l-.453-.324a1.875 1.875 0 00-2.416.2l-.243.243a1.875 1.875 0 00-.2 2.416l.324.453a.798.798 0 01.064.796 7.448 7.448 0 00-.198.478.798.798 0 01-.608.517l-.55.092a1.875 1.875 0 00-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 01-.064.796l-.324.453a1.875 1.875 0 00.2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 01.796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 01.517-.608 7.52 7.52 0 00.478-.198.798.798 0 01.796.064l.453.324a1.875 1.875 0 002.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 01-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 001.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 01-.608-.517 7.507 7.507 0 00-.198-.478.798.798 0 01.064-.796l.324-.453a1.875 1.875 0 00-.2-2.416l-.243-.243a1.875 1.875 0 00-2.416-.2l-.453.324a.798.798 0 01-.796.064 7.462 7.462 0 00-.478-.198.798.798 0 01-.517-.608l-.091-.55a1.875 1.875 0 00-1.85-1.566h-.344zM12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" clip-rule="evenodd" />
                    </svg>
                </a>
                <button type="button" class="panel-user__btns rounded-2 p-3 position-relative" title="Mail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                        <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                    </svg>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-6">+ 1</span>
                </button>
                <button type="button" class="panel-user__btns rounded-2 p-3 position-relative" title="Notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fs-6">+ 1</span>
                </button>
            </div>
        </div>
        <div class="panel-user__progress-bar mt-4 w-100 px-5">
            <p class="panel-user__title-task fs-5 mb-2 text-end " id="completed-task"></span></p>
            <div class="progress" role="progressbar" aria-label="progress bar for task" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" id="progress-bar" style="width: 0%"></div>
            </div>

            <div class="panel-user__count-bar d-flex justify-content-around align-items-center gap-2 mt-4">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h3 class="count-numeric fs-1 fw-semibold" id="count-projects">0</h3>
                    <a href="/dashboard/projects" class="text-center title-count fw-bold fs-4">Projects<br><span class="fw-normal">All</span></a>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h3 class="count-numeric fs-1 fw-semibold" id="all-task">0</h3>
                    <a href="/dashboard/tasks" class="text-center title-count fw-bold fs-4">All<br><span class="fw-normal">Tasks</span></a>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h3 class="count-numeric fs-1 fw-semibold" id="pending-tasks">0</h3>
                    <p class="text-center fw-bold fs-4 mb-0 title-count">Pending<br><span class="fw-normal">Tasks</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="projects-user mt-5 px-5 pb-3">
        <h3 class="fw-bold title-content text-uppercase">projects</h3>
        <div class="projects-user__container mt-4" id="projects-container">

        </div>
    </div>
    <div class="footer-sidebar px-5">
        <form action="/logout" method="POST" class="footer-sidebar__action-close gap-2 col-6 mx-auto mt-4 shadow">
            <button type="submit" class="btn btn-danger d-flex justify-content-center align-items-center gap-2 fs-4 p-3 fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
                logout
            </button>
        </form>
        <h2 class="title-footer fs-4 mt-4 text-center">Task Manager | All rights reserved 2024 ©</h2>
    </div>
</aside>