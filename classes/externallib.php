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
 * @package   gradebookreset
 * @copyright 2021 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

global $CFG;
require_once($CFG->libdir.'/externallib.php');

/**
 * External class.
 *
 * @package gradebookreset
 * @copyright 2021 Brain Station 23 ltd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_gradebookreset_external extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function reset_grades_parameters () {
        return new external_function_parameters(
            array(
                'useridArray' => new external_value(PARAM_RAW, 'user id Array'),
                'courseid' => new external_value(PARAM_INT, 'course id'),
            )
        );
    }

    /**
     * The function itself.
     * @param array $useridArray
     * @param int $courseid
     * @return array $response;
     * @throws dml_exception
     * @throws invalid_parameter_exception
     * @throws moodle_exception
     * @throws required_capability_exception
     */
    public static function reset_grades($useridArray, $courseid) {
        global $CFG, $DB, $USER, $SESSION;

        $params = array(
            'useridArray' => $useridArray,
            'courseid' => $courseid,
        );
        // Validate the params.
        self::validate_parameters(self::reset_grades_parameters(), $params);

        // TODO: Call reset_course_grade() from lib.php.

        require_once($CFG->libdir.'/gradelib.php');
        require_once($CFG->dirroot.'/user/renderer.php');
        require_once($CFG->dirroot.'/grade/lib.php');
        require_once($CFG->dirroot.'/admin/tool/gradebookreset/lib.php');

        // Basic access checks.
        if (!$course = $DB->get_record('course', array('id' => $courseid))) {
            print_error('invalidcourseid');
        }
        $context = context_course::instance($course->id);

        // The report object is recreated each time, save search information to SESSION object for future use.
        if (isset($graderreportsifirst)) {
            $SESSION->gradereport["filterfirstname-{$context->id}"] = $graderreportsifirst;
        }
        if (isset($graderreportsilast)) {
            $SESSION->gradereport["filtersurname-{$context->id}"] = $graderreportsilast;
        }

        require_capability('gradereport/grader:view', $context);
        require_capability('moodle/grade:viewall', $context);

        // Return tracking object.
        $gpr = new grade_plugin_return(
            array(
                'type' => 'report',
                'plugin' => 'gradebookreset',
                'course' => $course,
                'page' => 0,
            )
        );
        $edit = -1;

        // Last selected report session tracking.
        if (!isset($USER->grade_last_report)) {
            $USER->grade_last_report = array();
        }
        $USER->grade_last_report[$course->id] = 'grader';

        if (has_capability('moodle/grade:edit', $context)) {
            if (!isset($USER->gradeediting[$course->id])) {
                $USER->gradeediting[$course->id] = 0;
            }

            if (($edit == 1) and confirm_sesskey()) {
                $USER->gradeediting[$course->id] = 1;
            } else if (($edit == 0) and confirm_sesskey()) {
                $USER->gradeediting[$course->id] = 0;
            }

        } else {
            $USER->gradeediting[$course->id] = 0;
            $buttons = '';
        }

        $obj = new grade_report_reset($courseid, $gpr, $context, 0, 0);
        $obj->load_users();
        $obj->load_final_grades();

        $obj->reset_course_grade($useridArray);
        $response = array(
            'useridArray' => $useridArray,
            'courseid' => $courseid,
        );

        $response['warnings'] = [];
        return $response;
    }

    /**
     * Returns description of method result value
     * @return external_single_structure
     */
    public static function reset_grades_returns() {
       return new external_single_structure(
           array(
               'useridArray' => new external_value(PARAM_RAW, 'id of the selected users'),
               'courseid' => new external_value(PARAM_INT, 'course id'),
               'warnings' => new external_warnings()
           )
        );
    }
}
