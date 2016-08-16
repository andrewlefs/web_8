
// load Language
$.loadLanguageString = function() {
    $.ajax({
        medthod: 'get',
        url: baseUrl+'/cms/default/loadLanguageJs',
        dataType: 'json',
        success: function($result) {
            LANG = $result;
        },
        error: function($data, $status, $e) {
            alert($e);
        }
    });
}

$('input.logout').live('click', function(){
    $.ajax({
        type: 'POST',
        url: baseUrl+'/member/default/logout',
        data: {
            YII_CSRF_TOKEN:YII_CSRF_TOKEN
        },
        success: function(result){
            window.location.reload();
        }
    });
});

$.clearText = function(field)
{
    if (field.value == LANG.defaultSearchText) field.value = '';
    else if (field.value == '') field.value = LANG.defaultSearchText;
}

$.clearTextSL = function(field)
{
    if (field.value == field.defaultValue) field.value = '';
    else if (field.value == '') field.value = field.defaultValue;
}

$.checkSearch = function() {
    var textSearch = $('#textSearch').val();
    if(textSearch == LANG.defaultSearchText || textSearch == '') {
        alert(LANG.textSearchRequired);
        return false;
    }
    $.removeSigned(textSearch, 'textSearch');
    return true;
}

$(".numbersOnly").live('keyup paste', function(e){
    var ob = $(this);
    if (e.type == 'paste'){
    setTimeout(function(){$.numbersOnly(ob)}, 1);
    } else $.numbersOnly(ob);
});

$.numbersOnly = function(ob) {
    ob.val(ob.val().replace(/[^0-9]/g,''));
}

$('.numberFormat').live('keypress keyup paste', function(e){
    var ob = $(this);
    if (e.type == 'paste'){
    setTimeout(function(){$.numberFormat(ob.val())}, 1);
    } else $.numberFormat(ob.val());
});
$.numberFormat = function(Num) {
	Num = Num.toString().replace(/^0+/,"").replace(/\./g,"").replace(/,/g,"");// Bỏ hết số 0 ở đầu dãy số | Bỏ hết dấu . trong dãy số
	Num = "" + parseInt(Num);
	var temp1 = "";
	var temp2 = "";

	if (Num == 0 || Num == '0' || Num == '' || isNaN(Num)) {
		return 0;
	}
	else {
		//if (end.length == 2) end += "0";
		//if (end.length == 1) end += "00";
		//if (end == "") end += ",00";
		var count = 0;
		for (var k = Num.length-1; k >= 0; k--) {
			var oneChar = Num.charAt(k);
			if (count == 3) {
				temp1 += ",";
				temp1 += oneChar;
				count = 1;
				continue;
			}
			else{
				temp1 += oneChar;
				count ++;
			}
		}

		for (var k = temp1.length-1; k >= 0; k--) {
			var oneChar = temp1.charAt(k);
			temp2 += oneChar;
		}
		//temp2 = temp2 + end;
		return $('#currentMoney').text('('+temp2+' VNĐ)');
	}
}
/*$(".numbersOnly").live('blur', function(){
    ob = $(this);
	nStr = ob.val() + '';
	//x = nStr.split('.');
	//x1 = x[0];
	//x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(nStr)) {
		nStr = nStr.replace(rgx, '$1' + ',' + '$2');
	}
	ob.val(nStr);
});*/

$(".noSpecialChar").live('keyup paste', function(e){
    var ob = $(this);
    if (e.type == 'paste'){
    setTimeout(function(){$.noSpecialChar(ob)}, 1);
    } else $.noSpecialChar(ob);
});

$.noSpecialChar = function(ob) {
    ob.val(ob.val().replace(/[^a-zA-Z0-9_-]/g,''));
}

$('.buttonCancel').live('click', function(){
    window.location.href = baseUrl + '/index.html';
});

//Check all
$('#select-all').live('click',function(){
      $("INPUT[type='checkbox']").attr('checked', $('#select-all').is(':checked'));
});

$('.tdCheckbox input').live('click', function(){
    $checkAll = true;
    $(".tdCheckbox INPUT").each(function(){
        if(!this.checked)
        {
            $checkAll = false;
        }
    });
    if($checkAll) $('#select-all').attr('checked', true);
    else $('#select-all').attr('checked', false);
});

$('input.checkAgree').live('click', function(){
    if(this.checked)
        $('.registerButton').removeAttr('disabled');
    else
        $('.registerButton').attr('disabled', 'disabled');
});

$.deleteAll = function(frmId, url){
    $("#"+frmId).attr('action', url);
    if(!$("input[name='select-row[]']:checked").attr('checked')){
        alert(LANG.DELETE_CHECKBOX_EMPTY);
        return;
    }
    if(confirm(LANG.DELETE_ALL_CONFIRM)){
        $("#"+frmId).submit();
    }
    return;
}
$.showReply = function(){
    $('.showReply').attr('value', 'Đóng');
    $('.showReply').attr('onclick', '$.hideReply();');
    $('div.nodisplay').show('normal');
}
$.hideReply = function(){
    $('.showReply').attr('value', 'Trả lời');
    $('.showReply').attr('onclick', '$.showReply();');
    $('div.nodisplay').hide('normal');
}

$.closeReply = function(){
    setTimeout(function(){
        $('.showReply').fadeOut('normal');
        $('div.nodisplay').fadeOut('normal');
    }, 3000);
}

$.hideFlashMessage = function() {
    setTimeout(function(){
        $('div.flashMessage').fadeOut('normal');
    }, 3000);
}
$.limitChars = function (obj, limit, infodiv)
{
    var text = $('#'+obj).val();
    var textlength = text.length;
    if(textlength > limit)
    {
        $('#' + infodiv).html(LANG.MAXCHAR +limit+'.');
        $('#comment_'+proId).val(text.substr(0,limit));
        return false;
    }
    else
    {
        $('#' + infodiv).html(LANG.CHARACTERS_REMAINING + (limit - textlength) +'.');
        return true;
    }
}

$('.createMsm').live('click', function(){
    window.location.href=baseUrl+'/member/message/create.html';
});
$.showNeedLogin = function(){
    $('#error_buyStatus').html('<img src="'+baseUrl+'/css/front/images/load-indicator.gif" border=0 /> Loading, please wait...');
    setTimeout(function(){$('#error_buyStatus').text('Bạn phải đăng nhập mới có thể sử dụng được chức năng này.')}, 2);
    return false;
}
$.buyCard = function(){
    if(!confirm('Bạn có chắc chắn muốn mua sản phẩm này không?'))
        return false;
    $('#buyCard .error').html('');
    $('#error_buyStatus').html('<img src="'+baseUrl+'/css/front/images/load-indicator.gif" border=0 /> Loading, please wait...');
    var options = {
        success:function(responseText){
            var result = $.parseJSON(responseText);
            $('#error_buyStatus').html('');
            if(result.alert)
            {
                alert(result.alert);
            }
            else
            {
                for(var key in result)
                {
                    $('#error_' + key).html(result[key]);
                }
                if(result.cardResult)
                {
                    // buy successfylly
                    $('#buttonBuyCard').attr('disabled', 'disabled');
                }
            }
            jQuery.ajax({
                url: baseUrl + "/product/captcha.html?refresh=1",
                dataType: 'json',
                cache: false,
                success: function(data) {
                    jQuery('#cimg').attr('src', data['url']);
                    jQuery('body').data('default/captcha.hash', [data['hash1'], data['hash2']]);
                }
            });
        }
    };
    $('#buyCard').ajaxSubmit(options);
}

$('.sluong').live('keypress', function(e){
    return $.notEnterAllow(e);
});

$('.notEnter').live('keypress', function(e){
    return $.notEnterAllow(e);
});

$.notEnterAllow = function(e){
    var key;
    if(window.event)
        key = window.event.keyCode;     //IE
    else
        key = e.which;     //firefox

    if(key == 13)
        return false;
    else
        return true;
}

$.submitContact = function(){
    $('#contact-form .error').html('');
    $('#contactStatus').html('<img src="'+baseUrl+'/css/front/images/load-indicator.gif" border=0 /> Loading, please wait...');
    var options = {
        success:function(responseText){
            var result = $.parseJSON(responseText);
            $.ajax({
                url: baseUrl + "/captcha?refresh=1",
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $('#cimg').attr('src', data['url']);
                    $('body').data('captcha.hash', [data['hash1'], data['hash2']]);
                }
            });

            $('#contactStatus').html(result.status);
            for(var key in result)
            {
                $('#error_' + key).html(result[key]);
            }
        }
    };
    $('#contact-form').ajaxSubmit(options);
}

$.removeSigned = function(text, target) {
    str = text;
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|$|_/g,"");
    /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự khoảng trắng */
    str = str.replace(/-+-/g," "); //thay thế 2- thành 1 khoẳng trắng
    str = str.replace(/^\-+|\-+$/g,"");
    //cắt bỏ ký tự - ở đầu và cuối chuỗi
    $('#' + target).val(str);
    return false;
}