$(function () {
    $('#page-loader').hide();

    $('[data-dropdown-toggle]').on('click', function () {
        $('#' + $(this).data('dropdown-toggle')).toggleClass('hidden');
    });

    $('[data-collapse-toggle]').on('click', function () {
        $('#' + $(this).data('collapse-toggle')).toggleClass('hidden');
    });

    $(window).click(function (e) {
        $('[data-dropdown-toggle]').each(function () {
            const dropdown = '#' + $(this).data('dropdown-toggle');

            if ($(e.target).closest(this).length == 0 && $(e.target).closest(dropdown).length == 0) {
                $(dropdown).addClass('hidden');
            }
        });
    });
});
