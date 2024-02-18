<?php
namespace Controllers;

use Model\Task;
use MVC\Router;

class TasksController {
    
    // view main for task
    public static function index(Router $router) {
        session_start();
        $router->render('dashboard/tasks/index', [
            'title' => 'Tasks'
        ]);
    }

    // read task
    public static function read_tasks() {
        session_start();
        $owner_id = $_SESSION['id'];
        $tasks = Task::belongsTo('owner_id', $owner_id);
        echo json_encode(['tasks' => $tasks]);
    }

    // create task
    public static function create_task() {
        session_start();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // instanced task model
            $task = new Task($_POST);
            // set ownerId
            $task->setOwnerId($_SESSION['id']);
            // set creation date
            $task->setCreateDate(date('l jS \of F Y'));
            // save task
            $result = $task->save();
            $response = [
                'type' => 'success',
                'id' => $result['id'],
                'creation_date' => $task->creation_date,
                'owner_id' => $task->owner_id,
                'task' => $task
            ];
            // send data with format json
            echo json_encode($response);
            
            // $response = [
            //     'message' => 'Enviando peticiones al servidor'
            // ];
            // echo json_encode($response);
        }
    }

    // update task 
    public static function update_task() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task($_POST);
            $result = $task->save();
            if($result) {
                $response = [
                    'type' => 'success',
                    'task' => $task->id,
                ];
            }
            echo json_encode($response);
        }
    }

    //delete task
    public static function delete_task() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $task = new Task($_POST);
            $result = $task->delete();
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