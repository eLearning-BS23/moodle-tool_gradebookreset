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
define(['jquery', 'core/modal_factory', 'core/modal_events'], function($, ModalFactory, ModalEvents) {
    $('.resetbutton').on('click', function(e) {
        var clickedLink = $(e.currentTarget);
        ModalFactory.create({
            type: ModalFactory.types.SAVE_CANCEL,
            title: 'Reset grade',
            body: 'Do you really want to reset?',
        }).then(function (modal) {
            modal.setSaveButtonText('Reset');
            var root = modal.getRoot();
            root.on(ModalEvents.save, function () {
                var elementid = clickedLink.data('id');
                // Do something to delete item
                console.log("Something");
            });
            modal.show();
        });
    });
});