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
 * @package    tool_gradebookreset
 * @copyright  2021 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $CFG;
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/gradelib.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/gradebookreset/forms/coursefilter.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/tool/gradebookreset/classes/GetGrades.php');

global  $PAGE, $OUTPUT;

$PAGE->set_url('/tool/gradebookreset/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('gradebookreset', 'tool_gradebookreset'));
$PAGE->set_heading(get_string('gradebookreset', 'tool_gradebookreset'));

$mform = new coursefilter();
$mform->set_data(array());
$mform->display();

echo $OUTPUT->footer();
