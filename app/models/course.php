<?php

class Course extends BaseModel {
    
    public $id, $name, $subjectCount;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Course');

        $query->execute();

        $rows = $query->fetchAll();
        $courses = array();

        foreach ($rows as $row) {
            $courses[] = new Course(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
        return $courses;
    }
    
    public static function findId($id) {
        $query = DB::connection()->prepare('SELECT * FROM Course WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $course = new Course(array(
                'id' => $row['id'],
                'name' => $row['name']
            ));
            return $course;
        }
        return null;
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO course (name) VALUES (:name) RETURNING id');
        
        $query->execute(array('name' => $this->name));
        
        $row = $query->fetch();
        
        $this->id = $row['id'];
    }
    
    
    
    
}

