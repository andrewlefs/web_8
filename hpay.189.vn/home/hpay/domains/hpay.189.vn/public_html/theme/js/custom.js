$(document).ready(function() {
	$("#slider").coinslider({
	 width:640, // width of slider panel
	height: 200, // height of slider panel
	delay: 3000, // delay between images in ms
	effect: 'random', // random, swirl, rain, straight
	navigation: true, // prev next and buttons
	links : true, // show images as links 
	hoverPause: true // pause on hover
});		
		
/////////////////////////
$(".box1 span").hover(function(){
	$(this).closest("li").children(".hide").stop(true,true).animate({opacity:1,top:-20},300)
	},function(){
		$(this).closest("li").children(".hide").animate({opacity:0,top:-40},300)
		})
////////////////////////
$('.nav_menu li').hover(function(){
	  $(this).children('.menucon:first').stop(true,true).slideDown(200).closest("li").find("a:first").addClass("active");
	  },function(){
		  $(this).children('.menucon:first').slideUp(200).closest("li").find("a:first").removeClass("active");
		  });
//////////////////
$(".box li:even").css("background-color","#f0f0f0");
////////////////////////////
////////////////////  kien ///////////////////////////
     var keybreak = ".";
                                        $('#moneyadd').bind("keypress", function(event) {
                                                if (!_isIE()) {
                                                        if ((event.charCode >= 48 && event.charCode <= 57) || (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 35 || event.keyCode == 36 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46)) {
                                                                return true;
                                                        };
                                                } else {
                                                        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 35 || event.keyCode == 36 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46)) {
                                                                return true;
                                                        };
                                                }
                                                return false;
                                        }).bind("keyup", function(event) {
                                                if (this.value.length <= this.maxLength && keybreak!=undefined && keybreak != "") {
                                                        var temp = this.value;
                                                        while (temp.indexOf(keybreak) != -1) {
                                                                temp = temp.replace(keybreak,"");
                                                        }
                                                        temp = parseInt(temp);
                                                        temp = new String(temp);
                                                        if(temp=="NaN"){
                                                                temp = "0";
                                                        }
                                                        var targetId = $(this).attr("data-target");
                                                        $("#" + targetId).val(temp);
                                                        var result = "";
                                                        while (temp.length > 3) {
                                                                var length = temp.length;
                                                                result = keybreak + temp.substring(length - 3, length) + result;
                                                                temp = temp.substring(0, length-3);
                                                        }
                                                        result = temp + result;
                                                        this.value = result;
                                                        $('input#addmoney').val(result);
                                                } else {
                                                        return false;
                                                }
                                        }).bind("blur",function(){
		var minlength = $(this).val().length;
		if(minlength < 6){
			$(this).val("10.000");
                                                                                $('input#addmoney').val("10.000");
		}else if(minlength == 11){
                                                              if($(this).value != "100.000.000")
                                                                  {
                                                                          $(this).val("100.000.000");
                                                                          $('input#addmoney').val("100.000.000");
                                                                  }
                                                    }
                                                    });
                                                    
                                                         var keybreak = ".";
                                        $("input#MemberRequest_Money").bind("keypress", function(event) {
                                                if (!_isIE()) {
                                                        if ((event.charCode >= 48 && event.charCode <= 57) || (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 35 || event.keyCode == 36 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46)) {
                                                                return true;
                                                        };
                                                } else {
                                                        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 13 || event.keyCode == 35 || event.keyCode == 36 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46)) {
                                                                return true;
                                                        };
                                                }
                                                return false;
                                        }).bind("keyup", function(event) {
                                                if (this.value.length <= this.maxLength && keybreak!=undefined && keybreak != "") {
                                                        var temp = this.value;
                                                        while (temp.indexOf(keybreak) != -1) {
                                                                temp = temp.replace(keybreak,"");
                                                        }
                                                        temp = parseInt(temp);
                                                        temp = new String(temp);
                                                        if(temp=="NaN"){
                                                                temp = "0";
                                                        }
                                                        var targetId = $(this).attr("data-target");
                                                        $("#" + targetId).val(temp);
                                                        var result = "";
                                                        while (temp.length > 3) {
                                                                var length = temp.length;
                                                                result = keybreak + temp.substring(length - 3, length) + result;
                                                                temp = temp.substring(0, length-3);
                                                        }
                                                        result = temp + result;
                                                        this.value = result;
                                                       document.getElementById('currentMoney').innerHTML = result+"  VNÄ";
                                                } else {
                                                        return false;
                                                }
                                        }).bind("blur",function(){
		var minlength = $(this).val().length;
		if(minlength < 6){
			$(this).val("10.000");
                                                                                $('input#MemberRequest_Money').val("10.000");
                                                                                $('#currentMoney').html("10.000   VNÄ");
		}else if(minlength == 11){
                                                              if($(this).value != "100.000.000")
                                                                  {
                                                                          $(this).val("100.000.000");
                                                                          $('input#MemberRequest_Money').val("100.000.000");
                                                                        $('#currentMoney').html("100.000.000   VNÄ");
                                                                  }
                                                    }
		
                                });
                                
                                
                                $("#phone_sendto").bind("blur",function(){
                                            checkP();
                                });
                                
                                
                        
/////////////////// ket thuc kien //////////////////////	
 
$(function(){
	var i=1
	$(".nav_menu li").find(".menucon").each(function() {
        $(this).closest("li").addClass("item"+i);
		var y=$(this).closest("li").offset().left;
		var now=$(this).width();
		var uynhvirust=y+now;
		if(uynhvirust<=1200){
			$(this).closest("li").addClass("left");
		}
		else{
			if((uynhvirust>1200)&&(uynhvirust<1500)){
				var liwidth=$(this).closest("li").width();
				$(this).closest("li").addClass("giua");
				$(this).css("left",-(($(this).width()-liwidth)/2))
				}
				else{
					if(uynhvirust>=1500){
						$(this).closest("li").addClass("phai")
					}
				}
		}
		i++;
    });
})
////////////////////////////
var i=1;
$(".sroll_box table tr").each(function() {
    $(this).addClass("uynh"+i);
	i++;
	$(".sroll_box table tr .who").click(function() {
        ///////////////////
    $(this).closest("tr").find(".grayBox").css("display","block").children(".box_content").fadeIn(1500).children(".close").click(function() {
        $(this).closest(".box_content").fadeOut(1000).closest(".grayBox").css("display","none")
    });
    });
});
//////////////////////////////

//tap--------------------------
		$(".tabContents").hide(); // Ă¡ÂºÂ¨n toĂƒ n bĂ¡Â»â„¢ nĂ¡Â»â„¢i dung cĂ¡Â»Â§a tab
		$(".tabContents:first").show(); // MĂ¡ÂºÂ·c Ă„â€˜Ă¡Â»â€¹nh sĂ¡ÂºÂ½ hiĂ¡Â»Æ’n thĂ¡Â»â€¹ tab1
		$("#tabContaier ul li").click(function(){ //Khai bĂƒÂ¡o sĂ¡Â»Â± kiĂ¡Â»â€¡n khi click vĂƒ o mĂ¡Â»â„¢t tab nĂƒ o Ă„â€˜ĂƒÂ³
			var activeTab = $(this).find("a").attr("alt"); 
			$("#tabContaier ul li").removeClass("active"); 
			$(this).addClass("active"); 
			$(".tabContents").hide(); 
			$(activeTab).fadeIn(); 
		});
//////////

 $(".tabContents1").hide(); // Ä‚Â¡Ă‚ÂºĂ‚Â¨n toÄ‚Æ’ n bÄ‚Â¡Ă‚Â»Ă¢â€Â¢ nÄ‚Â¡Ă‚Â»Ă¢â€Â¢i dung cÄ‚Â¡Ă‚Â»Ă‚Â§a tab
  $(".tabContents1:first").show(); // MÄ‚Â¡Ă‚ÂºĂ‚Â·c Ä‚â€Ă¢â‚¬ËœÄ‚Â¡Ă‚Â»Ă¢â‚¬Â¹nh sÄ‚Â¡Ă‚ÂºĂ‚Â½ hiÄ‚Â¡Ă‚Â»Ă†â€™n thÄ‚Â¡Ă‚Â»Ă¢â‚¬Â¹ tab1
  $("#tabContaier1 ul li").click(function(){ //Khai bÄ‚Æ’Ă‚Â¡o sÄ‚Â¡Ă‚Â»Ă‚Â± kiÄ‚Â¡Ă‚Â»Ă¢â‚¬Â¡n khi click vÄ‚Æ’ o mÄ‚Â¡Ă‚Â»Ă¢â€Â¢t tab nÄ‚Æ’ o Ä‚â€Ă¢â‚¬ËœÄ‚Æ’Ă‚Â³
   var activeTab = $(this).find("a").attr("alt"); 
   $("#tabContaier1 ul li").removeClass("active"); 
   $(this).addClass("active"); 
   $(".tabContents1").hide(); 
   $(activeTab).fadeIn(); 
  });
//////////
$(function(){
	$(".box_goi .cols_goi .content .img").hover(function(){
			$(this).stop(true,true).animate({opacity:0.5},300)
		},function(){
			$(this).animate({opacity:1},300)
			})
	})
	$(function(){
	$("#carouse2 img").hover(function(){
			$(this).stop(true,true).animate({opacity:0.5},300)
		},function(){
			$(this).animate({opacity:1},300)
			})
	})
	//////////////////////////
$(window).load(function() {
    var uynhheight_thecao=$(".thecao").height();
	var uynhheight_tintuc=$(".tintuc").height();
	var uynh_change=0;
	if(uynhheight_thecao > uynhheight_tintuc){
		uynh_change=uynhheight_thecao-20;
		}
	else
		uynh_change=uynhheight_tintuc;
	$(".tintuc").css("height",uynh_change);
});
///////////////////////////////
//////////
$(window).load(function() {
    var uynhheight_thecao1=$(".about").height();
	var uynhheight_tintuc1=$(".list_bank").height();
	var uynh_change1=0;
	if(uynhheight_thecao1 > uynhheight_tintuc1){
		uynh_change1=uynhheight_thecao1;
		}
	else
		uynh_change1=uynhheight_tintuc1;
	$(".about").css("height",uynh_change1);

});
///////////////////////////////
$(".dm li a").hover(function(){
	$(this).stop(true,true).animate({paddingLeft:25},300)
	},function(){
		$(this).animate({paddingLeft:15},300)
		})
/////////////////
$(".dangkitm .step .left_step").mousedown(function() {
    $(".dd .buoc2").removeClass("hover");
	$(".dd .buoc1").addClass("hover")
});
$(".dangkitm .step .right_step").mousedown(function() {
    $(".dd .buoc1").removeClass("hover");
	$(".dd .buoc2").addClass("hover")
});
////////////////////////
$(".dangkitm .step .right_step input").click(function() {
    $('.dangkitm .step .right_step input[type="submit"]').animate({opacity:1},300)
});
////////////////////////////
$(function(){
	var height_dm=$(".dm").height();
	var banner_h=$(".banner").height();
	var uynh_vip=height_dm-(banner_h-50);
	if(uynh_vip>=0){
		$(".uynh").css("height",uynh_vip)
		}
	})
//////////////////////////
});
/////////////////////////
$(function(){$('.nav_menu li ul').closest('li').addClass('have_children')})
/////////////////////////
$(function() {
        $(window).scroll(function() {
            if($(this).scrollTop() > 150) {
                $('.totop').fadeIn(500);	
            } else {
                $('.totop').fadeOut(500);
            }
        });
     
        $('.totop').click(function() {
            $('body,html').animate({scrollTop:0},800);
        });	
    });

///////////
function active_slide(selector){ 
	$(selector+' .img_slidetop').not(":first").hide()
		$(selector).find(".slide_bottom li a").click(function(){
			var chuyen =$(this).attr("title")
			$(selector).find(".slide_bottom li a").removeClass("active")
			$(this).addClass("active")
			$(selector+" .img_slidetop").hide()
			$(""+chuyen).show()
		});
}//silde//		
$(function() {

				$('#carouse3').carouFredSel({
					width:1000,
					height:190,
					items:3,
					direction:"left",
					scroll: {
						items:1,
						pauseOnHover: true,
					},
					auto: {
						duration: 1200,
						timeoutDuration:3000
					},
					prev: '#prev1',
					next: '#next1',
				});
	
			});

//
$(function() {

				$('#carouse1').carouFredSel({
					width:325,
					height:150,
					items:3,
					direction:"up",
					scroll: {
						items:1,
						pauseOnHover: true,
					},
					auto: {
						duration: 1200,
						timeoutDuration:3000
					},
					prev: '#prev1',
					next: '#next1',
				});
	
			});

//				
$(function() {
    $(".slide_new li").not(":first").hide()
    setInterval(function(){
      $(".slide_new li:first").fadeOut(1000).next('li').fadeIn(1000).end().appendTo('.slide_new')},5000);
})

//////////////////////////CustomScrollbar------------------------

$(function() {

				$('#carouse2').carouFredSel({
					height:80,
					items: 8,
					direction:"left",
					scroll: {
						items:1,
						pauseOnHover: true,
					},
					auto: {
						duration: 1200,
						timeoutDuration:3000
					},
					prev: '#prev',
					next: '#next',
				});
	
			});

//











