<?php

namespace Controllers;

use Model\Project;
use MVC\Router;

class ProjectsController {

    // overview projects
    public static function index(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/projects/index', [
            'title' => 'Projects'
        ]);
    }

    // read projects from API
    public static function read_projects() {
        session_start();
        isAuth();
        $owner_id = $_SESSION['id'];
        if($owner_id !== $_SESSION['id']) header('/dashboard');
        $projects = Project::belongsTo('owner_id', $owner_id);
        echo json_encode(['projects' => $projects]);
    }

    // create projects form API
    public static function create_project() {
        session_start();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project($_POST);
            $project->setOwnerId($_SESSION['id']);
            $project->setUrl();
            $project->setCreateDate(date('d/M/y'));
            $result = $project->save();
            if($result) {
                $response = [
                    'type' => 'success',
                    'id' => $result['id'],
                    'project' => $project,
                    'owner_id' => $project->owner_id,
                    'creation_date' => $project->creation_date,
                    'url' => $project->url
                ];
            }
            echo json_encode($response);
        }
    }

    // update project
    public static function update_project() {
        session_start();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project($_POST);
            $result = $project->update();
            if($result) {
                $response = [
                    'type' => 'success',
                    'project' => $project
                ];
            }
            echo json_encode($response);
        }
    }

    // edite projects form API
    public static function delete_project() {
        session_start();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project = new Project($_POST);
            $result = $project->delete();
            if($result) {
                $response = [
                    'type' => 'success',
                ];
            }
            echo json_encode($response);
        }
    }
}