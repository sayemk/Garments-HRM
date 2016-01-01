
@if (count($errors) > 0)
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
		<div class="alert alert-danger alert-dismissable">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-ban"></i> Validation fail!</h4>
	        @foreach ($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
	    </div>
			       
	</div>
@endif