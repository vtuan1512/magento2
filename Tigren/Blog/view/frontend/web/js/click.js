/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

define(['jquery'], function ($) {
    'use strict';

    return function () {
        $('.alert-button').on('click', function () {
            alert('Button clicked! This is a message from click.js.');
            console.log('Button clicked! Check the console for this log.');
        });
    };
});
