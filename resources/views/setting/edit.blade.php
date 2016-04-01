@extends('layouts.master')

@section('title','setting')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'setting','parent_menu'=>'Setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
        	<div class="box box-primary">
            
              <h3 class="box-title padding-left">Attendance</h3>
           
              <div class="box-body">
                
                <div class="col-md-12">
				
					<div class="col-sm-8">
	                  
	                  {!! $edit->message !!}	                 
	                  {!! $edit->header !!}


	                  <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                       {!! $edit->render('string') !!}
	                      </div>
	                    </div>
	                     <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('value') !!}
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
            
            string: {
                required: true,
            },
            value: {
               required: true,
            },
            

        },

    });
});
  </script>
@endsection
