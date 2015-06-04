function modifQte(champ)
{
	var id = champ;
	var qte = document.getElementById("A"+champ).value;

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('listeM').innerHTML = response;
		}
	}
	xhr.open("POST", "../../lib/reponse.php?reponse=2", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id=" + id + "&qte=" + qte);
}

function supprFour(champ)
{
	var id = champ;

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('listeM').innerHTML = response;
		}
	}
	xhr.open("POST", "../../lib/reponse.php?reponse=3", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id=" + id);
}

function afficheListe()
{
	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('listeM').innerHTML = response;
		}
	}
	xhr.open("POST", "../../lib/reponse.php?reponse=4", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send();
}