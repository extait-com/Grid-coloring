/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the commercial license
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category Extait
 * @package Extait_Highlighter
 * @copyright Copyright (c) 2016-2018 Extait, Inc. (http://www.extait.com)
 */

define([
    'Magento_Ui/js/grid/listing'
], function (Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Extait_Highlighter/grid/listing'
        },

        getColors: function(row) {
            var color = [];
            if (row["back_color"] !== "undefined" && row["back_color"] !== "") {
                color.push("background-color: " + row["back_color"]);
            }
            if (row["text_color"] !== "undefined" && row["text_color"] !== "") {
                color.push("color: " + row["text_color"]);
            }

            return color.join('; ');
        }
    });
});