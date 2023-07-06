$(function() {

    /**
     * 価格・返済期間・金利・頭金を定義。設定されていればその値を代入
     */
    // 価格を「万円」に変換する。
    // ex) 1億円       → 10000万円 に変換
    // ex) 1億0500万円 → 10500万円 に変換
    // ex) 1億3000万円 → 13000万円 に変換
    var $spanPrice = $('.basicInfo__wrapper span.basicInfo__price');
    var priceText  = $spanPrice.text();
    var price      = 0;
    if (priceText.indexOf('億') !== -1) {
        // 1億円以上の場合
        price = parseFloat($spanPrice.eq(0).text()) * 10000;
        // 億未満の部分があるときは、カンマを除いて足し算する
        if (!empty($spanPrice.eq(1).text())) {
            price = price + parseFloat($spanPrice.eq(1).text().replace(',', ''));
        }
        price = String(price);
    } else {
        // 億に満たない場合
        price = $spanPrice.text();
    }
    // 計算の邪魔なのでカンマ・単位を除去
    price = price.replace(',', '');
    price = price.replace('万円', '');

    // 返済期間のデフォルト
    var PERIOD = '35';
    if ($('input[name="loanPeriod"]').val()) {
        PERIOD = $('input[name="loanPeriod"]').val();
    }

    // 金利のデフォルト
    var RATIO = '2.000';
    if ($('input[name="loanRate"]').val()) {
        RATIO = $('input[name="loanRate"]').val();
    }

    // 頭金のデフォルト
    var INITIAL = '0';
    if ($('input[name="loanInitial"]').val()) {
        INITIAL = $('input[name="loanInitial"]').val();
    }

    var alertFlg    = true;
    var alertCount  = '0';// アラートの出現回数を制限
    var numberCount = '0';// 数字を入れるアラートの出現制限
    var overCount   = '0';// 値が大きいアラートの出現制限
    var underCount  = '0';// 値が小さいアラートの出現制限
    var BONUS       = '0';//ボーナスのデフォルト

    //初期値を設定
    init();
    periodInit();
    rateInit();
    bonusInit();

    //借入金額のプラスボタンを押す
    $('#borrowPlus').on('click', function() {
        if ((parseInt($('#initial').attr('value')) - 100) >= 0) {
            borrowUp();
        } else if ((parseInt($('#initial').attr('value')) - 100) > -100) {
            initialZero();
        }
    });

    //借入金額のマイナスボタンを押す
    $('#borrowMinus').on('click', function() {
        if ((parseInt($('#borrow').attr('value')) - 100) >= 0) {
            borrowDown();
        } else if ((parseInt($('#borrow').attr('value')) - 100) > -100) {
            borrowZero();
        }
    });

    // 頭金のプラスボタンを押す
    $('#initialPlus').on('click', function() {
        if ((parseInt($('#borrow').attr('value')) - 100) >= 0) {
            borrowDown();
        } else if ((parseInt($('#borrow').attr('value')) - 100) > -100) {
            borrowZero();
        }
    });

    // 頭金金額のマイナスボタンを押す
    $('#initialMinus').on('click', function() {
        if ((parseInt($('#initial').attr('value')) - 100) >= 0) {
            borrowUp();
        } else if ((parseInt($('#initial').attr('value')) - 100) > -100) {
            initialZero();
        }
    });

    // 返済期間のプラスボタンを押す
    $('#periodPlus').on('click', function() {
        if ((parseInt($('#period').attr('value')) - 50) < 0) periodUp();
    });

    // 返済期間のマイナスボタンを押す
    $('#periodMinus').on('click', function() {
        if ((parseInt($('#period').attr('value')) - 5) > 0) periodDown();
    });

    // ボーナスのプラスボタンを押す
    $('#bonusPlus').on('click', function() {
        if ((parseInt($('#bonus').attr('value')) - 1000) < 0) bonusUp();
    });

    // ボーナスのマイナスボタンを押す
    $('#bonusMinus').on('click', function() {
        if ((parseInt($('#bonus').attr('value')) - 10) >= 0) bonusDown();
    });

    // 金利のプラスボタンを押す
    $('#ratePlus').on('click', function() {
        if ((parseFloat($('#rate').attr('value')) + 0.1) <= 5) rateUp();
    });

    // 金利のマイナスボタンを押す
    $('#rateMinus').on('click', function() {
        if ((parseFloat($('#rate').attr('value')) - 0.1) > 0) rateDown();
    });

    // 借入金額が100万増、頭金100万減
    function borrowUp() {
        var borrow  = parseInt($('#borrow').attr('value')) + 100;
        var initial = parseInt($('#initial').attr('value')) - 100;
        $('#borrow').attr('value', borrow + '万円');
        $('#initial').attr('value', initial + '万円');
        $.cookie('initial', initial, {
            expires: 30,
            path   : '/'
        });
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 借入金額が100万減、頭金100万増
    function borrowDown() {
        var borrow  = parseInt($('#borrow').attr('value')) - 100;
        var initial = parseInt($('#initial').attr('value')) + 100;
        $('#borrow').attr('value', borrow + '万円');
        $('#initial').attr('value', initial + '万円');
        $.cookie('initial', initial, {
            expires: 30,
            path   : '/'
        });
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 借入金の残高が100万円未満でマイナスボタンを押すとゼロにする
    function borrowZero() {
        $('#borrow').attr('value', '0万円');
        $('#initial').attr('value', price + '万円');
        calculate();
    }

    // 頭金の残高が100万円未満でマイナスボタンを押すとゼロにする
    function initialZero() {
        $('#initial').attr('value', '0万円');
        $('#borrow').attr('value', price + '万円');
        calculate();
    }

    // ボーナスを増やす
    function bonusUp() {
        var bonus = parseInt($('#bonus').attr('value')) + 10;
        $('#bonus').attr('value', bonus + '万円');
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // ボーナスを減らす
    function bonusDown() {
        var bonus = parseInt($('#bonus').attr('value')) - 10;
        $('#bonus').attr('value', bonus + '万円');
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 返済期間を増やす
    function periodUp() {
        var period = parseInt($('#period').attr('value')) + 1;
        $('#period').attr('value', period + '年');
        //決定した値を保存
        $.cookie('period', period, {
            expires: 30,
            path   : '/'
        });
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 返済期間を減らす
    function periodDown() {
        var period = parseInt($('#period').attr('value')) - 1;
        $('#period').attr('value', period + '年');
        //決定した値を保存
        $.cookie('period', period, {
            expires: 30,
            path   : '/'
        });
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 金利を増やす
    function rateUp() {
        var rate = new Number(Math.round((parseFloat($('#rate').attr('value')) + 0.1) * 1000) / 1000);
        rate     = rate.toFixed(3);
        $('#rate').attr('value', rate + '%');
        //決定した値を保存
        $.cookie('rate', rate, {
            expires: 30,
            path   : '/'
        });
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 金利を減らす
    function rateDown() {
        var rate = new Number(Math.round((parseFloat($('#rate').attr('value')) - 0.1) * 1000) / 1000);
        rate     = rate.toFixed(3);
        $('#rate').attr('value', rate + '%');
        //決定した値を保存
        $.cookie('rate', rate, {
            expires: 30,
            path   : '/'
        });
        alertFlg   = true;
        alertCount = '0';
        calculate();
    }

    // 直接借入金額を入力
    $('#borrow').bind('blur', function() {

        if ($('#borrow').attr('value') === '万円') {
            var borrow = 0;
        } else {
            var borrow = parseInt($('#borrow').attr('value'));
        }

        if (!isNumeric(borrow)) {
            if (numberCount === '0') {
                alert('数字を入力してください');
            }
            numberCount = '1';
            init();
        } else if (borrow > price) {
            if (overCount === '0') {
                alert('価格を超えています');
            }
            overCount = '1';
            init();
        } else {
            $('#borrow').attr('value', borrow + '万円');
            $('#initial').attr('value', (price - borrow) + '万円');
            alertFlg = true;
            calculate();
        }
    });

    // 直接頭金を入力
    $('#initial').bind('blur', function() {

        if ($('#initial').attr('value') === '万円') {
            var initial = 0;
        } else {
            var initial = parseInt($('#initial').attr('value'));
        }

        if (!isNumeric(initial)) {
            if (numberCount === '0') {
                alert('数字を入力してください');
            }
            numberCount = '1';
            init();
        } else if (initial > price) {
            if (overCount === '0') {
                alert('価格を超えています');
            }
            overCount = '1';
            init();
        } else {
            $('#initial').attr('value', initial + '万円');
            $('#borrow').attr('value', (price - initial) + '万円');
            alertFlg = true;
            calculate();
        }
    });

    // 直接返済期間を入力
    $('#period').bind('blur', function() {

        if ($('#period').attr('value') === '年') {
            var period = PERIOD;
        } else {
            var period = parseInt($('#period').attr('value'));
        }

        if (!isNumeric(period)) {
            if (numberCount === '0') {
                alert('数字を入力してください');
            }
            numberCount = '1';
            periodInit();
        } else if (period > 50) {
            if (overCount === '0') {
                alert('50年より小さい数字を入力してください');
            }
            overCount = '1';
            periodInit();
        } else if (period < 5) {
            if (underCount === '0') {
                alert('5年より大きい数字を入力してください');
            }
            underCount = '1';
            periodInit();
        } else {
            $('#period').attr('value', period + '年');
            //決定した値を保存
            $.cookie('period', period, {
                expires: 30,
                path   : '/'
            });
            alertFlg = true;
            calculate();
        }
    });

    // 直接金利を入力
    $('#rate').bind('blur', function() {

        if ($('#rate').attr('value') === '年') {
            var rate = RATIO;
        } else {
            var rate = new Number(Math.round((parseFloat($('#rate').attr('value'))) * 1000) / 1000);
            rate     = rate.toFixed(3);
        }

        if (!isDecimal(rate)) {
            if (numberCount === '0') {
                alert('数字を入力してください');
            }
            numberCount = '1';
            rateInit();
        } else if (rate > 5.00) {
            if (overCount === '0') {
                alert('5%を超えています');
            }
            overCount = '1';
            rateInit();
        } else if (rate <= 0) {
            if (underCount === '0') {
                alert('0より大きい数字を入力してください');
            }
            underCount = '1';
            rateInit();
        } else {
            $('#rate').attr('value', rate + '%');
            //決定した値を保存
            $.cookie('rate', rate, {
                expires: 30,
                path   : '/'
            });
            alertFlg = true;
            calculate();
        }
    });

    // 直接頭金を入力
    $('#bonus').bind('blur', function() {

        if ($('#bonus').attr('value') === '万円') {
            var bonus = 0;
        } else {
            var bonus = parseInt($('#bonus').attr('value'));
        }

        if (!isNumeric(bonus)) {
            if (numberCount === '0') {
                alert('数字を入力してください');
            }
            numberCount = '1';
            bonusInit();
        } else if (bonus > 1000) {
            if (overCount === '0') {
                alert('1000万円を超えています');
            }
            overCount = '1';
            bonusInit();
        } else {
            $('#bonus').attr('value', bonus + '万円');
            alertFlg = true;
            calculate();
        }
    });

    // 月々のローンの計算
    function calculate() {
        var period     = parseInt($('#period').attr('value')) * 12;//返済期間
        var rate       = parseFloat($('#rate').attr('value'));//固定金利
        var percent    = rate / 100 / 12;//金利
        var bonus      = parseInt($('#bonus').attr('value'));//ボーナス
        var monthlyPay = parseInt($('#borrow').attr('value')) * Math.pow(1 + percent, period) * percent / (Math.pow(1 + percent, period) - 1) - (bonus / 6);
        monthlyPay     = makeThousandSeprator(Math.round(monthlyPay * 10000));
        $('#monthPay').attr('value', monthlyPay + '円/月');

        if (monthlyPay < '0' && alertFlg == true) {
            if (alertCount === '0') {
                alert('試算した毎月の返済額がマイナスになっています。入力した金額・返済年数の入力内容をご確認ください');
            }
            alertCount = '1';
        }

    }

    // 初期化する
    function init() {
        $('#initial').attr('value', Math.round(price * INITIAL / 1000) * 10 + '万円');//頭金
        $('#borrow').attr('value', (price - (Math.round(price * INITIAL / 1000) * 10)) + '万円');//借入額
        alertFlg = false;
        calculate();
    }

    // 返済期間初期化
    function periodInit() {
        //前の返済期間があればそれを代入
        var period = $.cookie('period');
        if (period) {
            $('#period').attr('value', period + '年');
        } else {
            $('#period').attr('value', PERIOD + '年');
        }
        alertFlg = false;
        calculate();

    }

    // 金利初期化
    function rateInit() {
        //前の金利があればそれを代入
        var rate = $.cookie('rate');
        if (rate) {
            $('#rate').attr('value', rate + '%');
        } else {
            $('#rate').attr('value', RATIO + '%');
        }
        alertFlg = false;

        calculate();
    }

    // ボーナス初期化
    function bonusInit() {
        alertFlg = false;
        $('#bonus').attr('value', BONUS + '万円');
        alertFlg = false;

        calculate();
    }

    // 数字(自然数)の判定
    function isNumeric(num) {
        num = num.toString();
        if (num.match(/^[0-9]+$/g)) {
            return true;
        }
        return false;
    }

    // 数字(小数)の判定
    function isDecimal(num) {
        num = num.toString();
        if (num.match(/^[0-9]+\.[0-9]+$/g)) {
            return true;
        }
        return false;
    }

    // 3桁区切りにして返す
    function makeThousandSeprator(num) {
        num = num.toString();
        num = num.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,'); // 1,234
        return num;
    }

    // エンターキーでfocus移動
    $('input.loan').keypress(function(e) {
        // キーコードが改行だったら
        if (e.which == 13) {
            var inp = $('input.loan');
            for (var i = 0; i < inp.length; ++i) {
                if (this == inp[i]) {
                    var dest = 0;
                    // イベントが起きた input が、配列の最後じゃなかったらひとつ後にフォーカスを当てる
                    if (i + 1 != inp.length) {
                        dest = i + 1;
                    }
                    alertCount  = '0';
                    numberCount = '0';
                    overCount   = '0';
                    underCount  = '0';
                    inp[dest].focus();

                    return;
                }
            }
        }
    });
});
