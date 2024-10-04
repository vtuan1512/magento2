/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

require(['jquery', 'Magento_Ui/js/modal/modal'], function ($) {
    'use strict';

    $.widget('tigren.tigrenWidget', {
        options: {
            buttonSelector: '.toggle-button',
            contentSelector: '.toggle-content',
        },

        _create: function () {
            var self = this;
            $(self.options.buttonSelector).on('click', function () {
                var content = $(self.options.contentSelector);
                content.toggle();
                if (content.is(':visible')) {
                    console.log('Show Content');
                } else {
                    console.log('Hide Content.');
                }
            });
        }
    });
    return $.tigren.tigrenWidget;
});
