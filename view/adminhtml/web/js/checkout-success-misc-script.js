define([
    'jquery'
], function ($) {

    return{
        checkoutSuccessMiscScript: function (options, element) {
            $(element).on('click', this.processTemplateVar.bind(this, options.textareaId, element));
        },
        processTemplateVar: function (textareaId, element) {

            var $textarea = $('#' + textareaId);

            var startCursorPos = $textarea.prop('selectionStart');
            var endCursorPos = $textarea.prop('selectionEnd');
            var v = $textarea.val();

            if (endCursorPos > startCursorPos) {
                v = v.slice(0, startCursorPos) + v.slice(endCursorPos);
            }

            var textBefore = v.substring(0,  startCursorPos);
            var textAfter = v.substring(startCursorPos, v.length);
            $textarea.val(textBefore + $(element).text() + textAfter);
        }
    }

});