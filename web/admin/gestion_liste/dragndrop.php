

<!--
/*echo "<script type=\"text/javascript\">\n";
echo "function OnDragStart(target, evt){
	evt.dataTransfer.setData('IdElement', target.id);
}";
echo "function OnDropTarget(target, evt){
	evt.preventDefault();
	var id = evt.dataTransfer.getData('IdElement');
	target.appendChild(document.getElementById(id));
	var idMat = target.appendChild(document.getElementById(id)).id;";
echo 'location.href = location.href + "?var="target.appendChild(document.getElementById(id)).id;';	
echo '}';
array_push($tabElem,$_GET['var']); 
echo "</script>";*/
-->



<script type="text/javascript">
function OnDragStart(target, evt){
	evt.dataTransfer.setData('IdElement', target.id);
}

function OnDropTarget(target, evt){
	evt.preventDefault();
	var id = evt.dataTransfer.getData('IdElement');
	target.appendChild(document.getElementById(id));
	//alert(target.appendChild(document.getElementById(id)).id);
	var idMat = target.appendChild(document.getElementById(id)).id;
	
	$.ajax({
                    type: "POST",
                    url: "aliste.php",
                    data: { var : idMat },
                    success: function(data)
                    {
                        
                    }
                });

	//$.post('dragndrop.php', {variable: idMat});
	//document.location.href = "../messagerie/messagerie.php";
	
	//if(isset($_POST['var']))
//{
    //$uid = $_POST['var'];
    //echo '<script type="text/javascript">var btn = document.createElement("BUTTON");var t = document.createTextNode("CLICK ME");btn.appendChild(t);document.body.appendChild(btn);';
//}
	//array_push($tabElem,$_GET['var']);

	
	
}
</script>




