
window.onload = function() {
	var element = document.getElementById('testHead');
	console.log(element);

	var rect = element.getBoundingClientRect();

	console.log(rect);

	var y = rect.y + rect.height;

	console.log(y);
}
