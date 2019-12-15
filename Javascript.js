function ToggleAdvanced() {
	var x = document.getElementById('AdvancedSearch');
	if (x.style.display === "block") {
	  x.style.display = 'none';
	} else {
	  x.style.display = 'block';
	}
}
  
function ToggleAdvancedJazz() {
	var x = document.getElementById('AdvancedFilter');
	if (x.style.display === "block") {
		x.style.display = 'none';
	} else {
		x.style.display = 'block';
	}
}
  
window.onload = function(){
	document.getElementById('AdvancedFilter').style.display = 'none';
	document.getElementById('Thursday').style.visibility = 'hidden';
	document.getElementById('Friday').style.visibility = 'hidden';
	document.getElementById('Saturday').style.visibility = 'hidden';
	document.getElementById('Sunday').style.visibility = 'hidden';
	document.getElementById('Thursday1').style.display = 'none';
	document.getElementById('Friday1').style.display = 'none';
	document.getElementById('Saturday1').style.display = 'none';
	document.getElementById('Sunday1').style.display = 'none';
}
  
function ShowDate(day) {
	if(day == 1){
		document.getElementById('Thursday').style.visibility = 'unset';
		document.getElementById('Thursday1').style.display = 'block';
		document.getElementById('Friday').style.visibility = 'hidden';
		document.getElementById('Friday1').style.display = 'none';
		document.getElementById('Saturday').style.visibility = 'hidden';
		document.getElementById('Saturday1').style.display = 'none';
		document.getElementById('Sunday').style.visibility = 'hidden';
		document.getElementById('Sunday1').style.display = 'none';
	}
	else if(day == 2){
		document.getElementById('Friday').style.visibility = 'unset';
		document.getElementById('Friday1').style.display = 'block';
		document.getElementById('Thursday').style.visibility = 'hidden';
		document.getElementById('Thursday1').style.display = 'none';
		document.getElementById('Saturday').style.visibility = 'hidden';
		document.getElementById('Saturday1').style.display = 'none';
		document.getElementById('Sunday').style.visibility = 'hidden';
		document.getElementById('Sunday1').style.display = 'none';
	}
	else if(day == 3){
		document.getElementById('Saturday').style.visibility = 'unset';
		document.getElementById('Saturday1').style.display = 'block';
		document.getElementById('Friday').style.visibility = 'hidden';
		document.getElementById('Friday1').style.display = 'none';
		document.getElementById('Thursday').style.visibility = 'hidden';
		document.getElementById('Thursday1').style.display = 'none';
		document.getElementById('Sunday').style.visibility = 'hidden';
		document.getElementById('Sunday1').style.display = 'none';
	}
	else if(day == 4){
		document.getElementById('Sunday').style.visibility = 'unset';
		document.getElementById('Sunday1').style.display = 'block';
		document.getElementById('Friday').style.visibility = 'hidden';
		document.getElementById('Friday1').style.display = 'none';
		document.getElementById('Saturday').style.visibility = 'hidden';
		document.getElementById('Saturday1').style.display = 'none';
		document.getElementById('Thursday').style.visibility = 'hidden';
		document.getElementById('Thursday1').style.display = 'none';
	}
}

function FoodAddToCart(eventId, typeEvent) {
	var childAmount = GetChildrenTicketCount();
	var adultAmount = GetNormalTicketCount();
	var extraInfo = document.getElementById('extraInfo').value;

	AddToCartExtraInfo(eventId, typeEvent, childAmount, 0, extraInfo);
	AddToCartExtraInfo(eventId, typeEvent, adultAmount, 1, extraInfo);
}

function AddToCart(eventId, typeEvent, amount, special) {
	if (amount > 0) {
     $.ajax({ url: 'AddToCart.php',
     data: {eventId: eventId,typeEvent: typeEvent, amount:amount, special:special},
     type: 'post',
     success: function(output) {
                   ShowPopup();
                   ShoppingCartPlus(amount);
			}
		});
	}
}

function AddToCartExtraInfo(eventId, typeEvent, amount, special, extraInfo) {
	if (amount > 0) {
     $.ajax({ url: 'AddToCart.php',
     data: {eventId: eventId,typeEvent: typeEvent, amount:amount, special:special, extraInfo:extraInfo},
     type: 'post',
     success: function(output) {
                   ShowPopup();
                   ShoppingCartPlus(amount);
			}
		});
	}
}

function RemoveFromCart(self,eventId, typeEvent, price) {
     $.ajax({ url: 'RemoveFromCart.php',
     data: {eventId: eventId,typeEvent: typeEvent},
     type: 'post',
     success: function(output) {
		 var parent = self.parentNode;
		 var parenttickets = parent.parentNode;
     	ShoppingCartmin(output);
		 self.parentNode.remove();
		 if(parenttickets.children.length == 0){
			var eventday = parenttickets.parentNode;
			eventday.remove();
		}
     }
	});
}

function ShowPopup() {
  	var popup = document.getElementById("myPopup");
  	setTimeout( popup.style.display = 'block', 10000);
  	setTimeout(function () {
  	popup.style.display = 'none';
    }, 2000);
  	
}
function ToEvent(src){
	if (src == "Historic") {
		location.href = "Historic.php";
	}
	if (src == "Jazz") {
		location.href = "jazz.php";
	}
	if (src == "Dance") {
		location.href = "Dance.php";
	}
	if (src == "Food") {
		location.href = "food.php";
	}
}

function showTickets(){
	location.href = ("historicOrderTickets.php");
}

function SelectedDay(date){
	var elem = document.getElementById(date);
	var slides = document.getElementsByClassName("HideTimeTable");

	for(var i = 0; i < slides.length; i++)
	{
	  slides[i].style.display = "none";
	}
	elem.style.display = "block";
}

function ShoppingCartPlus(amount){
	var number = parseInt(document.getElementById("shoppingcartCount").innerHTML);
	number = number + amount;
	document.getElementById("shoppingcartCount").innerHTML = number;
}

function ShoppingCartmin(amount){
	var number = parseInt(document.getElementById("shoppingcartCount").innerHTML);
	number = number - amount;
	document.getElementById("shoppingcartCount").innerHTML = number;

}


function cartAmountPlus(count){
	var indentifier = "amountNumber".concat(count);
	var number = parseInt(document.getElementById(indentifier).value);
	number = number + 1;
	document.getElementById(indentifier).value = number;
}

function cartAmountMinus(count){
	var indentifier = "amountNumber".concat(count);
	var number = parseInt(document.getElementById(indentifier).value);
	if (number > 0) {
		number = number - 1;
		document.getElementById(indentifier).value = number;
	}	
}

function GetTicketAmount(count){
	var indentifier = "amountNumber".concat(count);
	var number = parseInt(document.getElementById(indentifier).value);
	return	number;
}

function GetNormalTicketCount() {
	var normalTickets = document.getElementById('pplAbove12');
	return parseInt(normalTickets.value);
}

function GetChildrenTicketCount() {
	var childrenTickets = document.getElementById('pplBelow12');
	return parseInt(childrenTickets.value);
}

function ShowHideJazzFilter(){
	var x = document.getElementById('Toggle');
  	if (x.style.display === "block") {
    	x.style.display = 'none';
  	} else {
    	x.style.display = 'block';
  	}
}