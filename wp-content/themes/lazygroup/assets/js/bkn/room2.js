$(function() {

    //間取りも拡大
    $(function() {
        $('a.pht-right img').click(function() {
            var id = $(this).attr('id');
            $('#gallery').attr('data-madori', id);
        });
    });

    //パネル表示
    $('ul.panel li.hide').hide();
    $('ul.panel li.hide').first().show();
    $('#tab ul li span img.on').hide();
    $('#tab ul li span img.on').first().show();
    $('#tab ul li span img.off').first().hide();

    $('ul.tab li span').click(function() {
        $('.tab li span').removeClass('selected');
        $(this).addClass('selected');
        $('ul.panel li.hide').hide();
        $('#' + $(this).attr('class').slice(0, 4)).show();
        $('#tab ul li span img.on').hide();
        $('#tab ul li span img.off').show();
        $(this).children('img.on').show();
        $(this).children('img.off').hide();
        return false;
    });
});
