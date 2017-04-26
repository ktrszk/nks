$(function(){
	$(".edit table").each(function(){
		$(this).find("tr:odd").addClass("odd");
	});
});

function toggleEdit(id) {
	$("#edit"+id).toggle("fast");
}
