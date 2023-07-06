/**
 * @name        jQuery FullScreen Plugin
 * @author      Martin Angelov, Morten Sjøgren
 * @version     1.1
 * @url         http://tutorialzine.com/2012/02/enhance-your-website-fullscreen-api/
 * @license     MIT License
 */

/*jshint browser: true, jquery: true */
(function($){

    "use strict";

    // These helper functions available only to our plugin scope.
    function supportFullScreen(){
        var doc = document.documentElement;

        return ('requestFullscreen' in doc) ||
                ('mozRequestFullScreen' in doc && document.mozFullScreenEnabled) ||
                ('webkitRequestFullScreen' in doc);
    }

    function requestFullScreen(elem){
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen();
        }
    }

    function fullScreenStatus(){
        return document.fullscreen ||
                document.mozFullScreen ||
                document.webkitIsFullScreen ||
                false;
    }

    function cancelFullScreen(){
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
        $(document).off( 'fullscreenchange mozfullscreenchange webkitfullscreenchange' );
    }

    function onFullScreenEvent(callback){
        $(document).on("fullscreenchange mozfullscreenchange webkitfullscreenchange", function(){
            // The full screen status is automatically
            // passed to our callback as an argument.
            callback(fullScreenStatus());
        });
    }

    // Adding a new test to the jQuery support object
    $.support.fullscreen = supportFullScreen();

    // Creating the plugin
    $.fn.fullScreen = function(props){
        if(!$.support.fullscreen || this.length !== 1) {
            // The plugin can be called only
            // on one element at a time

            return this;
        }

        if(fullScreenStatus()){
            // if we are already in fullscreen, exit
            cancelFullScreen();
            return this;
        }

        // You can potentially pas two arguments a color
        // for the background and a callback function

        var options = $.extend({
            'background'      : '#000',
            'callback'        : $.noop( ),
            'fullscreenClass' : 'fullScreen'
        }, props),

        elem = this,

        // This temporary div is the element that is
        // actually going to be enlarged in full screen

        fs = $('<div>', {
            'css' : {
                'overflow-y' : 'auto',
                'background' : options.background,
                'width'      : '100%',
                'height'     : '100%'
            }
        })
            .insertBefore(elem)
            .append(elem);

        // You can use the .fullScreen class to
        // apply styling to your element
        elem.addClass( options.fullscreenClass );

        // Inserting our element in the temporary
        // div, after which we zoom it in fullscreen

        requestFullScreen(fs.get(0));



        //メイン画像をセンタリングするためにウィンドウサイズ取得
        $(window).resize(function(){
            var winH = $(window).height();
            var winW = $(window).width();

        //そしてCSSを書き換える
            $('#article .fullScreen, #article .fullScreen .pht, #article .fullScreen #img_main, #tab1').css({"width":winW+"px","height":winH+"px"});
            $('#article .fullScreen #img_main').css({"layout-grid-line:":winH+"px"});
         });


        //サムネイル表示NO．取得
            var dImg = $(".gallery img").attr("class");
            var Num = Number(dImg.replace('d_img_', ''));
        //サムネイル総数取得
            var maxNum = $('#tab1 ul li').length-1;
            if(Num <= 1){
        //もし一枚目が表示されてたら、前へボタンを非表示にする
                $("#fullscreenPrev").css('display', 'none');
            }
        //もし最後のサムネイルが表示されたら次へボタンを非表示にする
            if(Num == maxNum){
                $("#fullscreenNext").css('display', 'none');
            }


        //次へボタンの装飾
            $("#fullscreenNext").hover(function(e){
                $("#fullscreenNext img").animate({'height':'60px','margin-top':'-7.5px'})
            },function(){
                $("#fullscreenNext img").animate({'height':'45px','margin-top':'0px'})
            });
        //前へボタンの装飾
            $("#fullscreenPrev").hover(function(e){
                $("#fullscreenPrev img").animate({'height':'60px','margin-top':'-7.5px'})
            },function(){
                $("#fullscreenPrev img").animate({'height':'45px','margin-top':'0px'})
            });
        //次へボタンで一枚ずつ送る
            $("#fullscreenNext").click(function(e){
                $("#fullscreenPrev").css('display', 'block');
                var dImg = $(".gallery img").attr("class");
                var Num = 'd_img_'+(Number(dImg.replace('d_img_', ''))+1);
                parent.$(".gallery img").removeClass().attr("src",$('#'+Num).attr("src")).addClass(Num);
            //もし最後のサムネイルが表示されたら次へボタンを非表示にする
                if(Num =='d_img_'+maxNum){
                    $("#fullscreenNext").css('display', 'none');
                }
            });

        //前へボタンで一枚ずつ送る
            $("#fullscreenPrev").click(function(e){
                $("#fullscreenNext").css('display', 'block');
                var dImg = $(".gallery img").attr("class");
                var Num = 'd_img_'+(Number(dImg.replace('d_img_', ''))-1);
            //もし最初のサムネイルが表示されたら前へボタンを非表示にする
                parent.$(".gallery img").removeClass().attr("src",$('#'+Num).attr("src")).addClass(Num);
                if(Num =='d_img_0'){
                    $("#fullscreenPrev").css('display', 'none');
                }
            });

        //閉じる時いろいろ戻す
            $('#fullscreenClose').click(function(e){
                parent.$.fn.colorbox.close();
                $('#fullscreenClose').hide();
                parent.$('#article div, #article ul').css('background','#fff');
                parent.$('.pht-left').css('width','329px');
                parent.$('#fullscreen, #ctrlHide,#fullscreenPrev,#fullscreenNext').css( 'display','none');
                parent.$('body').css( 'overflow-y','auto');
                parent.$(".panel").removeClass("fullScreen");
                parent.$(".panel").css({"width":"700px","height":"100%"});
                $('#fullscreenPrev,#fullscreenNext').css( 'display','none');
                $('#article .pht').css({"width":"auto","height":"auto"});
                $('#article #img_main').css({"layout-grid-line":"auto","width":"329","height":"auto"});
                $('#tab1').css({"width":"700px","height":"100%"});
                $('.img-list').css('display', 'block');
                $('#img_main').css('height','329px');
                $('#gallery').css({"max-width":"329px","max-height":"329px"});
                cancelFullScreen();
            });



        fs.click(function(e){
            if(e.target == this){
                // If the black bar was clicked
                cancelFullScreen();
            }
        });

        elem.cancel = function(){
            cancelFullScreen();
            return elem;
        };

        onFullScreenEvent(function(fullScreen){
            if(!fullScreen){
                // We have exited full screen.
                // Remove the class and destroy
                // the temporary div
            //閉じる時いろいろ戻す
                parent.$.fn.colorbox.close();
                $('#fullscreenClose').hide();
                parent.$('#article div, #article ul').css('background','#fff');
                parent.$('.pht-left').css('width','329px');
                parent.$('#fullscreen, #ctrlHide,#fullscreenPrev,#fullscreenNext').css( 'display','none');
                parent.$('body').css( 'overflow-y','auto');
                parent.$(".panel").removeClass("fullScreen");
                parent.$(".panel").css({"width":"700px","height":"100%"});
                $('#fullscreenPrev,#fullscreenNext').css( 'display','none');
                $('#article .pht').css({"width":"auto","height":"auto"});
                $('#article #img_main').css({"layout-grid-line":"auto","width":"329","height":"auto"});
                $('#tab1').css({"width":"700px","height":"100%"});
                $('.img-list').css('display', 'block');
                $('#img_main').css('height','329px');
                $('#gallery').css({"max-width":"329px","max-height":"329px"});
                cancelFullScreen();


                elem.removeClass( options.fullscreenClass ).insertBefore(fs);
                fs.remove();
            }

            // Calling the user supplied callback
            options.callback(fullScreen);
        });

        return elem;
    };

    $.fn.cancelFullScreen = function( ) {
            cancelFullScreen();

            return this;
    };
}(jQuery));
