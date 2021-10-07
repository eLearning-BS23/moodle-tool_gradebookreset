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
 * @copyright  2021 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


    require_once('../../../config.php');
    require_once($CFG->libdir.'/gradelib.php');
    require_once($CFG->dirroot.'/user/renderer.php');
    require_once($CFG->dirroot.'/grade/lib.php');
    require_once($CFG->dirroot.'/admin/tool/resetcoursecompletion/lib.php');
    require_once("$CFG->libdir/formslib.php");



    $courseid      = optional_param('id', 1,  PARAM_INT);        // course id
    $page          = optional_param('page', 0, PARAM_INT);   // active page
    $edit          = optional_param('edit', -1, PARAM_BOOL); // sticky editting mode

    $sortitemid    = optional_param('sortitemid', 0, PARAM_ALPHANUM); // sort by which grade item
    $action        = optional_param('action', 0, PARAM_ALPHAEXT);
    $move          = optional_param('move', 0, PARAM_INT);
    $type          = optional_param('type', 0, PARAM_ALPHA);
    $target        = optional_param('target', 0, PARAM_ALPHANUM);
    $toggle        = optional_param('toggle', null, PARAM_INT);
    $toggle_type   = optional_param('toggle_type', 0, PARAM_ALPHANUM);

    $graderreportsifirst  = optional_param('sifirst', null, PARAM_NOTAGS);
    $graderreportsilast   = optional_param('silast', null, PARAM_NOTAGS);


    $PAGE->set_url(new moodle_url('/grade/report/grader/index.php', array('id'=>$courseid)));
    $PAGE->requires->yui_module('moodle-resetcoursecompletion_grade-gradereporttable', 'Y.M.resetcoursecompletion_grade.init', null, null, true);
    $PAGE->requires->js_call_amd('tool_resetcoursecompletion/resetbutton', 'init', array());

    // basic access checks
    if (!$course = $DB->get_record('course', array('id' => $courseid))) {
        print_error('invalidcourseid');
    }
    require_login($course);
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

// return tracking object
    $gpr = new grade_plugin_return(
        array(
            'type' => 'report',
            'plugin' => 'resetcoursecompletion',
            'course' => $course,
            'page' => $page
        )
    );

// last selected report session tracking
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

    $gradeserror = array();

    $reportname = get_string('pluginname', 'tool_resetcoursecompletion');

    echo $OUTPUT->header();
    echo "<h1>".$reportname."</h1>";

//Initialise the grader report object that produces the table
//the class grade_report_reset_ajax was removed as part of MDL-21562
    $report = new grade_report_reset($courseid, $gpr, $context, $page, $sortitemid);
    $numusers = $report->get_numusers(true, true);

// final grades MUST be loaded after the processing
    $report->load_users();
    $report->load_final_grades();
    echo $report->group_selector;

//// User search
    $url = new moodle_url('/admin/tool/resetcoursecompletion/index.php', array('id' => $course->id));
    $firstinitial = $SESSION->gradereport["filterfirstname-{$context->id}"] ?? '';
    $lastinitial  = $SESSION->gradereport["filtersurname-{$context->id}"] ?? '';
    $totalusers = $report->get_numusers(true, false);
    $renderer = $PAGE->get_renderer('core_user');
//    echo $renderer->user_search($url, $firstinitial, $lastinitial, $numusers, $totalusers, $report->currentgroupname);


//show warnings if any
    foreach ($warnings as $warning) {
        echo $OUTPUT->notification($warning);
    }


    $displayaverages = true;
    if ($numusers == 0) {
        $displayaverages = false;
    }

    $reporthtml = $report->get_grade_table($displayaverages);


////printing the grade report
//    echo $reporthtml;


// prints paging bar at bottom for large pages
    if (!empty($studentsperpage) && $studentsperpage >= 20) {
        echo $OUTPUT->paging_bar($numusers, $report->page, $studentsperpage, $report->pbarurl);
    }



class coursefilter extends moodleform
{
    //Add elements to form
    /**
* @throws dml_exception
*/public function definition()
    {
        global $CFG, $DB;
        $flag = 0;

        $courses = $DB->get_records('course', null);

        ?>

        <form autocomplete="off" method="GET" accept-charset="utf-8" class="mform">
            <h4>Choose course name to see participants grade records</h4><br><br>
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
                    <input type="submit" name="submit" class="btn btn-primary" id="id_submit" value="Show Participants">
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
?>
<?php
if(isset($_GET['submit'])) {
    echo $renderer->user_search($url, $firstinitial, $lastinitial, $numusers, $totalusers, $report->currentgroupname);
    //printing the grade report
    echo $reporthtml;
    //show multiple select button
    $report->delete_multiple_button();


}
?>
