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

function ajouterFourniture(champ)
{
	var id = champ;
	var qte = document.getElementById(champ).value;

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('resultat2').innerHTML = response;
		}
	}
	xhr.open("POST", "./reponse.php?reponse=2", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id=" + id + "&qte=" + qte);
}

function modifierQte(champ)
{
	var id = champ;
	var qte = document.getElementById("A"+champ).value;

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('resultat2').innerHTML = response;
		}
	}
	xhr.open("POST", "./reponse.php?reponse=3", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id=" + id + "&qte=" + qte);
}

function supprimerFourniture(champ)
{
	var id = champ;

	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('resultat2').innerHTML = response;
		}
	}
	xhr.open("POST", "./reponse.php?reponse=4", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id=" + id);
}