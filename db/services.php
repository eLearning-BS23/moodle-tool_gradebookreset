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

$functions = array(
    'tool_gradebookreset_reset_grades' => array(
        'classname' => 'tool_gradebookreset_external',
        'methodname' => 'reset_grades',
        'classpath'   => 'admin/tool/gradebookreset/classes/externallib.php',
        'description' => 'Call the reset course grade function.',
        'type' => 'write',
        'ajax'        => true,
        'capabilities' => '', // TODO: Need to add capabilities from access.php.
        'services'      => array(MOODLE_OFFICIAL_MOBILE_SERVICE)
    ),
);
