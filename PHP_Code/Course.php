<?php

/**
 * Description of Course
 *
 * @author Vishnu
 */
class Course {

    private $id;
    private $code;
    private $name;
    private $credits;
    private $lectures;
    private $tutorials;
    private $practicals;

    private function Course($id) {
        $code;
        $name;
        $credits;
        $lectures;
        $tutorials;
        $practicals;
        MySQL::query("SELECT code,name,credits,lectures,tutorials,practicals FROM courses WHERE id=?", $id, function ($row) use(&$code, &$name, &$credits, &$lectures, &$tutorials, &$practicals) {
            $code = $row["code"];
            $name = $row["name"];
            $credits = $row["credits"];
            $lectures = $row["lectures"];
            $tutorials = $row["tutorials"];
            $practicals = $row["practicals"];
        });
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->credits = $credits;
        $this->lectures = $lectures;
        $this->tutorials = $tutorials;
        $this->practicals = $practicals;
    }

    public static function withId($id) {
        $course = new Course($id);
        if ($course->getName())
            return $course;
        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function getCode() {
        return $this->code;
    }

    public function getName() {
        return $this->name;
    }

    public function getCredits() {
        return $this->credits;
    }

    public function getLectures() {
        return $this->lectures;
    }

    public function getTutorials() {
        return $this->tutorials;
    }

    public function getPracticals() {
        return $this->practicals;
    }

}
