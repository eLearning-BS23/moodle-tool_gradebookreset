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
 * Course Filter form
 *
 * @package    tool_resetcoursecompletion
 * @copyright  BS-23
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("$CFG->libdir/formslib.php");

class coursefilter extends moodleform
{
    //Add elements to form
    public function definition()
    {
        global $CFG, $DB;
        $flag = 0;

        $courses = $DB->get_records('course', null);

        ?>
        <form autocomplete="off" action="<?= $CFG->wwwroot; ?>/admin/tool/resetcoursecompletion/participants_grade.php"
              method="get" accept-charset="utf-8" class="mform">
            <h4>Choose course name and participant to reset his/her course completion records</h4><br><br>
            <div id="fitem_id_courses" class="form-group row  fitem   ">
                <div class="col-md-3 col-form-label d-flex pb-0 pr-md-0">

                    <label class="d-inline word-break " for="id_courses">
                        Course Name
                    </label>

                    <div class="form-label-addon d-flex align-items-center align-self-start">

                    </div>
                </div>
                <div class="col-md-9 form-inline align-items-start felement" data-fieldtype="select">
                    <select class="custom-select" name="id" id="id_courses">
                        <?php
                            foreach ($courses as $course) {
                                echo '<option value="'.$course->id.'">'.$course->fullname.'</option>';
                            }
                        ?>
                    </select>
                    <div class="form-control-feedback invalid-feedback" id="id_error_courses">

                    </div>
                </div>
            </div>
            <div id="fitem_id_submit" class="form-group row  fitem femptylabel">
                <div class="col-md-3 col-form-label d-flex pb-0 pr-md-0">

                    <div class="form-label-addon d-flex align-items-center align-self-start">

                    </div>
                </div>
                <div class="col-md-9 form-inline align-items-start felement" data-fieldtype="submit">
                    <input type="submit" class="btn btn-primary" id="id_submit" value="Show Participants">
                    <div class="form-control-feedback invalid-feedback" id="id_error_submit">

                    </div>
                </div>
            </div>
        </form>
        <?php


    }

    //Custom validation should be added here
    public function validation($data, $files)
    {
        return array();
    }

}

