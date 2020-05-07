
checkIfEmpty();

	function removeStep(stepId){

		$("#"+stepId).remove();
		checkIfEmpty();
	}

		function addNewStep(stepId){
			
			var r=Math.floor((Math.random() * 1000) + 1); 
		$("#steps").append('<?php $r=rand(); ?>');
		$("#"+stepId).after('<div class="input-group" id="s1" style="margin-bottom: 6px;"><button type="button" class="btn btn-success btn-sm" style="margin-left: 1px;height: 30px" id="pluss'+r+'"><i class="fas fa-plus"></i></button><button id="minuss'+r+'" type="button" class="btn btn-danger btn-sm" style="margin-left: 1px;height: 30px" ><i class="fas fa-minus"></i></button><input type="text" class="form-control input-sm" placeholder="ingredient" name="fields[]" style="width: 198px;height: 30px;" /><span class="input-group-btn" style="width:0px;"></span><input type="text" class="form-control input-sm" placeholder="Amount" name="fields[]" style="height: 30px;" /><div role="separator" class="dropdown-divider"></div></div>');
		  $("#s1").attr("id",r);
		   $("#minuss"+r).attr("onclick",'removeStep('+r+')');
		   $("#pluss"+r).attr("onclick",'addNewStep('+r+')');
		   checkIfEmpty();
	}


		function createFirstStep(stepId){
			
			var r=Math.floor((Math.random() * 1000) + 1); 
		$("#steps").append('<?php $r=rand(); ?>');
		$("#steps").append('<div class="input-group" id="s1" style="margin-bottom: 6px;"><button type="button" class="btn btn-success btn-sm" style="margin-left: 1px;height: 30px" id="pluss'+r+'"><i class="fas fa-plus"></i></button><button id="minuss'+r+'" type="button" class="btn btn-danger btn-sm" style="margin-left: 1px;height: 30px" ><i class="fas fa-minus"></i></button><input type="text" class="form-control input-sm" placeholder="ingredient" name="fields[]" style="width: 198px;height: 30px;" /><span class="input-group-btn" style="width:0px;"></span><input type="text" class="form-control input-sm" placeholder="Amount" name="fields[]" style="height: 30px;" /><div role="separator" class="dropdown-divider"></div></div>');
		  $("#s1").attr("id",r);
		   $("#minuss"+r).attr("onclick",'removeStep('+r+')');
		   $("#pluss"+r).attr("onclick",'addNewStep('+r+')');
		   checkIfEmpty();
	}
 
    function initVideoModal(p1) {
$(".modal fade").remove();    	
$("#videoContainer").append('<div class="modal fade" id="'+p1+'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document" id="modal-dialog"><div class="modal-content" id="modal-content"><div class="modal-body" id="modal-body"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="" id="'+p1+'video" allow="autoplay"></iframe></div></div></div></div></div><button type="button" id="videoButton" class="btn btn-primary video-btn" data-toggle="modal" data-src="'+p1+'" data-target="#'+p1+'" style="display:none">Play Video 1 - autoplay</button>');    
initVideoModalPhase2(p1);
$("#videoButton").click();
    }

        function initVideoModalPhase2(p1) {

// Gets the video src from the data-src on each button
var $videoSrc;  
$('.video-btn').click(function() {
    $videoSrc = $(this).data( "src" ); 
});
// when the modal is opened autoplay it  
$('#'+p1).on('shown.bs.modal', function (e) {
// set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
// $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" );
$("#"+p1+"video").attr('src',"//www.youtube.com/embed/"+$videoSrc); 
})
// stop playing the youtube video when I close the modal
$('#'+p1).on('hide.bs.modal', function (e) {
    // a poor man's stop video
    $("#"+p1+"video").attr('src',$videoSrc); 
})   
// document ready  
  $("#"+p1).on('hidden.bs.modal', function (e) {
    $("#"+p1+"video").attr("src", "nonenone");
    $("#"+p1).remove(); 
    $("#videoButton").remove();
    //myModal alert("ddds");
});
};

    function checkIfEmpty(){
    	var r=Math.floor((Math.random() * 1000) + 1);
if ( $('#steps').children().length ==0 ) {
$('#steps').append('<button type="button" id="extraAddButton" class="btn btn-success btn-sm" style="margin-left: 1px;height: 30px"><i class="fas fa-plus"></i></button>');	
$("#extraAddButton").attr("onclick",'createFirstStep('+r+')');
}
else
	$('#extraAddButton').remove();
}