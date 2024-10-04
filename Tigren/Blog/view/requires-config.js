/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */
var config = {
    map: {
        '*': {
            custom: 'Tigren_Blog/js/custom',
            click: 'Tigren_Blog/js/click'
        }
    },
    shim: {
        'someNonAmdModule': {
            deps: ['jquery'],
            exports: 'someNonAmdModule'
        }
    }
};

