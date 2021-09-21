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


defined('MOODLE_INTERNAL') || die;
require_once($CFG->libdir.'/externallib.php');

/**
 * External class.
 *
 * @package resetcoursecompletion
 * @copyright 2021 Brain Station 23
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_resetcoursecompletion_external extends external_api {
    /**
     * Returns description of method parameters.
     *
     * @return external_function_parameters
     */
    public static function reset_grades_parameters () {
        return new external_function_parameters(
            array(
                'userid' => new external_value(PARAM_INT, 'user id'),
            )
        );
    }

    /**
     * The function itself.
     * @param int $userid
     * @return array userid;
     */
    public static function reset_grades ($userid) {
        global $CFG;

        $params = array(
            'userid' => $userid
        );
        // Validate the params.
        self::validate_parameters(self::reset_grades_parameters(), $params);

        // TODO: Call reset_course_grade() from lib.php

        $response = array(
            'userid' => $userid
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
               'userid' => new external_value(PARAM_INT, 'id of the created user'),
               'warnings' => new external_warnings()
           )
       );
    }
}
