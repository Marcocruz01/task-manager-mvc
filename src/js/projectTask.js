// When document is ready
document.addEventListener('DOMContentLoaded', startApp);

// call back functios
function startApp() {
    btnAddTask();
    getProjectTasks();
    getCountProjectTasks();
}

// updates backgrounds
setInterval(() => {
    getProjectTasks();
}, 10000);


// global variables
let tasks = [];

// get project tasks
async function getProjectTasks() {
    // connect to url
    try {
        // id
        const id = getUrlProject();
        // url
        const url = `/dashboard/project-tasks?id=${id}`;
        // response
        const response = await fetch(url);
        // result
        const result = await response.json();
        // save variable tasks
        tasks = result.tasks;
        // callback function 
        showProjectTasks();
    } catch (error) {
        message('error', 'Task Failed', 'An error occurred while getting the task, please try again later!');
        return;
    }
}

async function getCountProjectTasks() {
    try {

        // id
        const id = getUrlProject();
        // url
        const url = `/dashboard/project-tasks?id=${id}`;
        // response
        const response = await fetch(url);
        // result
        const result = await response.json(); 
        const counterTasks = result.tasks.length;
        const tasksCompleted = tasks.filter(tasks => tasks.state === 'completed');
        const taskFinished = tasksCompleted.length;
        document.getElementById('count-project-tasks').textContent = ` ${taskFinished} / ${counterTasks} tasks completed`;
    } catch (error) {
        message('error', 'Task Failed', 'An error occurred while getting the task, please try again later!');
        return;
    }
}

function btnAddTask() {
    // Declarated variables
    const btnAddTask = document.getElementById('add-project-task');
    btnAddTask.addEventListener('click', () => {
        modal();
    });
}

// function that open Modal with a click
function modal(edite = false, task = {}) {
    Swal.fire({
        title: `${edite ? 'Edite task details' : 'Enter task details'}`,
        html: `
            <div class="container-task">
                <div class="container-task__item">
                    <label for="title" class="swal2-label">Task Title:</label>
                    <input type="text" id="title" placeholder="${edite ? 'Edite title task...' : 'Task title here...'}" class="swal2-input" value="${task.title ? task.title : ''}">
                </div>
            </div>
        `,
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonText: `${edite ? 'Save changes' : 'Add Task'}`,
        confirmButtonColor: '#697199',
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#DC3741',
        preConfirm: () => {
            const title = document.getElementById('title').value.trim();
            if (title === '') {
                Swal.showValidationMessage('Make sure all fields are complete.');
                return false;
            }
        }
    }).then((result) => {
        if (result.isConfirmed == true) {
            const title = document.getElementById('title').value.trim();
            if(edite) {
                task.title = title;
                updateTask(task);
            } else {
                // function create task with parameters 
                createTask(title);
            }
        }
    })
}

// function for create a new task with the information using API Fetch Async await
async function createTask(title) {
    // to make request
    const data = new FormData();
    data.append('title', title);
    data.append('projectId', getUrlProject());

    try {
        const url = 'http://localhost:3000/api/project-tasks/create';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Task Created Successfully', 'The task was created successfully!');
            // create new task Obj
            const taskObj = {
                id: String(result.id),
                title: title,
                date: result.date,
                projectId: result.projectId,
                state: "pending"
            }
            tasks = [...tasks, taskObj];
            showProjectTasks();
            getCountProjectTasks();
        }
    } catch (error) {
        message('error', 'Task Create Failed', 'An error occurred while creating the task, please try again later!');
        return;
    }
}

// function that get url project 
function getUrlProject() {
    const projectParameters = new URLSearchParams(window.location.search);
    const project = Object.fromEntries(projectParameters.entries());
    return project.id;
}

// edite task 
function changeState(task) {
    Swal.fire({
        icon: 'question',
        title: "Do you want to update the status of the task?",
        showDenyButton: true,
        showCloseButton: true,
        confirmButtonText: "Update",
        denyButtonText: `Cancel`,
        confirmButtonColor: '#697199',
      }).then((result) => {
        if (result.isConfirmed) {
            const newState = task.state === "completed" ? "pending" : "completed";
            task.state = newState;
            updateTask(task);
        } 
    });
}

// function for update task
async function updateTask(task) {
    // applying destructuring
    const {id, title, state} = task;
    const data = new FormData();
    data.append('id', id);
    data.append('title', title);
    data.append('state', state);
    data.append('projectId', getUrlProject());
    // create trychatch
    try {
        // Connect to the API 
        const url = 'http://localhost:3000/api/project-tasks/update';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        const result = await response.json();    
        if (result.type === 'success') {
            message('success', 'Task Status Updated', `The task was updated successfully!`);
        }
        tasks = tasks.map(taskObj => {
            if(taskObj.id === id) {
                taskObj.title = title;
                taskObj.state = state;
            }
            return taskObj;
        });
        showProjectTasks();
        getCountProjectTasks();
    } catch (error) {
        message('error', 'Task Updatgin Failed', 'An error occurred while updating the task, please try again later!');
        return;
    }
}

// message confirm delete
function confirmDelete(task) {
    Swal.fire({
        icon: 'question',
        title: "Are you sure you want to delete the task?",
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: `Cancel`,
        confirmButtonColor: '#697199',
      }).then((result) => {
        if (result.isConfirmed) {
            deleteTask(task);
        }
    });
}

// delete confirm
async function deleteTask(task) {
    // applying destructuring
    const {id, title, date, state} = task;
    const data = new FormData();
    data.append('id', id);
    data.append('title', title);
    data.append('date', date);
    data.append('state', state);
    data.append('projectId', getUrlProject());

    try {
        const url = 'http://localhost:3000/api/project-tasks/delete';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        }); 
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Task Deleted Succesffully', 'The task was deleted successfully!');
            // filter task deleted
            tasks = tasks.filter( waitTask => waitTask.id !== task.id);
            // call function 
            getCountProjectTasks();
            showProjectTasks();
        }
    } catch (error) {
        message('error', 'Task deleted Failed', 'An error occurred while deleting the task, please try again later!');
        return;
    }
}


// show project tasks
function showProjectTasks() {
    // clean html
    clearHTML();
    // if project task is === 0
    if(tasks.length === 0) {
        // create errorDiv o alertDiv
        const alertDiv = document.createElement('DIV');
        // add classes to alertDiv
        alertDiv.className = 'd-flex justify-content-center mt-5 alert w-100';
        // create alert 
        const alert = document.createElement('DIV');
        // add classes
        alert.className = 'alert alert-danger fs-3 fw-semibold text-center w-auto';
        // add attributes
        alert.setAttribute = ('role', 'alert');
        // add text
        alert.textContent = 'It looks like you haven`t added any tasks yet, start by adding a task!';
        // appenchild to alert
        alertDiv.appendChild(alert);
        // adding alert to container 
        document.getElementById('container-project-tasks').appendChild(alertDiv);
        return;
    }

    // variables states obj
    const stateObj = {
        pending: 'pending',
        completed: 'completed'
    }

    tasks.forEach( task => {
        // create li
        const liTask = document.createElement('LI');
        liTask.className = 'task rounded-4 d-flex align-items-center justify-content-between p-3 rounded mb-3 shadow-sm';

        // create div, this div contains "task pending and title"
        const divInfo = document.createElement('DIV');
        divInfo.className = 'task__info';
        // title task
        const titleTask = document.createElement('H4')
        titleTask.className = 'task__title fw-semibold';
        titleTask.textContent = task.title;

        // footer task
        const divFooter = document.createElement('DIV');
        divFooter.className = 'task__footer d-flex align-items-center gap-3';
        // date 
        const dateTask = document.createElement('P');
        // assign up classes
        dateTask.className = 'task__date mb-0 fs-5';
        // assing up date on variable
        const dateHour = task.date;
        // Convert date from string to Date object
        const dateHourObj = new Date(dateHour);
        // Get the current date and time
        const currentDate = new Date();
        // Calculate the difference in milliseconds
        const differenceTime = currentDate - dateHourObj;
        // convert the difference to minutes
        const minutesElapsed = Math.floor(differenceTime / (1000 * 60));
        // show message 
        let message = '';
        console.log('Tiempo transcurrido: ',minutesElapsed);
        if (minutesElapsed <= 2) {
            message = 'Added now';
        } else if (minutesElapsed <= 10) {
            message = `${minutesElapsed} min ago`;
        } else if (dateHourObj.getDate() === currentDate.getDate()) {
            message = 'Added today';
        }else {
            const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ];
            const date = dateHourObj.getDate();
            const monthIndex = dateHourObj.getMonth();
            const dateTime = `${months[monthIndex]} ${date}`;
            message = `${dateTime}`;
        }
        dateTask.textContent = message;

        // task pending
        const stateTask = document.createElement('BUTTON');
        stateTask.setAttribute('type', 'button');
        stateTask.className = `card__button-state rounded-2 fw-bold fs-6 text-uppercase p-2 ${stateObj[task.state].toLowerCase()}`;
        stateTask.textContent = stateObj[task.state];
        stateTask.dataset.stateTask = task.state;
        // conditional for delete or add classes to button
        if (task.state === "pending") {
            stateTask.classList.add('card__button-state--pending');
        } else {
            stateTask.classList.add('card__button-state--complete');
        }
        stateTask.onclick = function() {
            changeState({...task})
        }

        // div with contains button and date
        const divActions = document.createElement('DIV');
        divActions.className = 'd-flex align-items-center gap-4';

        // create button dropdown
        const dropdownOptions = document.createElement('DIV');
        dropdownOptions.innerHTML = 
        `
            <button type="button" class="btn options btn-outline-transparent" data-bs-toggle="dropdown" aria-expanded="false" aria-label="button with actions">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                </svg>
            </button>
        `;

        // create dropdown menu
        const dropmenu = document.createElement('UL');
        dropmenu.classList.add('dropdown-menu', 'p-2');

        // create LI for button edite and delete task
        const liEdite = document.createElement('LI');
        // button edite
        const btnEdite = document.createElement('BUTTON');
        btnEdite.setAttribute('type', 'button');
        btnEdite.className = 'button-actions rounded button-actions--edite d-flex align-items-center gap-3 w-100 fs-4 mb-2"';
        btnEdite.innerHTML = 
        `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Edite</span>
        `;
        btnEdite.onclick = function() {
            modal( true, {...task} );
        }

        // create LI for button edite and delete task
        const liDelete = document.createElement('LI');
        // button delete
        const btnDelete = document.createElement('BUTTON');
        btnDelete.setAttribute('type', 'button');
        btnDelete.className = 'button-actions rounded button-actions--delete d-flex align-items-center gap-3 w-100 fs-4';
        btnDelete.innerHTML = 
        `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
            <span>Delete</span>
        `;
        btnDelete.onclick = function() {
            confirmDelete(task);
        }

        // appendchild to liTask
        liTask.appendChild(divInfo);
        divInfo.appendChild(titleTask);
        divInfo.appendChild(divFooter);
        divFooter.appendChild(stateTask);
        divFooter.appendChild(dateTask);
        liTask.appendChild(divActions);
        divActions.appendChild(dropdownOptions);
        dropdownOptions.appendChild(dropmenu);
        dropmenu.appendChild(liEdite);
        dropmenu.appendChild(liDelete);
        liEdite.appendChild(btnEdite);
        liDelete.appendChild(btnDelete);

        // append with container
        document.getElementById('container-project-tasks').appendChild(liTask);
    });
}

// clear html
function clearHTML() {
    // select container to clean
    const containerTask = document.getElementById('container-project-tasks');
    // clean html with method while
    while(containerTask.firstChild) {
        containerTask.removeChild(containerTask.firstChild);
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

