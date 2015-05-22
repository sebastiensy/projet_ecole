function afficheWorkflow() 
{
	xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState==4 && xhr.status==200)
		{
			response = xhr.responseText;
			document.getElementById('workflow').innerHTML = response;
		}
	}

	xhr.open("POST", "../../lib/reponse.php?reponse=1", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send();
}
