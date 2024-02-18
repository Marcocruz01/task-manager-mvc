<?php

namespace Model;

class ProjectTasks extends ActiveRecord {
    protected static $tabla = 'project_tasks';
    public static $columnasDB = ['id', 'title', 'state', 'date', 'projectId'];

    public $id;
    public $title;
    public $state;
    public $date;
    public $projectId;

    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->state = $args['state'] ?? 'pending';
        $this->date = $args['date'] ?? '';
        $this->projectId = $args['projectId'] ?? '';
    }

    // Set creation time
    public function setCreateDate($createDate) {
        $this->date = $createDate;
    }
}

?>