<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="../../../js/fancybox/source/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" href="../../../js/fancybox/source/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript">
	
		$( document ).ready(function() {
			$("#fancy").fancybox({
				
				type: "iframe",
				width: '70%',
				height: '60%',
				onClosed: function() {   
				parent.location.reload(true); 
    ;}
								});
	});
	$( document ).ready(function() {
			$("#fancy1").fancybox({
				
				type: "iframe",
				width: '70%',
				height: '60%',
				onClosed: function() {   
				parent.location.reload(true); 
    ;}
								});
	});
	</script>
<?php
echo '<nav class=menu>';
			echo '<br><br><br>';
			echo '<table width="150" align="left">';
			echo '<ul><tr><td><br><br>';
			echo '<li><a href="../gestion_liste">G&eacute;rer Les Listes</a></li>';
			echo '			<br>
						<br>
					</td>
				</tr>';
				/*<tr>
					<td>
						<br>
						<br>';
						echo '
						<li><a href="#">G&eacute;rer Les Articles</a>
						<ul > 
							<li><a id="fancy" href="../gestion_article/modif_article.php">Modifier article</a></li> 
							 
							<li><a id="fancy1" href="../gestion_article/ajouter_article.php">Ajouter article</a></li>
						</ul> 
						</li>
						<br>
						<br>
						<br>
					</td>
				</tr>*/
				echo '
				<tr>
					<td>
						<br>
						<br>
						<li><a href="../gestion_article/modif_article.php">Modifier article</a></li> 
							 
						<li><a href="../gestion_article/ajouter_article.php">Ajouter article</a></li>
						<br>
						<br>
					</td>
				</tr>
				
				<tr>
					<td>
						<br>
						<br>
						<li><a href="../suivi_commande">Suivre Les Commandes</a></li>
						<br>
						<br>
					</td>
				</tr>
				<tr>
					<td>
						<br>
						<br>
						<li><a href="../messagerie">Messagerie</a></li>
						<br>
						<br>
					</td>
				</tr>
			</ul>
			</table>
			</nav>';
			?>