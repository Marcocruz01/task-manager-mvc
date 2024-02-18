// import functions
import {getCountTask, getCountTaskPending, getCountTaskCompleted} from './sidebar.js';

// When document is ready
document.addEventListener('DOMContentLoaded', startApp);

// call back functios
function startApp() {
    btnAddTask();
    getTask();
}

// variable global for the task array
let tasks = [];
let filteredTasks = [];

// element input search 
const inputSearch = document.getElementById('search-input');
inputSearch.addEventListener('input', filterTasksBySearch);

function filterTasksBySearch() {
    const searchTerm = inputSearch.value.trim().toLowerCase();
    if (searchTerm !== '') {
        filteredTasks = tasks.filter(task => task.title.toLowerCase().includes(searchTerm) || task.description.toLowerCase().includes(searchTerm));
    } else {
        filteredTasks = [];
    }
    showTasks();
}

// search filters
const filters = document.getElementById('filters');
filters.addEventListener('change', filterTask);

// function for filter task
function filterTask(e) {
    const filter = e.target.value;
    if(filter !== '') {
        filteredTasks = tasks.filter(task => task.state === filter || task.priority === filter);
    } else {
        filteredTasks = [];
    }  
    showTasks();
}

// function that iterates over the tasks and show them
async function getTask() {
    try {
        // create url and consume API
        const url = 'http://localhost:3000/api/tasks';
        // Apply fetch to url
        const response = await fetch(url);
        // will see the result with format json
        const result = await response.json();
        tasks = result.tasks;
        // callback function 
        showTasks()     
    } catch (error) {
        message('error', 'An unexpected error occurred while getting the project!', 'Reload the page or try again later');
        return;
    }
}

// Adding tasks with API Fetch and async await
function btnAddTask() {
    // Declarated variables
    const btnAddTask = document.getElementById('btn-add-task');
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
                    <label for="task-title" class="swal2-label">Task Title:</label>
                    <input type="text" id="task-title" placeholder="${edite ? 'Edite title task...' : 'Task title here...'}" class="swal2-input" value="${task.title ? task.title : ''}">
                </div>
                <div class="container-task__item">
                    <label for="task-description" class="swal2-label">Task Description:</label>
                    <textarea id="task-description" placeholder="${edite ? 'Edite description task...' : 'Task description here...'}" class="swal2-textarea">${task.description ? task.description : ''}</textarea>
                </div>
                <div class="container-task__item">
                    <label for="task-priority" class="swal2-label">Priority:</label>
                    <select id="task-priority" class="swal2-select">
                        <option value="${task.priority ? task.priority : ''}" selected disabled >${task.priority ? 'Set priority: ' + task.priority : 'Select an option'}</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
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
            const taskTitle = document.getElementById('task-title').value.trim();
            const taskDescription = document.getElementById('task-description').value.trim();
            const taskPriority = document.getElementById('task-priority').value.trim();
            if (taskTitle === '' || taskDescription === '' || taskPriority === '') {
                Swal.showValidationMessage('Make sure all fields are complete.');
                return false;
            }
        }
    }).then((result) => {
        if (result.isConfirmed == true) {
            const taskTitle = document.getElementById('task-title').value.trim();
            const taskDescription = document.getElementById('task-description').value.trim();
            const taskPriority = document.getElementById('task-priority').value;
            if(edite) {
                task.title = taskTitle;
                task.description = taskDescription;
                task.priority = taskPriority;
                updateTask(task);
            } else {
                // function create task with parameters 
                createTask(taskTitle, taskDescription, taskPriority);
            }
        }
    })
}

// function for create a new task with the information using API Fetch Async await
async function createTask(title, description, priority) {
    // build request
    const data = new FormData();
    data.append('title', title);
    data.append('description', description);
    data.append('priority', priority);

    // create try catch
    try {
        // Connect to the API
        const url = 'http://localhost:3000/api/task/create';
        // await for an response of the url
        const response = await fetch(url, {
            method: 'POST',
            body: data
        });
        // if response is 200 or OK so...
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Task Created Successfully', `The task was created successfully!`);
            // create new task Obj
            const taskObj = {
                id: String(result.id),
                title: title,
                description: description,
                priority: priority,
                creation_date: result.creation_date,
                owner_id: result.owner_id,
                state: "pending",
            }
            tasks = [...tasks, taskObj];
            
            // Check if the task meets the current filter
            const filter = filters.value;
            if (filter === '' || taskObj.state === filter || taskObj.priority === filter) {
                filteredTasks = [...filteredTasks, taskObj];
            }
            getCountTask();
            getCountTaskPending();
            getCountTaskCompleted();
            showTasks();
        }
    } catch (error) {
        message('error', 'Task Create Failed', 'An error occurred while creating the task, please try again later!');
        return;
    }

    // for(let value of data.values()) {
    //     console.log(value);
    // }
}

// function that change state task
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
    const {id, title, description, priority, state, owner_id, creation_date} = task;
    const data = new FormData();
    data.append('id', id);
    data.append('title', title);
    data.append('description', description);
    data.append('priority', priority);
    data.append('state', state);
    data.append('owner_id', owner_id);
    data.append('creation_date', creation_date);

    // create trychatch
    try {
        // Connect to the API 
        const url = 'http://localhost:3000/api/task/update';
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
                taskObj.description = description;
                taskObj.priority = priority;
                taskObj.state = state;
            }
            return taskObj;
        });
        // mostrar tareas de nuevo
        getCountTaskPending();
        getCountTaskCompleted();
        showTasks();
    } catch (error) {
        message('error', 'Task Updatgin Failed', 'An error occurred while updating the task, please try again later!');
        return;
    }

}

// function that aked delete task
function confirmDeleteTask(task) {
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

// function that delete task
async function deleteTask(task) {
    // applying destructuring
    const {id, title, description, priority, state, owner_id, creation_date} = task;
    const data = new FormData();
    data.append('id', id);
    data.append('title', title);
    data.append('description', description);
    data.append('priority', priority);
    data.append('state', state);
    data.append('owner_id', owner_id);
    data.append('creation_date', creation_date);

    try {
        const url = 'http://localhost:3000/api/task/delete';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        }); 
        const result = await response.json();
        if(result.type === 'success') {
            message('success', 'Task Deleted Succesffully', 'The task was deleted successfully!');
            // filter task deleted
            tasks = tasks.filter( waitTask => waitTask.id !== task.id);
            // filter array task deleted
            filteredTasks = filteredTasks.filter(waitTask => waitTask.id !== task.id);
            // evaluate the task filter so that when it cointains nothing, the value of the select is reset.
            if (filteredTasks.length === 0) {
                filters.value = '';
            }
            // show again all task
            getCountTask();
            getCountTaskPending();
            getCountTaskCompleted();
            showTasks();
        }
    } catch (error) {
        message('error', 'Task deleted Failed', 'An error occurred while deleting the task, please try again later!');
        return;
    }
}

// function that view task in mode lg
function viewTask(task) {
    Swal.fire({
        html: `
            <div class="view-task text-start">
                <div class="d-flex flex-column">
                    <p class="view-task__header fs-5 mb-1">Created on the day: <span class="fw-bold">${task.creation_date}</span></p>
                </div>
                <div>
                    <h1 class="view-task__title fw-bold mb-2">${task.title}</h1>
                    <p class="view-task__description fs-4">Description: ${task.description}</p>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-3 mt-5 border-top pt-3">
                    <p class="view-task__info fs-5 fw-semibold text-capitalize mb-0">Status: <span class="view-task__span-state" id="span-state">${task.state}</span></p>
                    <p class="view-task__info fs-5 fw-semibold text-capitalize mb-0">Priority: <span class="view-task__span" id="span-priority">${task.priority}</span></p>
                </div>
            </div>
        `,
        showCloseButton: true,
        showConfirmButton: false,
    });
    const spanState = document.getElementById('span-state');
    const spanPriority = document.getElementById('span-priority');
    if(task.priority === 'low') {
        spanPriority.classList.add('view-task__span--low');
    } else if(task.priority === 'medium') {
        spanPriority.classList.add('view-task__span--medium');
    } else {
        spanPriority.classList.add('view-task__span--high');
    }
    if(task.state === 'completed') {
        spanState.classList.add('view-task__span-state--complete');
    } else {
        spanState.classList.add('view-task__span-state--pending');
    }
    
}

// function that show task
function showTasks() {
    // clean html 
    clearHTML();
    // get pending task
    pendingTotal();
    // get completed task
    completedTotal();
    // get low priority task
    lowTotal();
    // get medium priority task
    mediumTotal();
    // get high priority task
    highTotal();
    // create array filter
    const arrayTask = filteredTasks.length ? filteredTasks : tasks;
    // iterating
    if(arrayTask.length === 0) {
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
        alert.textContent = 'It looks like you haven`t added any tasks yet, start by adding a task!';
        // appenchild to alert
        alertDiv.appendChild(alert);
        // adding alert to container 
        document.getElementById('content-task').appendChild(alertDiv);
        return;
    }

    // variables states obj
    const stateTask = {
        pending: 'pending',
        completed: 'complete'
    }

    // variables priority obj
    const priorityTask = {
        low: 'low',
        medium: 'medium',
        high: 'high'
    }

    // iterate tasks
    arrayTask.forEach(task => {
        // create card div
        const card = document.createElement('DIV');
        card.className = 'card rounded-4 ';

        // create card content
        const cardContent = document.createElement('DIV');
        cardContent.className = 'card__content-card m-4';

        // create header card 
        const cardHeader = document.createElement('DIV');
        cardHeader.className = 'd-flex align-items-center justify-content-between';

        // create span priority
        const priority = document.createElement('SPAN');
        priority.classList.add('card__span-priority');
        priority.classList.add(`${priorityTask[task.priority]}`);
        priority.dataset.priorityTask = task.priority;

        if(task.priority === 'low') {
            priority.classList.add('card__span-priority--low');
        } else if (task.priority === 'medium') {
            priority.classList.add('card__span-priority--medium');
        } else if (task.priority === 'high'){
            priority.classList.add('card__span-priority--high');
        }

        // create button dropdown
        const dropdownOptions = document.createElement('DIV');
        dropdownOptions.innerHTML = 

        `
            <button type="button" class="btn-drop-down btn-outline-transparent bg-transparent" data-bs-toggle="dropdown" aria-expanded="false" aria-label="button with actions">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                </svg>
            </button>
        `;

        // create dropdown menu
        const dropmenu = document.createElement('UL');
        dropmenu.classList.add('dropdown-menu', 'p-2');

        // create li for btn edite
        const liEdite = document.createElement('LI');

        // create btn edite
        const btnEditeTask = document.createElement('BUTTON');
        btnEditeTask.setAttribute('type', 'button');
        btnEditeTask.className = 'button-actions rounded button-actions--edite d-flex align-items-center gap-3 w-100 fs-4 mb-2';
        btnEditeTask.innerHTML = 
        `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            <span>Edite</span>
        `;
        btnEditeTask.onclick = function() {
            modal(true, {...task});
        }

        // create li for btn edite
        const liDelete = document.createElement('LI');
        // create btn delete task
        const btnDeleteTask = document.createElement('BUTTON');
        btnDeleteTask.setAttribute('type', 'button');
        btnDeleteTask.className = 'button-actions rounded button-actions--delete d-flex align-items-center gap-3 w-100 fs-4';
        btnDeleteTask.innerHTML = 
        `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
            </svg>
            <span>Delete</span>
        `;
        btnDeleteTask.onclick = function() {
            confirmDeleteTask(task);
        }

        // create div content
        const content = document.createElement('DIV');
        content.className = 'card__content mb-4';
        content.innerHTML = 
        `
            <h2 class="card__title fw-semibold m-0">${task.title}</h2>
            <p class="card__description mt-2 fs-4">${task.description}</p>
        `;

        // create div actions buttons
        const cardActions = document.createElement('DIV');
        cardActions.className = 'd-flex align-items-center justify-content-end gap-3';

        // create buttons - button state 
        const btnStateTask = document.createElement('BUTTON');
        btnStateTask.setAttribute('type', 'button');
        btnStateTask.className = `card__button-state rounded-2 fw-bold fs-5 text-uppercase px-3 ${stateTask[task.state].toLowerCase()}`;
        btnStateTask.textContent = stateTask[task.state];
        btnStateTask.dataset.stateTask = task.state;
        btnStateTask.onclick = function() {
            changeState({...task});
        }
        // conditional for delete or add classes to button
        if (task.state === "pending") {
            btnStateTask.classList.add('card__button-state--pending');
        } else {
            btnStateTask.classList.add('card__button-state--complete');
        }

        // button view card
        const btnViewCard = document.createElement('BUTTON');
        btnViewCard.className = 'card__button-view rounded px-3';
        btnViewCard.setAttribute('aria-label', 'Button for view more information about task')
        btnViewCard.innerHTML =
        `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
            </svg>
        `;
        btnViewCard.onclick = function() {
            viewTask(task);
        }
        
        // insert elements
        card.appendChild(cardContent);
        cardContent.appendChild(cardHeader);
        cardHeader.appendChild(priority);
        cardHeader.appendChild(dropdownOptions);
        liEdite.appendChild(btnEditeTask);
        liDelete.appendChild(btnDeleteTask);
        dropmenu.appendChild(liEdite);
        dropmenu.appendChild(liDelete);
        dropdownOptions.appendChild(dropmenu);
        cardContent.appendChild(content);
        cardContent.appendChild(cardActions);
        cardActions.appendChild(btnStateTask);
        cardActions.appendChild(btnViewCard);
        
        // insert in document html and container tasks
        document.getElementById('content-task').appendChild(card);
    });
}

// function that filter task by pending
function pendingTotal() {
    const pendings = tasks.filter(task => task.state === "pending");
    const optionPending = document.getElementById('pending');
    if(pendings.length === 0) {
        optionPending.disabled = true;
    } else {
        optionPending.disabled = false;
    }
    
}

// function that filter task by completed
function completedTotal() {
    const completeds = tasks.filter(task => task.state === "completed");
    const optionCompleted = document.getElementById('completed');
    if(completeds.length === 0) {
        optionCompleted.disabled = true;
    } else {
        optionCompleted.disabled = false;
    }
}

// function that filter task by low priority
function lowTotal() {
    const lowPriority = tasks.filter(task => task.priority === "low");
    const optionLow = document.getElementById('low');
    if(lowPriority.length === 0) {
        optionLow.disabled = true;
    } else {
        optionLow.disabled = false;
    }
}

// function that filter task by medium priority
function mediumTotal() {
    const mediumPriority = tasks.filter(task => task.priority === "medium");
    const optionMedium = document.getElementById('medium');
    if(mediumPriority.length === 0) {
        optionMedium.disabled = true;
    } else {
        optionMedium.disabled = false;
    }
}

// function that filter task by high priority
function highTotal() {
    const highPriority = tasks.filter(task => task.priority === "high");
    const optionHigh = document.getElementById('high');
    if(highPriority.length === 0) {
        optionHigh.disabled = true;
    } else {
        optionHigh.disabled = false;
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
    const containerTask = document.getElementById('content-task');
    // clean html with metod while
    while (containerTask.firstChild) {
        containerTask.removeChild(containerTask.firstChild);
    }
}