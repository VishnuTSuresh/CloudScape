<?php

/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";

class Programme {

    public static $PEMBA = 1;
    public static $PP = 2;
    public static $PST = 3;
    private $id;
    private $name;
    private $no_of_semesters;

    public static function getAll() {
        $programmes = array();
        MySQL::query("SELECT id FROM programmes", [], function ($row) use(&$programmes) {
            $programme= Programme::get($row["id"]);
            if($programme){
                $programmes[] =$programme;
            }
        });
        return $programmes;
    }

    private function Programme($id) {
        $name;
        $no_of_semesters;
        MySQL::query("SELECT name,no_of_semesters FROM programmes WHERE id=?", $id, function($row) use(&$name, &$no_of_semesters) {
            $name = $row["name"];
            $no_of_semesters = $row["no_of_semesters"];
        });
        $this->id = $id;
        $this->name = $name;
        $this->no_of_semesters = $no_of_semesters;
    }

    public static function get($id) {
        $programme = new Programme($id);
        if ($programme->getName()) {
            return $programme;
        }
        return null;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }

    public function getNoOfSemesters() {
        return $this->no_of_semesters;
    }
    public function getCourses($semester){
        $courses=array();
        MySQL::query("SELECT course_id FROM programme_course WHERE programme_id=? AND semester=?",[$this->id,$semester],function($row) use(&$courses){
            $course_id=$row["course_id"];
            $course=  Course::withId($course_id);
            if($course){
                $courses[]=$course;
            }
        });
        return $courses;
    }
}
