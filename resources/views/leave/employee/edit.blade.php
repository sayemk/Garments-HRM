@extends('layouts.master')

@section('title','Employee Leave Allocation')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'leaveemployee','parent_menu'=>'leave'])

@endsection

@section('content')
  <!-- Info boxes -->
		 <ul class="breadcrumb">
		    <li>
		        <i class="icon-home"></i>
		        <a href="index-2.html">Home</a>
		        <i class="icon-angle-right"></i>
		    </li>
		    <li><a href="#">Employee Leave Allocation</a></li>
		</ul>
        	<div class="box box-primary">
            
              <h3 class="box-title padding-left">Employee Leave Allocation</h3>
           
              <div class="box-body">
                
                <div class="col-md-12">
				
					<div class="col-sm-8">
	                  
	                  {!! $edit->message !!}	                 
	                  {!! $edit->header !!}
	                
	                    <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('employee.employee_id') !!}
	                      </div>
	                    </div>
	                    <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('leavetype_id') !!}
	                      </div>
	                    </div>
	                    <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('leave_day') !!}
	                      </div>
	                    </div>
	                    <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('year') !!}
	                      </div>
	                    </div>
	                                                         
	                    <div class="form-group">
	                      <div class="col-sm-offset-2 col-sm-9">
	                        {!! $edit->footer !!}
	                      </div>
	                    </div>
	                  
	                </div>
					
				</div>
			<div class="box-footer clearfix">
		                  
                </div>
            </div>  

        </div>
            
          
          
@endsection

@section('script')
  <script>
  	jQuery(document).ready(function($) {
	  $('form').validate({ 
        
        rules: {
            
            auto_employee_employee_id: {
                required: true,
            },
            leavetype_id: {
                required: true,
                numeric:true
            },
            leave_day: {
                required: true,
                numeric:true
            },
            year: {
                required: true,
                numeric:true
            },
        },

    });
});
  </script>
@endsection
