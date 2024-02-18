document.addEventListener('DOMContentLoaded', mainApp);

// Main function 
function mainApp() {
    userPreferences();
    menuToggle();
    actionsTheme();
    getCountProjects();
    getCountTask();
    getCountTaskPending();
    getCountTaskCompleted();
}

function userPreferences() {
    const userThemePreference = localStorage.getItem('theme');
    const currentTheme = getCurrentTheme(); // Obtener el tema actual antes de realizar cambios

    if (!userThemePreference) {
        // Si no hay preferencia almacenada, establecer el tema actual
        localStorage.setItem('theme', currentTheme);
    } else {
        // Si hay preferencia almacenada, aplicarla
        changeTheme(userThemePreference);
    }
}

function getCurrentTheme() {
    const body = document.body;
    return body.classList.contains('dark-theme') ? 'dark' : 'light';
}
// Functinons //
function menuToggle() {
    // Select button menu toggle
    const btnMenuToggle = document.getElementById('menu-toggle');
    // select sidebar for after show
    const sidebar = document.getElementById('sidebar');
    btnMenuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('sidebar--show');
    });
}

window.onscroll = () => {
    sidebar.classList.remove('sidebar--show');
}
function actionsTheme() {
    document.getElementById('light').addEventListener('click', function() {
        changeTheme('light');
    });
    
    document.getElementById('dark').addEventListener('click', function() {
        changeTheme('dark');
    });
}

function changeTheme(theme) {
    const btnChangeTheme = document.getElementById('btn-change-theme');
    const icon = btnChangeTheme.querySelector('svg');
    const body = document.body;
    if (theme === 'dark') {
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
        `;
        body.classList.add('dark-theme');
        body.classList.remove('light-theme');
    } else {
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        `;
        body.classList.add('light-theme');
        body.classList.remove('dark-theme');
    }

    // Actualizar la preferencia almacenada
    localStorage.setItem('theme', theme);
}

// function that get count projects
export async function getCountProjects() {
    try {
        // create url and consume API
        const url = 'http://localhost:3000/api/projects';
        // Apply fetch to url
        const response = await fetch(url);
        // will see the result with format json
        const result = await response.json();
        const projectsTotal = result.projects;
        // add task count on sidebar number
        document.getElementById('count-projects').textContent = projectsTotal.length;
        // clear chidls
        clearHTML();
        // Check if there are projects
        if(projectsTotal.length === 0) {
            // If there are no projects, display a message and a link to add one
            const noProjectMessage = document.createElement('P');
            noProjectMessage.className = 'fs-4 fw-semibold text-center';
            noProjectMessage.textContent = 'There are no projects yet, add one!';
            // link 
            const linkButton = document.createElement('A');
            linkButton.className = 'link btn btn-primary w-100 fs-4 text-center p-2 fw-semibold';
            linkButton.textContent = 'Start add';
            linkButton.href = '/dashboard/projects';

            // Append message to display container
            document.getElementById('projects-container').appendChild(noProjectMessage);
            document.getElementById('projects-container').appendChild(linkButton);
            return;
        }
        // Show only the first four projects
        const projectsToShow = projectsTotal.slice(0, 4);
        // Array with available color classes
        const circleColors = ['projects-user__circle--primary', 'projects-user__circle--yellow', 'projects-user__circle--green', 'projects-user__circle--orange'];

        // Loop through the projects to display them
        projectsToShow.forEach( (project, index) => {
            // Create elements to display project info
            const divContainer = document.createElement('DIV');
            divContainer.className = 'd-flex align-items-center gap-3 mb-3';

            // create span 
            const span = document.createElement('SPAN');
            span.className = `projects-user__circle mb-0 ${circleColors[index % circleColors.length]}`;

            // create paragraphy
            const nameProject = document.createElement('P')
            nameProject.className = 'mb-0 fs-4 name-project';
            nameProject.textContent = project.name;

            // Append elemets to display container
            divContainer.appendChild(span);
            divContainer.appendChild(nameProject);
            document.getElementById('projects-container').appendChild(divContainer);
        });
        return projectsTotal.length;
    } catch (error) {
        console.log(error);
        return;
    }
}

// function to get the count of tasks and projects ---- this function will be exported
export async function getCountTask() {
    try {
        // connect to url
        const url = 'http://localhost:3000/api/tasks';
        // get response
        const response = await fetch(url);
        // get result
        const result = await response.json();
        // get all tasks
        const tasks = result.tasks.length;
        // show count in html sidebar
        document.getElementById('all-task').textContent = tasks;
        return tasks;
    } catch (error) {
        console.log(error);
        return;
    }
}

// function to get the count of tasks with state pending
export async function getCountTaskPending() {
    try {
        // connect to url
        const url = 'http://localhost:3000/api/tasks';
        // get response
        const response = await fetch(url);
        // get result
        const result = await response.json();
        // get the task array
        const tasks = result.tasks;
        // filters task by her state 
        const tasksPending = tasks.filter(task => task.state === 'pending');
        // get task count with status pending
        const countTaskPending = tasksPending.length;
        document.getElementById('pending-tasks').textContent = countTaskPending;
        return countTaskPending;
    } catch (error) {
        console.log(error);
        return;
    }
}

// function to get the count of tasks with state comeplete
export async function getCountTaskCompleted() {
    try {
        // connect to url
        const url = 'http://localhost:3000/api/tasks';
        // get response
        const response = await fetch(url);
        // get result
        const result = await response.json();
        // get the task array
        const tasks = result.tasks;
        // filters task by her state 
        const taskCompleted = tasks.filter(task => task.state === 'completed');
        // get task count with status pending
        const countTaskCompleted = taskCompleted.length;
        document.getElementById('completed-task').textContent = `Task Completed - ${countTaskCompleted} / ${tasks.length}`;
        // Calculate percentage of completed tasks
        const percentageCompleted = (countTaskCompleted / tasks.length) * 100;
        // declarated variable and select progress bar
        const progressBar = document.getElementById('progress-bar');
        // dynamically applying styles
        progressBar.style.width = percentageCompleted + '%';
        // Return the percentage
        return countTaskCompleted;

    } catch (error) {
        console.log(error);
        return;
    }
}

// HTML CLEAN
function clearHTML() {
    // select container
    const containerTask = document.getElementById('projects-container');
    // clean html with metod while
    while (containerTask.firstChild) {
        containerTask.removeChild(containerTask.firstChild);
    }
}