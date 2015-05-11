/*var cpt=0;

function allowDrop(ev) {
	ev.preventDefault();
}*/

/*function drag(ev) {
	ev.dataTransfer.setData("text", ev.target.id);
}*/

function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	
	ev.target.appendChild(document.getElementById(data));
	$(ev.target).next('.div2').append($('<input id="qte" type="number" size=2 value=1 name="'+data+'"min=1>'));

	//if($("#qte".length))
	//	alert('test');

	/*if(!document.getElementsByClassName('div2').firstElementChild)
	else
		alert("not ok");*/

//}

/*function getValue(id)
{
	return document.getElementById(id);
}*/

function OnDragStart(target, evt){
				evt.dataTransfer.setData('IdElement', target.id);
}
function OnDropTarget(target, evt){
	evt.preventDefault();
	var id = evt.dataTransfer.getData('IdElement');
	target.appendChild(document.getElementById(id));
	$(evt.target).next('.div2').append($('<input id="qte" type="number" size=2 value=1 name="'+data+'"min=1>'));
}
