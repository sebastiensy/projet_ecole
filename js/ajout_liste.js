var cpt=0;

function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	/*var target = ev.target;
	var draggedElement = dndHandler.draggedElement;
    var clonedElement = draggedElement.cloneNode(true); 

    clonedElement = target.appendChild(clonedElement); // Ajout de l'élément cloné à la zone de drop actuelle
    dndHandler.applyDragEvents(clonedElement); // Nouvelle application des événements qui ont été perdus lors du cloneNode()
    
    draggedElement.parentNode.removeChild(draggedElement); */
	ev.target.appendChild(document.getElementById(data));
	//if($("#qte".length))
	//	alert('test');

	if(!document.getElementsByClassName('div2').firstElementChild)
	$(ev.target).next('.div2').append($('<input id="qte" type="number" size=2 value=1 name="'+data+'"min=1>'));
	else
		alert("not ok");
}

function getValue(id)
{
	return document.getElemetById(id);
}