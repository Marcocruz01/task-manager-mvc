<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AccountController;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\ProjectsController;
use Controllers\ProjectTasksController;
use Controllers\TasksController;
use MVC\Router;
$router = new Router();


// account
$router->get('/dashboard/account', [DashboardController::class, 'profile']);
$router->post('/dashboard/account', [DashboardController::class, 'profile']);
// change password
$router->get('/dashboard/password', [DashboardController::class, 'change_password']);
$router->post('/dashboard/password', [DashboardController::class, 'change_password']);
// Login
$router->get('/', [AuthController::class, 'login']);
$router->post('/', [AuthController::class, 'login']);
// logout
$router->post('/logout', [AuthController::class, 'logout']);
// Create account
$router->get('/create-account', [AuthController::class, 'create']);
$router->post('/create-account', [AuthController::class, 'create']);
// Recovery your password
$router->get('/forgot-password', [AuthController::class, 'forgot']);
$router->post('/forgot-password', [AuthController::class, 'forgot']);
// Recover password
$router->get('/restore-password', [AuthController::class, 'restore']);
$router->post('/restore-password', [AuthController::class, 'restore']);
// Message success
$router->get('/message-success', [AuthController::class, 'message']);
// Confirm accoutn
$router->get('/confirm-account', [AuthController::class, 'confirm']);

// Dashboard admin main
$router->get('/dashboard', [DashboardController::class, 'index']);

// page to view the projects
$router->get('/dashboard/projects', [ProjectsController::class, 'index']);
// API to view the task and create the task with fetch async away 
$router->get('/api/projects', [ProjectsController::class, 'read_projects']);
$router->post('/api/project/create', [ProjectsController::class, 'create_project']);
$router->post('/api/project/update', [ProjectsController::class, 'update_project']);
$router->post('/api/project/delete', [ProjectsController::class, 'delete_project']);

// page for view project tasks 
$router->get('/dashboard/project', [ProjectTasksController::class, 'index']);
// API to make a crud to the project tasks
$router->get('/dashboard/project-tasks', [ProjectTasksController::class, 'read_project_tasks']);
$router->post('/api/project-tasks/create', [ProjectTasksController::class, 'create_project_tasks']);
$router->post('/api/project-tasks/update', [ProjectTasksController::class, 'update_project_tasks']);
$router->post('/api/project-tasks/delete', [ProjectTasksController::class, 'delete_project_tasks']);

// Page to view the tasks 
$router->get('/dashboard/tasks', [TasksController::class, 'index']);
// API to view the task and create the task with fetch async away 
$router->get('/api/tasks', [TasksController::class, 'read_tasks']);
$router->post('/api/task/create', [TasksController::class, 'create_task']);
$router->post('/api/task/update', [TasksController::class, 'update_task']);
$router->post('/api/task/delete', [TasksController::class, 'delete_task']);


// Check and validate the routes, which trigger and assign Controller functions to them
$router->rutes();