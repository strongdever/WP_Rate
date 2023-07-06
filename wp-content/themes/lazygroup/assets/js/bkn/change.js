$(function(){
    //部屋詳細で発動 棟詳細はbkn.js
    var timerId = 0;
    $(".disp_list").hover(function(){
        var img_src   = $(this).children("img").attr("src");
        var img_title = $(this).children("img").attr("title");
        var img_alt   = $(this).children("img").attr("alt");
        var img_id   = $(this).children("img").attr("id");
        var img_comment = $(this).children('img').attr('data-comment');
        timerId = setTimeout(function() {
	        $("#img_main").children("a").children("img").attr("src",img_src);
	        $("#img_main").children("a").children("img").attr("title",img_title);
	        $("#img_main").children("a").children("img").attr("alt",img_alt);
	        $("#img_main").children("a").children("img").removeClass();
	        $("#img_main").children("a").children("img").addClass(img_id);
	        $('#img_main').children('p.comment').text(img_comment);
	        $('.comment').text(img_comment)
	     }, 300);
	}, function() {
        clearTimeout(timerId);
	});
    $(".disp_list").click(function(){
        $("#img_main a img").click();
    });

    // 表面利回り、ローン目安の値を印刷ページに渡す
    // 表面利回り、ローン目安の値がある時しか「#printLink」は存在しない
    $('#printLink').on('click', function() {

        var bknId = $('input:hidden[name="room_id"]').val();

        // 表面利回り
        var rimawari = $('#assume_rimawari').val();
        if (!empty(rimawari)) {
            var rimawariParam  = '&rimawari=' + rimawari.replace('%', '');
        } else {
            var rimawariParam = '';
        }

        // ローン目安
        var loan = $('#monthPay').val();
        if (!empty(loan)) {
            loan        = loan.replace('円/月', '').replace(',', '');
            var monthlyPaysParam = '&loan=' + Math.round(loan / 1000) / 10;
        } else {
            var monthlyPaysParam = '';
        }

        // 表面利回りとローン目安を印刷ページに渡す
        window.open('/bkn/index/print/?bknId=' + bknId + rimawariParam + monthlyPaysParam, 'sub', 'width=1024,height=800,scrollbars=yes,location=no,menubar=yes');
    });

});
