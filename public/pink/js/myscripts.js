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
                        if (html.error) {
                            $('.wrap_result').css('color', 'red').append('<br><strong>Ошибка...</strong>' + html.error.join('<br>'));
                            $('.wrap_result').delay(2000).fadeOut(500);
                        }
                        else if (html.success) {
                            $('.wrap_result')
                                .append('<br><strong>Сохранено...</strong>')
                                .delay(2000)
                                .fadeOut(500,function () {

                                    if (html.data.parent_id > 0) {
                                        // это как-бы дочерний коммент., те ответ на уже существующий
                                        comParent.parents('div#respond').prev()
                                            .after('<ul class="children">' + html.comment + '</ul>');
                                    } else {
                                        // это родительский коммент. (до else - дочерний те ответ на уже существующий коммент)
                                        if ($.contains('#comments', 'ol.commentlist')) {
                                            $('ol.commentlist').append(html.comment);
                                        } else {
                                            $('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>');
                                        }
                                    }

                                    $('#cancel-comment-reply-link').click();
                                })
                        }
                    },
                    error: function () {
                        $('.wrap_result').css('color', 'red').append('<br><strong>Ошибка...</strong>');
                        $('.wrap_result').delay(3000).fadeOut(1000, function() {
                            $('#cancel-comment-reply-link').click();
                        });
                    }
                });
        });
    });

});