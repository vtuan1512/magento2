define([
    'jquery'
], function ($) {
    'use strict';

    $.widget('tigrenButton.example', {
        _create: function () {
            var self = this;

            this.element.find('[data-role="showContent"]').on('click', function () {
                var row = $(this).closest('tr');
                var colorPicker = row.find('input[type="color"]');
                row.find('[data-role="content"]').show();
                var selectedColor = colorPicker.val() || 'black';
                row.css({
                    'color': selectedColor,
                    'font-family': 'Arial',
                    'background-color': '#f2f2f2'
                });
                console.log('Change color to ' + selectedColor + ' for row with ID: ' + row.find('td:first').text());
            });
            this.element.find('[data-role="hideContent"]').on('click', function () {
                var row = $(this).closest('tr');
                row.find('[data-role="content"]').hide();
                row.css({
                    'color': '',
                    'font-family': '',
                    'background-color': ''
                });
                console.log('Change to default for row with ID: ' + row.find('td:first').text());
            });
        }
    });

    return $.tigrenButton.example;
});
