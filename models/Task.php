<?php

namespace Model;

class Task extends ActiveRecord {
    protected static $tabla = 'tasks';
    protected static $columnasDB = ['id', 'title', 'description', 'priority', 'owner_id', 'creation_date', 'state'];

    public $id;
    public $title;
    public $description;
    public $priority;
    public $owner_id;
    public $creation_date;
    public $state;

    public function __construct($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->priority = $args['priority'] ?? '';
        $this->owner_id = $args['owner_id'] ?? '';
        $this->creation_date = $args['creation_date'] ?? '';
        $this->state = $args['state'] ?? 'pending';
    }

    // Set creation time
    public function setCreateDate($createDate) {
        $this->creation_date = $createDate;
    }

    // Set the owner
    public function setOwnerId($ownerId) {
        $this->owner_id = $ownerId;
    }
}