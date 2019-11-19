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