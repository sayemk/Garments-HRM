@extends('layouts.master')

@section('title',"Leave Application Details: ".$leaveapplication->employee->name )
@section('sidebar')

   @include('layouts.sidebar',['active' =>'leaveapplication','parent_menu'=>'leave'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Leave Application Details: {{ $leaveapplication->employee->name }}</h3>
           
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <tbody>
              <tr>
                <th>Employee</th>
                <th>
                  <a href="{{ url('employee/edit?modify=').$leaveapplication->employee->id }}">
                    {{ $leaveapplication->employee->name }}({{ $leaveapplication->employee->employee_id }})
                  </a>
                </th>
              </tr>
              <tr>
                <th>Leave Start Date</th>
                <th>{{ $leaveapplication->start_day }}</th>
              </tr>
              <tr>
                <th>Leave End Date</th>
                <th>{{ $leaveapplication->end_day }}</th>
              </tr>
              <tr>
                <th>Total Leave Days</th>
                <th>{{ $leaveapplication->total_days }}</th>
              </tr>
              
            </tbody>
          </table>

        </div>
        <div class="table-responsive">
          <h4 class="box-title padding-left">Leave Details</h4>
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Sub Total Days</th>
                <th>Is Payble</th>
              </tr>
            </thead>
            <tbody>
              @foreach($leaveapplication->leaveDetails as $detail)
                <tr>
                  <td>{{ $detail->leaveType->name }}</td>
                  <td>{{ $detail->start_day }}</td>
                  <td>{{ $detail->end_day }}</td>
                  <td>{{ $detail->days }}</td>
                  <td>{{ leavePayable($detail->payable) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>  
       </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
   </div>  

            
          
          
@endsection
