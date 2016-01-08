@extends('layouts.master')

@section('title','Organization')
@section('sidebar')

  @include('layouts.sidebar',['active' =>'organization','parent_menu'=>'setting'])

@endsection


@section('page_heading', 'Organization')
@section('extra_heading')
	
@endsection
@section('content')
  <!-- Info boxes -->
         
            <div class="box">
              
              <div class="box-body">
                
                <div class="col-md-12">
				
					<table class="table">
						<tr>
							<td>Name</td>
							<td>Address</td>
							<td>Action</td>
						</tr>
						<tr>
							<td>{{ $organization->name }}</td>
							<td>{{ $organization->address }}</td>
							<td>
								<a href="{{ url("/organization/edit").'?modify='.$organization->id }}">
									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
							</td>
						</tr>
					</table>
					
				</div>
			<div class="box-footer clearfix">
		                  
                </div>
            </div>            
          
          
@endsection
