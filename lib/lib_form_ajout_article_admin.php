<?php

function formulaire_ajout_article($msg="", $ref="", $desc="", $prix="")
{

?>
	<?php echo $msg; ?>
	<br>

	<div align="center" id="add-form">
	<form method="post" action="ajouter_article.php" name="f1" id="maj">
		<table width="90%" align="center">
			<tr>
				<td>Reference</td>
				<td>Description</td>
				<td>Prix</td>  
			</tr>
			<tr>
				<td><span><input type="text" name="ref" value="<?php echo $ref;?>" required></span></td>
				<td><span><input size="30" type="text" name="desc" value="<?php echo $desc;?>"required></span></td>
				<td><span><input size="10" type="text" name="prix" value="<?php echo $prix;?>" required></span></td>
			</tr>
			<tr>
				<td colspan="3">Categorie
					<select name="categorie">
					<?php
						$db = new DB_connection();
						$req="SELECT DISTINCT categorie FROM Sous_categorie ORDER BY categorie ASC";
						$db->DB_query($req);
						while($ligne=$db->DB_object())
						{
					?>
						<option value="<?php echo $ligne->categorie;?>"><?php echo $ligne->categorie;?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
	  		<tr><td><div align="right" colspan=3><input type="submit" name="Valider"></div></td></tr>
		</table>
	</form>
	</div>
<?php

}

?>