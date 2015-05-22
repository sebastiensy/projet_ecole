function actualiserLecture(champ)
{
	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('lu'+champ).innerHTML = response;
		}
	}
	xhr.open("GET", "../../lib/reponse.php?reponse=2", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send();
}