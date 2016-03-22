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

$.validator.setDefaults({
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});

function populateSelect (event) {
	var url = $(event).attr('data-source')+'/'+$(event).val();
	var target = $(event).attr('data-target');
	console.log(target);
	$("#"+target).html('');
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		
	})
	.done(function(response) {
		console.log(response);
		var optionText = '--Select--';
   		var o = new Option(optionText); 
   		$(o).html(optionText);
		$("#"+target).append(o);

		$.each(response, function(index, el) {
   			//console.log(el);
   			var optionText = el.name;
   			var o = new Option(optionText, el.id); 
			$(o).html(optionText);
			$("#"+target).append(o);

			
   		});
		
	})
	.fail(function(response) {
		console.log(response);
	});
}

function setDesignation(event) {
	var url = $('#base_url').text()+'/designation/json/'+$(event).val();
	var target ='designations';
	console.log(url);
	console.log(target);
	$("#"+target).html('');
	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		
	})
	.done(function(response) {
		console.log(response);
		var optionText = '--Select--';
   		var o = new Option(optionText); 
   		$(o).html(optionText);
		$("#"+target).append(o);

		$.each(response, function(index, el) {
   			//console.log(el);
   			var optionText = el.name;
   			var o = new Option(optionText, el.id); 
			$(o).html(optionText);
			$("#"+target).append(o);

			
   		});
		
	})
	.fail(function(response) {
		console.log(response);
	});
}
/*Get Diff between two days in format of d/m/y*/
function getDateDiff(date1, date2, interval) {
    var second = 1000,
    minute = second * 60,
    hour = minute * 60,
    day = hour * 24,
    week = day * 7;
    var date1 = date1.split('/');
    date1 = new Date(date1[2],date1[1],date1[0]).getTime();
    
    var date2 = date2.split('/');
    date2 = new Date(date2[2],date2[1],date2[0]).getTime();
    
    
    var timediff = date2 - date1;
    
    if (isNaN(timediff)) return NaN;
    switch (interval) {
    case "years":
        return date2.getFullYear() - date1.getFullYear();
    case "months":
        return ((date2.getFullYear() * 12 + date2.getMonth()) - (date1.getFullYear() * 12 + date1.getMonth()));
    case "weeks":
        return Math.floor(timediff / week);
    case "days":
        return Math.floor(timediff / day);
    case "hours":
        return Math.floor(timediff / hour);
    case "minutes":
        return Math.floor(timediff / minute);
    case "seconds":
        return Math.floor(timediff / second);
    default:
        return undefined;
    }
}


// jQuery(document).ready(function($) {
// 	setInterval(getTask, 10000);
// 	getTask();

// });

// function getTask () {
// 	$.ajax({
// 		url: window.base_url+'/user/task',
// 		type: 'GET',
// 		dataType: 'JSON',
		
// 	})
// 	.done(function(response) {
// 		$('.taskHeader').html(response.data.count)
// 		var html ='';
// 		var priority = '';
// 		$.each(response.data.tasks, function(index, el) {
			
// 			if (el.priority == 1) {
// 				priority = 'text-muted';
// 			} else if(el.priority==2){
// 				priority = 'text-yellow';
// 			}else {
// 				priority = 'text-red';
// 			}

// 			html += '<li><a href="task/edit?show='+el.id+'"><h3 class="normal-wrap '+priority+'">'+el.name+'<small class="pull-right text-blue">'+el.due_time+'</small></h3></a></li>';
// 		});
// 		$('.taskList').html(html);
// 	})
// 	.fail(function() {
// 		console.log("error");
// 	})
// }



