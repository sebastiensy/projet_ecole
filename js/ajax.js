function tabFournitures()
{
	var id = document.getElementById('Fid').value;
	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('resultat').innerHTML = response;
		}
	}
	xhr.open("POST", "./reponse.php?reponse=1", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id=" + id);
}

function recupererQte()
{
	var id = document.getElementById('qte').value;
	alert(id);
}