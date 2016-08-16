// JavaScript Document
function numberValidation(myField){
	if(isNaN(myField.value)){
		alert("Invalid data format.\n\nOnly numbers are allowed.");
		myField.focus();
		return (false);
	}
}