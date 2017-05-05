jQuery(document).ready(function ($) {
    $('.commentlist li').each(function (i) {
        $(this).find('div.commentNumber').text('#' + (i+1));
    });

    $('#commentform').on('click','#submit', function (e) {
        // строка ниже предотвращает (отменяет) дефолтовое поведение кнопы сабмит -
        // отправка формы и перерисовка стр. Это и есть начало ajax adding of comments
        e.preventDefault();
        var comParent = $(this);
        $('.wrap_result').
            css('color', 'green').
            text('Сохраниение комментария').
            fadeIn(500, function () {
                var data = $('#commentform').serializeArray();
                $.ajax({
                    url: $('#commentform').attr('action'),
                    data: data,
                    // строка headers: из доки по Ларавелу
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    datatype: 'JSON',
                    success: function(html) {

                    },
                    error: function () {

                    }
                });
        });
    });

});