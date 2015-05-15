$('.modif').click(function(){
    $(this).closest('tr').find('input[type=radio]').attr({
    	disabled : false,
    	name : 'suivi'
    });
    //$(this).closest('tr').find('input[type=submit]').attr("disabled",false);
    $(this).closest('tr').find('input[name=enregistrer]').attr("disabled",false);
    //$( "#accordion-resizer" ).accordion( "option", "active", 0 );
});