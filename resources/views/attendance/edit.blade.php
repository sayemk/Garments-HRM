@extends('layouts.master')

@section('title','Atendance')
@section('sidebar')
   @include('layouts.sidebar',['active' =>'attendance','parent_menu'=>'Attendance Setting'])
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
	                       {!! $edit->render('employee_id') !!}
	                      </div>

	                    </div>
	                     <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('date') !!}
	                      </div>

	                    </div>
	                    <div class="form-group">
	                     
	                      <div class="col-sm-offset-2 col-sm-12">
	                        {!! $edit->render('in_time') !!}
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      
	                      <div class=" col-sm-offset-2 col-sm-12">
	                       {!! $edit->render('out_time') !!}
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      
	                      <div class=" col-sm-offset-2 col-sm-12">
	                       {!! $edit->render('duration') !!}
	                      </div>
	                    </div>
	                    <div class="form-group">
	                      
	                      <div class=" col-sm-offset-2 col-sm-12">
	                       {!! $edit->render('let_time') !!}
	                      </div>
	                    </div>

	                    <div class="form-group">
	                      
	                      <div class=" col-sm-offset-2 col-sm-12">
	                       {!! $edit->render('overtime') !!}
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
   <script src="{{ asset('/assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('/assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('/assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

  <script>
   		$("#date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("#end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $(":input").inputmask();


  	jQuery(document).ready(function($) {
  		var settings = {!! $settings !!}
  		console.log(getSettingValue(settings,'attendance_buffer_time'));

	  $('form').validate({ 
        
        rules: {
            
       
            
        },
    });
	  //time calculation
	   $("#out_time").change(function(){            
			
			
			var intime = $("#in_time").val();
			var outtime = $("#out_time").val();

			setDuration(intime,outtime);
			setOvertime(intime,outtime, getSettingValue(settings,'office_duration_time'));
		});

	    //time calculation
	   $("#in_time").change(function(){            
			
			
			var intime = $("#in_time").val();

			setLate(intime, getSettingValue(settings,'office_opening_time'), getSettingValue(settings,'attendance_buffer_time'));
		});

});
  	function toSeconds(time_str) {
			// Extract hours, minutes and seconds
			    var parts = time_str.split(':');
			    // compute  and return total seconds
			    return parts[0] * 3600 + // an hour has 3600 seconds
			    parts[1] * 60 + // a minute has 60 seconds
			    +
			    parts[2]; // seconds
			}

			function calDuration (a, b) {
				difference =  Math.abs(toSeconds(a) - toSeconds(b));

				var duration_array = [
				    Math.floor(difference / 3600), // an hour has 3600 seconds
				    Math.floor((difference % 3600) / 60), // a minute has 60 seconds
				    difference % 60
				];
				return duration_array;
			}

			function setDuration (intime,outtime) {
				
				var duration_array = calDuration(intime, outtime);
				
				// 0 padding and concatation
				duration = duration_array.map(function(v) {
				    return v < 10 ? '0' + v : v;
				}).join(':');
				$("#duration").val(duration);

			}

			function setOvertime (intime,outtime,officeHour) {
				
				var duration_array = calDuration(intime, outtime);

				if(duration_array[0]>=officeHour){
		   			duration_array[0] = duration_array[0]-officeHour;
		   			overtime = duration_array.map(function(v) {
					    return v < 10 ? '0' + v : v;
					}).join(':');
		   			$('#overtime').val(overtime);
		   		
		   		} else{
		   			$('#overtime').val('00:00:00');

		   		}
			}

			function setLate (intime,officeOPening, bufferTime) {
				var lateTime = toSeconds(intime)-toSeconds(officeOPening);
				console.log(lateTime);
				if(lateTime >= 0){
		   			lateTime =lateTime-toSeconds(bufferTime)
		   			if ( lateTime>= 0) {
		   				var duration_array = [
						    Math.floor(lateTime / 3600), // an hour has 3600 seconds
						    Math.floor((lateTime % 3600) / 60), // a minute has 60 seconds
						    lateTime % 60
						];
			   			lateTime = duration_array.map(function(v) {
						    return v < 10 ? '0' + v : v;
						}).join(':');
			   			$('#let_time').val(lateTime);
			   		}else {
			   			$('#let_time').val('00:00:00');
			   		}
		   		
		   		} else{
		   			$('#let_time').val('00:00:00');

		   		}
				
			}

			function getSettingValue (settings, param) {
				var val ='';
				for (var i = settings.length - 1; i >= 0; i--) {
					
					if(settings[i].string == param){
						
						val = settings[i].value;
						break;
					}
				};
				return val;
			}
  </script>
@endsection

