// define(['jquery','core/notification'], function($) {
//     $(document).ready(function ($,notification) {
//         //console.log("Hello world! from lib file");
//         $('.resetbutton').click(function () {
//             console.log($(this).attr('id'));
//             confirm("are you sure?");
//         });
//     });
//
// });
define(['jquery', 'core/ajax', 'core/modal_factory', 'core/modal_events', 'core/notification'],
    function($, Ajax, ModalFactory, ModalEvents, Notification) {
        $('.resetbutton').on('click', function(e) {
            var elementid = $(this).attr('id');
            var array = elementid.split("_");
            var userid = array[array.length - 2];
            var courseid = array[array.length - 1];
            var clickedLink = $(e.currentTarget);
            ModalFactory.create({
                type: ModalFactory.types.SAVE_CANCEL,
                title: 'Reset grade',
                body: 'Do you really want to reset?',
            }).then(function (modal) {
                modal.setSaveButtonText('Reset');
                var root = modal.getRoot();
                root.on(ModalEvents.save, function () {
                    //var elementid = clickedLink.data('id');
                    var wsfunction = 'tool_resetcoursecompletion_reset_grades';
                    var params = {
                        'userid': userid,
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
                            // Notification.addNotification({
                            //     message: 'Done!',
                            //     type: 'success'
                            // });
                            window.location.href = 'http://localhost/admin/tool/resetcoursecompletion/index.php';
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