/*
Template Name: Minton - Responsive Bootstrap 4 Admin Dashboard
Author: CoderThemes
Website: https://coderthemes.com/
Contact: support@coderthemes.com
File: Toastr init js
*/

!function ($) {
    'use strict';

    var NotificationApp = function () {
    };


    /**
     * Send Notification
     * @param {*} heading heading text
     * @param {*} body body text
     * @param {*} position position e.g top-right, top-left, bottom-left, etc
     * @param {*} loaderBgColor loader background color
     * @param {*} icon icon which needs to be displayed
     * @param {*} hideAfter automatically hide after seconds
     * @param {*} stack
     */
    NotificationApp.prototype.send = function (options) {

        // default
        var hideAfter;
        if (!options.hideAfter) {
            hideAfter = false;
        } else {
            hideAfter = options.hideAfter;
        }
        console.log(hideAfter);


        var options = {
            heading: options.heading,
            text: options.text,
            position: options.position,
            loaderBg: options.loaderBg,
            icon: options.icon,
            hideAfter: hideAfter,
            stack: !options.stack ? options.stack : 1
        };

        if (options.showHideTransition)
            options.showHideTransition = options.showHideTransition;
        $.toast().reset('all');
        $.toast(options);
    },
        $.NotificationApp = new NotificationApp, $.NotificationApp.Constructor = NotificationApp


}(window.jQuery),
    //initializing main application module
    function ($) {
        "use strict";
        var options = {
            heading: "Heads up!",
            text: "This alert needs your attention, but it is not super important.",
            position: 'top-right',
            loaderBg: '#3b98b5',
            icon: 'info'
        };
        // notification examples

        $("#toastr-one").on('click', function (e) {
            $.NotificationApp.send(options);
        });

        $("#toastr-two").on('click', function (e) {

            options = {
                heading: "Heads up!",
                text: "This alert needs your attention, but it is not super important.",
                position: 'top-center',
                loaderBg: '#da8609',
                icon: 'warning'
            };
            $.NotificationApp.send(options);
        });

        $("#toastr-three").on('click', function (e) {
            options = {
                heading: "Heads up!",
                text: "This alert needs your attention, but it is not super important.",
                position: 'top-right',
                loaderBg: '#5ba035',
                icon: 'success'
            };
            $.NotificationApp.send(options);
        });

        $("#toastr-four").on('click', function (e) {
            options = {
                heading: "Heads up!",
                text: "This alert needs your attention, but it is not super important.",
                position: 'top-right',
                loaderBg: '#bf441d',
                icon: 'error'
            };
            $.NotificationApp.send(options);
        });

        $("#toastr-five").on('click', function (e) {
                options = {
                    heading: "Heads up!",
                    text: [
                        'Fork the repository',
                        'Improve/extend the functionality',
                        'Create a pull request'
                    ],
                    position: 'top-right',
                    loaderBg: '#1ea69a',
                    icon: 'info'
                };
                $.NotificationApp.send(options);
            }
        );
        $("#toastr-six").on('click', function (e) {
            options = {
                heading: "Can I add <em>icons</em>?",
                text: "Yes! check this <a href='https://github.com/kamranahmedse/jquery-toast-plugin/commits/master'>update</a>.",
                position: 'top-right',
                loaderBg: '#1ea69a',
                icon: 'info',
            };
            $.NotificationApp.send(options);
        });

        $("#toastr-seven").on('click', function (e) {
            $.NotificationApp.send("", "Set the `hideAfter` property to false and the toast will become sticky.", 'top-right', '#1ea69a', '');
        });

        $("#toastr-eight").on('click', function (e) {
            $.NotificationApp.send("", "Set the `showHideTransition` property to fade|plain|slide to achieve different transitions.",
                'top-right', '#1ea69a', 'info', 3000, 1, 'fade');
        });

        $("#toastr-nine").on('click', function (e) {
            $.NotificationApp.send("Slide transition", "Set the `showHideTransition` property to fade|plain|slide to achieve different transitions.",
                'top-right', '#1ea69a', 'info', 3000, 1, 'slide');
        });

        $("#toastr-ten").on('click', function (e) {
            $.NotificationApp.send("Plain transition", "Set the `showHideTransition` property to fade|plain|slide to achieve different transitions.",
                'top-right', '#3b98b5', 'info', 3000, 1, 'plain');
        });
    }(window.jQuery);
