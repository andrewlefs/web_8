$.addToCard = function(id) {                          
                           var number = document.getElementById('number').value;                           
	$.ajax({
		url: baseUrl + "gio-hang-ajax/"+id+"-"+number+".htm",
		success: function( data ) {
			if(data == 'add')
		    {	
		    	var totalProduct = parseInt($('.totalProduct').text());
		    	totalProduct += 1;
		    	$('.totalProduct').text(totalProduct);
		    }
		    alert('Sản phẩm được thêm vào giỏ hàng thành công');
                                                         window.location.replace("/ketnoiviettrung/my-cart.html");
		}
	});
}