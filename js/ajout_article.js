function subm()
{
	document.getElementById('maj').submit();
}


function verif()
{
	var ref=document.f1.ref.value;
	if(ref=="")
	{
		alert("Veuillez Entrer une reference");
		document.f1.ref.focus();
		return false();
	}
	var desc=document.f1.desc.value;
	if(desc=="")
	{
		alert("Veuillez Entrer une Description");
		document.f1.desc.focus();
		return false();
	}
	var prix=document.f1.desc.value;
	if(prix=="" || isNaN(prix)
	{
		alert("Veuillez Entrer un prix par unite");
		document.f1.prix.focus();
		return false();
	}
}