<?php
namespace Model;

class Project extends ActiveRecord
{
    protected static $tabla = 'projects';
    protected static $columnasDB = ['id', 'name', 'url', 'creation_date', 'owner_id'];

    public $id;
    public $name;
    public $url;
    public $creation_date;
    public $owner_id;

    public function __construct ($args = []) 
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->creation_date = $args['creation_date'] ?? '';
        $this->owner_id = $args['owner_id'] ?? '';
    }

    // generate random tokens for temporary validation
    public function setUrl(): void
    {
        $this->url = md5(uniqid());
    }
    
    // Set creation date
    public function setCreateDate($creation_date) {
        $this->creation_date = $creation_date;
    }

    // set the ownerId to the variable
    public function setOwnerId($owner_id) {
        $this->owner_id = $owner_id;
    }
}


?>