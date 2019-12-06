
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
	var x = document.getElementById('AdvancedFilter');
	x.style.display = 'none';
	var x = document.getElementById('Thursday');
	x.style.display = 'none';
	var x = document.getElementById('Friday');
	x.style.display = 'none';
	var x = document.getElementById('Saturday');
	x.style.display = 'none';
	var x = document.getElementById('Sunday');
	x.style.display = 'none';
	var x = document.getElementById('Thursday1');
	x.style.display = 'none';
	var x = document.getElementById('Friday1');
	x.style.display = 'none';
	var x = document.getElementById('Saturday1');
	x.style.display = 'none';
	var x = document.getElementById('Sunday1');
	x.style.display = 'none';
}

function ShowDate(day) {
	if(day == "thursday"){
		document.getElementById('Thursday').style.display = 'block';
		document.getElementById('Thursday1').style.display = 'block';
	}
	else if(day == "friday"){
		document.getElementById('Friday').style.display = 'block';
		document.getElementById('Firday1').style.display = 'block';
	}
	else if(day == "saturday"){
		document.getElementById('Saturday').style.display = 'block';
		document.getElementById('Saturday1').style.display = 'block';
	}
	else if(day == "sunday"){
		document.getElementById('Sunday').style.display = 'block';
		document.getElementById('Sunday1').style.display = 'block';
	}
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

function RemoveFromCart(self,eventId, typeEvent) {
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

function ShowHideJazzFilter(){
	var x = document.getElementById('Toggle');
  	if (x.style.display === "block") {
    	x.style.display = 'none';
  	} else {
    	x.style.display = 'block';
  	}
}
