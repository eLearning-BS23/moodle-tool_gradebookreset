<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The Reset Course Completion grade report
 *
 * @package   resetcoursecompletion
 * @copyright 2021 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

class GetGrades{
    public function getresults(){
        global $DB, $courseid,$userid;
        $courses = $DB->get_records('course');
        $users = $DB->get_records('user');

        foreach ($users as $user){
            foreach ($courses as $course){
                $grading_info[$user->id][$course->shortname] = $this->execute_sql($course->id,$user->id);
            }
        }
        return array_filter($grading_info, 'array_filter');
    }
    public function execute_sql(){
        global $DB;
        $sql = "SELECT gg.userid,c.shortname AS shortname, CONCAT(mu.firstname, ' ', mu.lastname) AS fullname, gg.finalgrade AS finalgrade 
                FROM mdl_grade_items AS gi 
                    INNER JOIN mdl_course c ON c.id = $courseid 
                    LEFT JOIN mdl_grade_grades AS gg ON gg.itemid = gi.id 
                    INNER JOIN mdl_user AS mu ON gg.userid = mu.id 
                WHERE gi.itemtype = 'course' AND gg.userid = $userid";

        return $DB->get_records_sql($sql);
    }

    public function get_course_eroll_count(){
        global $DB;

        $sql = "SELECT course.shortname,COUNT(*) as total
    FROM mdl_course AS course 
    JOIN mdl_enrol AS en ON en.courseid = course.id
    JOIN mdl_user_enrolments AS ue ON ue.enrolid = en.id
    JOIN mdl_user AS user2 ON ue.userid = user2.id
    GROUP BY course.shortname";

        return $DB->get_records_sql($sql);
    }
}
