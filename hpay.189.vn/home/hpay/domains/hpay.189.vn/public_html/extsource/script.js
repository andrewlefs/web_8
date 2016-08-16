/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$('document').ready(function(){
   $('.config-num').val(1);
   $('.config-com').val(0);
   $('.old-price').val(0);
   $('#total').text(0);
   var totalPrice = $('#total').text();
   var tottalDefault = 0;
   if($('#total').text()== tottalDefault){
      $('#configSubmit').attr('disabled', 'disabled');
   }
   $.changeConfig=function(idSelect){
       setTimeout(this, 3000);
//       alert(idSelect);
       var productId = $('#config-com'+idSelect).val();
       var numb =$('input[name="config-com'+idSelect+'"]').val();
       var oldPrice = $('#old-price'+idSelect).val();
       var giaStr = '';
       $.ajax({
           type:'POST',
           url:'ajaxConfig.htm',
           dataType:'json',
           data:{productId:productId,numb:numb},
           success:function(data){
               if(data){
					var totalPrice = 0;
                   $.parseJSON(data);
                   giaStr=data.giaString;
				   $('#old-price'+idSelect).val(data.giaNumber);
				   var strIds = $('#subIds').val();
				   var arrIds = strIds.split(',');
				   for(var i=0;i<arrIds.length;i++){
						if(arrIds[i]!=''){
							totalPrice = totalPrice + parseInt($('#old-price'+arrIds[i]).val());
						}
				   }
                   //totalPrice = totalPrice + data.giaNumber - oldPrice;
                   $('#price'+idSelect).text(data.giaString);  
                   
                   $('#total').text(number_format(parseInt(totalPrice)));
                   if($('#total').text()== tottalDefault){
                      $('#configSubmit').attr('disabled', 'disabled');
                   }else{
                       $('#configSubmit').removeAttr('disabled');
                   }
               }
           }
       });
   }
});
$(".numbersOnly").live('keyup paste', function(e){
    var ob = $(this);
    if (e.type == 'paste'){
    setTimeout(function(){numbersOnly(ob)}, 1);
    } else numbersOnly(ob);
});
function numbersOnly(ob) {
    ob.val(ob.val().replace(/[^0-9]/g,''));
}
function number_format (number, decimals, dec_point, thousands_sep) {
    // Formats a number with grouped thousands  
    // 
    // version: 1109.2015
    // discuss at: http://phpjs.org/functions/number_format    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +   improved by: davook
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Jay Klehr
    // +   improved by: Brett Zamir (http://brett-zamir.me)    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +      input by: Amirouche
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    // *    example 13: number_format('1 000,50', 2, '.', ' ');    // *    returns 13: '100 050.00'
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');}
    return s.join(dec);
}


