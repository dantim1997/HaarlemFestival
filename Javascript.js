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
		window.open("historicHome.php");
	}
	if (src.includes("Jazz")) {
		window.open("jazz.php");
	}
	if (src.includes("Dance")) {
		window.open("Dance.php");
	}
	if (src.includes("Food")) {
		window.open("food.php");
	}
}