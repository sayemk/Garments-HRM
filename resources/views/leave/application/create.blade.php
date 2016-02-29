@extends('layouts.master')

@section('title','Leave Application')
@section('sidebar')

@include('layouts.sidebar',['active' =>'leaveapplication','parent_menu'=>'leave'])

@endsection

@section('content')
        <!-- Info boxes -->

<div class="box box-primary">

    <h3 class="box-title padding-left"> Leave Application </h3>

    <div class="box-body">
        <div class="row">
            {!! Form::open(array('url' => 'leaveapplication', 'method' => 'POST', 'id'=>'leaveapplication')) !!}
            <div class="col-sm-8">

                @include('layouts.validationError')
                @include('layouts.system_message')

                
                <div class="form-group">
                    <label for="faq_category" class="control-label">Employee ID</label>

                    <input type="text"  name="employee_id" id="employee_id"  class="form-control" placeholder="Ex: EMP-0001">

                </div>

                <div class="form-group">
                    <label for="faq_category" class="control-label">Employee Name</label>

                    <input type="text" id="employee_name"  name="employee_name" class="form-control" readonly>

                </div>


                <div class="form-group">
                    <label for="faq_category" class="control-label">Start Day</label>

                    <input type="text" id="start_date" name="start_date" class="form-control"  data-mask="">

                </div>
                <div class="form-group">
                    <label for="faq_category" class="control-label">End Day</label>

                    <input type="text" id="end_date" name="end_date" class="form-control"  data-mask="">

                </div>

                <div class="form-group">
                    <label for="faq_category" class="control-label">Total Days</label>

                    <input type="text" id="total_day" name="total_day" class="form-control"  data-mask="">

                </div>

            </div>
            {{-- Summary Report --}}
            <div class="col-sm-4" id="leave_summary">
                
            </div>
       
            <div class="col-sm-12">
                <table   class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Sub Total Days</th>
                        <th>Payable</th>
                        <th>
                            <button id="opp_add_new_row" type="button" class="btn btn-success btn-xs center-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></button>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="form-grid">
                    <tr>
                        <td>


                            {!! Form::select('leave_type[]', $leaveType, old('leave_type[]'), ['class'=>'form-control','id'=>'leave_type']) !!}


                        </td>
                        <td>

                            <input type="text" name="sub_start_date[]" class="form-control" placeholder="dd/mm/yyyy" data-inputmask="'mask': 'd/m/y'">

                        </td>
                        <td>
                            <input type="text" name="sub_end_date[]" onchange="getSubTotal(this)" class="form-control" placeholder="dd/mm/yyyy"  data-inputmask="'mask': 'd/m/y'">

                        </td>
                        <td>
                            <input type="text" name="sub_total_days[]" class="form-control" placeholder="">
                        </td>
                        <td>
                            {!! Form::select('payable[]', ['1'=>'Yes','0'=>'No'], old('payable[]'), ['class'=>'form-control','id'=>'payable']) !!}
                        </td>
                        <td >
                            <button type="button" class="opp_remove btn btn-warning btn-xs center-block"><span class="glyphicon glyphicon-minus" aria-hidden="true"></button>

                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
            <div class="form-group">
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


    <div class="box-footer clearfix">

    </div>
</div>




@endsection

@section('script')

    <script src="{{ asset('/assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('/assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('/assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

    <script>
        $("#start_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $("#end_date").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        $(":input").inputmask();

        jQuery(document).ready(function($) {

                //Add new row
                $(document).on('click', '#opp_add_new_row', function(event) {
                    var leave_type = $("#leave_type > option").clone();
                    var str = '<tr>  <td> <select name="leave_type[]" class="form-control">';

                    $.each(leave_type,function(index, el) {
                        str += el.outerHTML;
                    });


                    str +='</select> </td><td> <input type="text" name="sub_start_date[]" class="form-control" placeholder="dd/mm/yyyy" data-inputmask="\'mask\': \'d/m/y\'"> </td> <td> <input type="text" name="sub_end_date[]" onchange="getSubTotal(this)" class="form-control" placeholder="dd/mm/yyyy" data-inputmask="\'mask\': \'d/m/y\'"> </td><td><input type="text" name="sub_total_days[]" class="form-control" placeholder=""></td>';

                    str += '<td> <select name="payable[]" class="form-control">';
                    var payable = $("#payable > option").clone();
                    $.each(payable,function(index, el) {
                        str += el.outerHTML;
                    });

                    str +='</select> </td><td style="max-width:20px">   <button type="button" class="opp_remove btn btn-warning btn-xs center-block"><span class="glyphicon glyphicon-minus" aria-hidden="true"></button> </td></tr> ';

                    $('#form-grid').append(str);

                    //Regenerate Input Mask

                    $(":input").inputmask();

                });
                //Remove row
                $(document).on('click', '.opp_remove', function(event) {

                    if ($(event.target).closest('tr').siblings().length) {
                        $(event.target).closest('tr').remove();
                    } else{
                        swal("Whoops!", "At least one row is required! ", "info");
                    };

                });

                $('#employee_id').change(function(event) {
                    var employee_id = $('#employee_id').val();

                    $.ajax({
                        url: $('#base_url').text()+'/leave/summary/json/'+employee_id,
                        type: 'GET',
                        dataType: 'json',
                        
                    })
                    .done(function(response) {
                        console.log(response);
                        if (response.status) {
                            $('#employee_name').val(response.employee);
                            var str = '<table class="table table-bordered"> <tr> <th>Leave Type</th> <th>Balance</th> </tr> ';

                            $.each(response.summary, function(index, val) {
                                  var balance = val.alocated - val.spent;
                                  str += '<tr><td>'+val.leaveType+'</td><td>'+balance+'</td></tr>';
                             }); 

                            str +='</table>';
                            $('#leave_summary').html(str);
                        };
                    })
                    .fail(function(response) {
                        swal("Whoops!", "Fail to load Summary Report", "info");
                    })
                    
                });

              //Count Total Days

                $('#end_date').change(function(event) {
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                   
                    if ($.trim(start_date).length >0 && $.trim(end_date).length > 0) {
                        
                        var total_day = getDateDiff(start_date,end_date, 'days') +1;

                       $('#total_day').val(total_day);
                        
                    };
                });

                $('#leaveapplication').formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        gender: {
                            validators: {
                                notEmpty: {
                                    message: 'The gender is required'
                                }
                            }
                        },
                        'browsers[]': {
                            validators: {
                                notEmpty: {
                                    message: 'Please specify at least one browser you use daily for development'
                                }
                            }
                        },
                        'editors[]': {
                            validators: {
                                notEmpty: {
                                    message: 'The editor names are required'
                                }
                            }
                        }
                    }
                });  
                
        });

        function getSubTotal (event) {
           var end_date = ( $(event).val());
           var start_date = $(event).parent().parent().children('td').children('input').eq(0).val();
           if ($.trim(start_date).length >0 && $.trim(end_date).length > 0) {
                        
                var total_day = getDateDiff(start_date,end_date, 'days') +1;

                $(event).parent().parent().children('td').children('input').eq(2).val(total_day);
                
            };
        }
    </script>
@endsection
