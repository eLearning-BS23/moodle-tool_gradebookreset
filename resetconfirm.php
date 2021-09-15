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
 * @package    tool_resetcoursecompletion
 * @copyright  2021 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once (__DIR__.'/../../../config.php');

global $DB;


$PAGE->set_url('/tool/resetcoursecompletion/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('resetcoursecompletion', 'tool_resetcoursecompletion'));
$PAGE->set_heading(get_string('resetcoursecompletion', 'tool_resetcoursecompletion'));


echo $OUTPUT-> header();


$PAGE->set_title(get_string('resetcoursecompletion', 'tool_resetcoursecompletion'));
$PAGE->set_heading(get_string('reset_confirm', 'tool_resetcoursecompletion'));


echo $OUTPUT->footer();

