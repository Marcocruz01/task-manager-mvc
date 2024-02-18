import { getCountProjects } from './sidebar.js';

// when document is loader successfully
document.addEventListener('DOMContentLoaded', startApp);

// eventListener
function startApp() {
    btnProject();
    getProjects();
}

// global variables
let projects = [];
let memoryProjects = [];

// event listener to element input
const inputSearch = document.getElementById('search-input');
inputSearch.addEventListener('input', filteredProjectsBySearch);

function filteredProjectsBySearch() {
    const searchTerm = inputSearch.value.trim().toLowerCase();
    if(searchTerm !== '') {
        projects = projects.filter( project => project.name.toLowerCase().includes(searchTerm));
    } else if(inputSearch !== searchTerm) {
        projects = [...memoryProjects];
    }
    showProjects();
}


// function that iterates over the tasks and show them
async function getProjects() {
    try {
        // create url and consume API
        const url = 'http://localhost:3000/api/projects';
        // Apply fetch to url
        const response = await fetch(url);
        // will see the result with format json
        const result = await response.json();
        projects = result.projects;
        memoryProjects = [...projects];
        showProjects();    
    } catch (error) {
        message('error', 'An unexpected error occurred while getting the project!', 'Reload the page or try again later');
        return;
    }
}

// functions
function btnProject() {
    // Declarated variables
    const btnAddProject = document.getElementById('btn-add-project');
    btnAddProject.addEventListener('click', () => {
        modal();
    });
}

// modal of SwalAlert
function modal(edite = false, project = {}) {
    Swal.fire({
        title: `${edite ? 'Edite name project' : 'Enter Project Details'}`,
        html: `
            <div class="container-task">
                <div class="container-task__item">
                    <label for="project-title" class="swal2-label">Project Title:</label>
                    <input type="text" id="project-title" placeholder="${edite ? 'Edite project name here...' : 'Enter title here...'}" class="swal2-input" value="${project.name ? project.name : ''}">
                </div>
            </div>
        `,
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonText: `${edite ? 'Save changes' : 'Add project'}`,
        confirmButtonColor: '#697199',
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#DC3741',
        preConfirm: () => {
            const projectTitle = document.getElementById('project-title').value.trim();
            if (projectTitle === '') {
                Swal.showValidationMessage('Make sure all fields are complete.');
                return false;
            }
        }
    }).then((result) => {
        if (result.isConfirmed == true) {
            const projectTitle = document.getElementById('project-title').value.trim();
            if(edite) {
                project.name = projectTitle;
                updateProject(project);
            } else {
                createProject(projectTitle);
            }
        }
    })
}

async function createProject(projectTitle) {
    // build request
    const data = new FormData();
    data.append('name', projectTitle);
    // build request
    try {
        const url = 'http://localhost:3000/api/project/create';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Project Created Successfully', `The project was created successfully!`);
            const projectObj = {
                id: String(result.id),
                name: projectTitle,
                url: result.url,
                owner_id: result.owner_id,
                creation_date: result.creation_date
            }
            projects = [...projects, projectObj];
            getCountProjects();
            showProjects();
        }
    } catch (error) {
        message('error', 'Project created Failed', 'An error occurred while creating the project, please try again later!');
        return;
    }
}

function showProjects() {
    // call function 
    clearHTML();
    // if haven`t projects, show alert
    if(projects.length === 0) {
        // create errorDiv o alertDiv
        const alertDiv = document.createElement('DIV');
        // add classes to alertDiv
        alertDiv.className = 'd-flex justify-content-center alert w-100';
        // create alert 
        const alert = document.createElement('DIV');
        // add classes
        alert.className = 'alert alert-danger fs-3 fw-semibold text-center w-auto';
        // add attributes
        alert.setAttribute = ('role', 'alert');
        // add text
        alert.textContent = 'It looks like you haven`t added any projects yet, start by adding a project!';
        // appenchild to alert
        alertDiv.appendChild(alert);
        // adding alert to container 
        document.getElementById('content-project').appendChild(alertDiv);
        return;
    }

    projects.forEach(project => {
        // create card
        const card = document.createElement('DIV');
        card.className = 'card-project rounded-4';

        // create content card
        const contentCard = document.createElement('DIV');
        contentCard.className = 'card-project__content p-4';

        // content of title and arrow
        const headerCard = document.createElement('A');
        headerCard.setAttribute('href', `/dashboard/project?id=${project.url}`);
        headerCard.className = 'card-project__header d-flex align-items-center justify-content-between';

        // title
        const titleCard = document.createElement('H2');
        titleCard.className = 'card-project__title fw-semibold';
        titleCard.textContent = project.name;

        // icon arrow
        const arrowCard = document.createElement('P');
        arrowCard.className = 'card-project__icon mb-0';
        arrowCard.innerHTML = 
        `
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        `;

        // date paragraphy
        const dateCard = document.createElement('P');
        dateCard.className = 'card-project__date fs-5';
        dateCard.textContent = `Created: ${project.creation_date}`; 
        
        // div footer
        const footerCard = document.createElement('DIV');
        footerCard.className = 'mt-5 d-flex align-items-center justify-content-end';

        // div actions
        const containerActions = document.createElement('DIV');
        containerActions.className = 'd-flex align-items-center gap-3';

        // btn edite
        const btnEdite = document.createElement('BUTTON');
        btnEdite.setAttribute('type', 'button');
        btnEdite.className = 'card-project__btn-actions card-project__btn-actions--edite px-3 py-2 rounded-3';
        btnEdite.title = 'Edite project'    
        btnEdite.innerHTML = 
        `
            <span class="visually-hidden">Edite project</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        `;
        btnEdite.onclick = function() {
            modal(true, {...project});
        }
        // btn delete
        const btnDelete = document.createElement('BUTTON');
        btnDelete.setAttribute('type', 'button');
        btnDelete.className = 'card-project__btn-actions card-project__btn-actions--delete px-3 py-2 rounded-3';
        btnDelete.title = 'Delete project'
        btnDelete.innerHTML = 
        `
            <span class="visually-hidden">delete project</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
        `;
        btnDelete.onclick = function() {
            confirmDelete(project);
        }
        // insert elements
        card.appendChild(contentCard);
        contentCard.appendChild(headerCard);
        headerCard.appendChild(titleCard);
        headerCard.appendChild(arrowCard);
        contentCard.appendChild(dateCard);
        contentCard.appendChild(footerCard);
        footerCard.appendChild(containerActions);
        containerActions.appendChild(btnEdite);
        containerActions.appendChild(btnDelete);

        document.getElementById('content-project').appendChild(card);
    });

}

function confirmDelete(project) {
    Swal.fire({
        icon: 'question',
        title: "Are you sure you want to delete the project?",
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: `Cancel`,
        confirmButtonColor: '#697199',
    }).then((result) => {
        if (result.isConfirmed) {
            deleteTask(project);
        }
    });
}

async function deleteTask(project) {
    // applying destructuring
    const { id, projectTitle, url, ownerId, creationDate} = project;
    const data = new FormData();
    data.append('id', id);
    data.append('name', projectTitle);
    data.append('url', url);
    data.append('owner_id', ownerId);
    data.append('creation_date', creationDate);

    // create trychatch
    try {
        // connect to url
        const url = 'http://localhost:3000/api/project/delete';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Project Deleted Succesffully', 'The project was deleted successfully!');
            // filter projects that were not deleted
            projects = projects.filter( waitProject => waitProject.id !== project.id);
            // show projects and update counter
            getCountProjects();
            showProjects();
        }
    } catch (error) {
        message('error', 'Task Deleting Failed', 'An error occurred while deleting the project, please try again later!');
        return;
    }
}

async function updateProject(project) {
    const { id, name, url, owner_id, creation_date } = project;
    const data = new FormData();
    data.append('id', id);
    data.append('name', name);
    data.append('url', url);
    data.append('owner_id', owner_id);
    data.append('creation_date', creation_date);

    // create trychatch
    try {
        // connect to url
        const url = 'http://localhost:3000/api/project/update';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Project updated Succesffully', 'The project was updated successfully!');
            projects = projects.map(projectObj => {
                if(projectObj.id === id) {
                    projectObj.name = name;
                }
                return projectObj;
            });
            showProjects();
        }
    } catch (error) {
        message('error', 'Task updating Failed', 'An error occurred while updating the project, please try again later!');
        return;
    }
}

// personalized message
function message(type, title, text) {
    Swal.fire({
        position: 'top-end',
        icon: type,
        title: title,
        text: text,
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 2000
    });
}

// HTML CLEAN
function clearHTML() {
    // select container
    const containerTask = document.getElementById('content-project');
    // clean html with metod while
    while (containerTask.firstChild) {
        containerTask.removeChild(containerTask.firstChild);
    }
}