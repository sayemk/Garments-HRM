jQuery(document).ready(function($) {
	window.base_url = $('#base_url').html();
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	$(document).on('click', '.deleteItem', function(event) {
		/* Act on the event */
		event.preventDefault();
		var url = $(this).attr('href');
		console.log(url);
		$.ajax({
			url: url,
			type: 'DELETE',
			dataType: 'JSON',
			
			
		})
		.done(function(response) {
			console.log(response);
			if (response.status ==1) {
				$(event.target).parent().parent().parent().remove();
				console.log(response);
			} else{};
		})
		.fail(function(response) {
			console.log(response);
		});
		
	});
	

});

function jsDropdown(event) {
	var url = $(event).attr('data-url')+'/'+$(event).val();
	var target = $(event).attr('data-target');
	$(target).html('');
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		
	})
	.done(function(response) {
		if (response.status=='success') {
			var optionText = 'Select a Level';
	   		var o = new Option(optionText); 
	   		$(o).html(optionText);
			$(target).append(o);

			$.each(response.data, function(index, el) {
	   			console.log(el);
	   			var optionText = el.name;
	   			var o = new Option(optionText, el.id); 
				$(o).html(optionText);
				$(target).append(o);
				
	   		});
		} else{};
	})
	.fail(function(response) {
		console.log(response);
	});
	
}


jQuery(document).ready(function($) {
	setInterval(getTask, 10000);
	getTask();

});

function getTask () {
	$.ajax({
		url: window.base_url+'/user/task',
		type: 'GET',
		dataType: 'JSON',
		
	})
	.done(function(response) {
		$('.taskHeader').html(response.data.count)
		var html ='';
		var priority = '';
		$.each(response.data.tasks, function(index, el) {
			
			if (el.priority == 1) {
				priority = 'text-muted';
			} else if(el.priority==2){
				priority = 'text-yellow';
			}else {
				priority = 'text-red';
			}

			html += '<li><a href="task/edit?show='+el.id+'"><h3 class="normal-wrap '+priority+'">'+el.name+'<small class="pull-right text-blue">'+el.due_time+'</small></h3></a></li>';
		});
		$('.taskList').html(html);
	})
	.fail(function() {
		console.log("error");
	})
}



