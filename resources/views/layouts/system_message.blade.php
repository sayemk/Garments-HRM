@if (session('system_message') !='' || !is_null(session('system_message')))
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
		<div class="alert alert-success alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-warning"></i> System Message!</h4>
	         {{ session('system_message') }}
	    </div>
			       
	</div>
	<div class="clearfix"></div>
@endif