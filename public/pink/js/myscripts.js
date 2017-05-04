jQuery(document).ready(function ($) {
    $('.commentlist li').each(function (i) {
        $(this).find('div.commentNumber').text('#' + (i+1));
    });

    $('#commentform').on('click','#submit', function (e) {
        // код ниже предотвращает дефолтовое поведение кнопы сабмит(а это отпр.формы и перерисовка стр)
        e.preventDefault();
        var comParent = $(this);
    });

});