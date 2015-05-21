$( document ).ready(function() {
		var url = window.location.href;
		var nb0 = /nb\=[0-9]+$/.test(url);
    	$("#accordion-resizer").accordion({ header: "h3", active: false, collapsible: true, heightStyle: "content" });
		if (nb0)
		{
			var nb1 = /nb\=[0-9]+$/.exec(url);
			var nb2 = parseInt(/[0-9]+/.exec(nb1));
			$( "#accordion-resizer" ).accordion( "option", "active", nb2 );
		}
		else
		{
	    	$("#accordion-resizer").accordion({ header: "h3", active: false, collapsible: true });
		}
});