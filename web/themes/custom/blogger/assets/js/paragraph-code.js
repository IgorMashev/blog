(function ($, Drupal) {

    Drupal.behaviors.paragraphCodeHighlight = {
        attach: function (context, settings) {
            const elements = $(context).find('pre code');

            console.log(elements);
            if (elements.length) {
                $.each(elements, (key, element) => {
                    hljs.highlightBlock(element);
                });
            }
        }
    };

})(jQuery, Drupal);
