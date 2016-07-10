function wenDivHTML() { 
var itemtoReplaceContentOf = $('#profileDisplay');
itemtoReplaceContentOf.html('<center><img src = "images/wen.jpg"/></center><center><h2>Admin</h2><hr /><p>Admin</p> </center><br /><p>This is an admin.</p>');
newcontent.appendTo(itemtoReplaceContentOf);
}


$(document).ready(function() {


	$("body").css("display", "none");

    $("body").fadeIn(800);
    
	$("a.transition").click(function(event){
		event.preventDefault();
		linkLocation = this.href;
		$("body").fadeOut(300, redirectPage);		
	});
		
	function redirectPage() {
		window.location = linkLocation;
	}
	
});
