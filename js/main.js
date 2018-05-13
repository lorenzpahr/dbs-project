/*function cmtClick(){
	var id = $(this).data('id');
	var temp = "#"+id+" #postHead";
	var header = $("#"+id+" #postHead").val();
	alert(header);
	alert(temp);
	$('#post_Modal').modal();
};*/

var basicHref = '/~h1550811/project/';

// Craft Modal - Post View
$('#post_modal').on('show.bs.modal', function(e) {
	var id = $(e.relatedTarget).data('id');
	var header = $("#"+id+" #postHead").text();
	var img = $("#"+id+" #postImage").attr('src');

	$('#modal_title_id').text(header);
	$('#modal_img').attr('src', img);

	$.ajax({
		type: "GET",
		url: "getComments.php?id="+id,
		dataType: "html",
		success: function(res) {
			$('.modal-footer').html(res);
			//show at the end to avoid updating comments due to database delay
			$('#post_Modal').modal();
		}
	});
});

//Add Listener to the "Add Post" Field, if it exists in the DOM
if($(".addPost")[0]){
	$(".addPost").on("click", function(){
		window.location.href = basicHref + 'dashboard.php';
	});
}


//Submit a new post
$('.submit_post').on('click', function(e) {
	var title = $('#titleInput').val();
	var url = $('#imgURL').val();
	var username = $('#usernameID').text().trim();

	$.ajax({
		type: "POST",
		url: "createPost.php",
		data: {
			title: title,
			url: url,
			username: username
		}
	});
});
