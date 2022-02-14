$(document).ready(function () {

	$('#search').on('input', function () {
		console.log('trigger dri');
		var query = $(this).val();

		$.ajax({
			url: 'search',
			type: 'GET',
			data: {'search': query},
			success:function (data) {
				console.log($("#results"));
				console.log(data);
				$(".no-results").remove();
				// $("#results").parent().append(data);

				$("#results").html(data);
			}
		});
	});
});