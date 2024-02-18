<?php

namespace Controllers;

use Model\Project;
use Model\ProjectTasks;
use MVC\Router;

class ProjectTasksController {

    // view project
    public static function index(Router $router) {
        session_start();
        isAuth();
        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard/projects');
        $project = Project::where('url', $token);
        if($project->owner_id !== $_SESSION['id']) {
            header('Location: /dashboard/projects');
        }
        // review and validate 
        $router->render('dashboard/project', [
            'title' => $project->name
        ]);
    }

    public static function read_project_tasks() {
        session_start();
        $project_id = $_GET['id'];
        $project = Project::where('url', $project_id);
        $tasks =  ProjectTasks::belongsTo('projectId', $project->id);
        echo json_encode(['tasks' => $tasks]);
    }

    public static function create_project_tasks() {
        date_default_timezone_set('America/Mexico_City');
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            isAuth();
            $projectId = $_POST['projectId'];
            $project = Project::where('url', $projectId);   
            // if result is OK
            $tasks = new ProjectTasks($_POST);
            $tasks->projectId = $project->id;
            // set creation date
            $tasks->setCreateDate(date('Y-m-d H:i:s'));
            $result = $tasks->save();
            if($result) {
                $response = [
                    'type' => 'success',
                    'date' => $tasks->date,
                    'projectId' => $tasks->projectId,
                    'id' => $result['id'],
                ];
            }
            echo json_encode($response);
        }
    }

    public static function update_project_tasks() {
        date_default_timezone_set('America/Mexico_City');
        session_start();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['projectId'];
            $project = Project::where('url', $projectId); 
              
            // if result is OK
            $tasks = new ProjectTasks($_POST);
            $taskId = $_POST['id'];
            $tasks = ProjectTasks::find($taskId);
            $tasks->projectId = $project->id;
            $tasks->title = $_POST['title'];
            $tasks->state = $_POST['state'];
            $result = $tasks->save();

            if ($result) {
                $response = [
                    'type' => 'success',
                    'date' => $tasks->date,
                    'projectId' => $tasks->projectId,
                    'id' => $tasks->id,
                ];
            }
            echo json_encode($response);
        }
    }

    public static function delete_project_tasks() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tasks = new ProjectTasks($_POST);
            $result = $tasks->delete();
            if($result) {
                $response = [
                    'type' => 'success'
                ];
            }
            echo json_encode($response);
        }
    }
}
?>