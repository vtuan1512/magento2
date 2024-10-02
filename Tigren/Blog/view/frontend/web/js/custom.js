/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

require([
    'Magento_Ui/js/modal/alert',
    'jquery'
], function(alert, $) {

    alert({
        title: $.mage.__('Hello world'),
        content: $.mage.__('dsadasd dsadsa da sdasdasda sdasdasdsad asdsadsad dasdsada'),
        actions: {
            always: function(){}
        }
    });

});

