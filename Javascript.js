function ToggleAdvanced() {
  var x = document.getElementById('AdvancedSearch');
  if (x.style.display === "block") {
    x.style.display = 'none';
  } else {
    x.style.display = 'block';
  }
}

function ShowPopup() {
  	var popup = document.getElementById("myPopup");
  	popup.classList.toggle("show");
}
function ToEvent(src){
	if (src.includes("Historic")) {
		location.href = "Historic.php";
	}
	if (src.includes("Jazz")) {
		location.href = "jazz.php";
	}
	if (src.includes("Dance")) {
		location.href = "Dance.php";
	}
	if (src.includes("Food")) {
		location.href = "food.php";
	}
}

function showTickets(){
	location.href = ("historicOrderTickets.php");
}