function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

function verifPseudo(champ)
{
   if(champ.value.length < 1 || champ.value.length > 40)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verifMdp(champ)
{
	if(champ.value.length < 6 || champ.value.length > 16)
	{
		surligne(champ, true);
		return false;
	}
	else
	{
		surligne(champ, false);
		return true;
	}
}

function verifMail(champ)
{
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!regex.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verifTel(champ)
{
	var regex = /^0[1-8][0-9]{8}$/;
	if(!regex.test(champ.value))
	{
	  surligne(champ, true);
	  return false;
	}
	else
	{
	  surligne(champ, false);
	  return true;
	}
}

function champVide(champ)
{
	if(champ.value.length > 0)
	{
		surligne(champ, false);
		return true;
	}
	else
	{
		surligne(champ, true);
		return false;
	}
}