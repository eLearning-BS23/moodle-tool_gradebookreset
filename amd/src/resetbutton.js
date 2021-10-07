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
 *  The Reset Course Completion grade report
 *
 * @module     tool_resetcoursecompletion
 * @copyright  2021 Brain station 23 ltd <>  {@link https://brainstation-23.com/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([
    'jquery',
    'core/ajax',
    'core/modal_factory',
    'core/modal_events',
    'core/notification'
],function($,
           Ajax,
           ModalFactory,
           ModalEvents,
           Notification) {

        $('.resetbutton').on('click', function(e) {
            // var user_elementid = $(this).attr('name');
            var myArray = [];
            var elementid = $(this).attr('id');
            // var userid = [];

            // console.log(user_elementid);
             console.log(elementid);

            $('.myCheckbox').each(function(k,V){
                if(V.checked)
                {
                    // console.log(V.value);

                    // var userid = new array(V.value);
                     myArray.push(V.value);
                     console.log(myArray);
                }
            })

            var array = elementid.split("_");
            var courseid = array[array.length - 1];


            var clickedLink = $(e.currentTarget);
            ModalFactory.create({
                type: ModalFactory.types.SAVE_CANCEL,
                title: 'Reset Grade Confirmation',
                body: 'Do you really want to reset?',
            }).then(function (modal) {
                modal.setSaveButtonText('Reset');
                var root = modal.getRoot();
                root.on(ModalEvents.save, function () {
                    var wsfunction = 'tool_resetcoursecompletion_reset_grades';
                    var params = {
                        // 'userid': userid,
                        'useridArray': myArray.join(','),
                        'courseid': courseid,
                    };
                    var request = {
                        methodname: wsfunction,
                        args: params
                    };
                    console.log(request);
                    Ajax.call([request])[0].done(function(data) {

                        if (data.warnings.length < 1) {

                            console.log("Response");
                            console.log(data);
                            window.location.href = `http://localhost/moodle/admin/tool/resetcoursecompletion/index.php?id=${courseid}&submit=Show+Participants`;
                        } else {
                            Notification.addNotification({
                                message: 'Something went wrong!',
                                type: 'error'
                            });
                        }
                    }).fail(Notification.exception);
                });
                modal.show();
        });
    });

});