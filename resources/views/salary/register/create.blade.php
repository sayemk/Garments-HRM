@extends('layouts.master')

@section('title','Salary Structure')
@section('sidebar')

@include('layouts.sidebar',['active' =>'salary','parent_menu'=>'salary'])

@endsection

@section('content')
        <!-- Info boxes -->

<div class="box box-primary">

    <h3 class="box-title padding-left">Salary Calculation </h3>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">

                @include('layouts.validationError')
                @include('layouts.system_message')

                {!! Form::open(array('url' => 'salary/store', 'method' => 'POST')) !!}

                <div class="form-group">
                    <label for="faq_category" class="control-label">Month</label>

                    {!! Form::select('month', months(), old('month'), ['class'=>'form-control', 'id' => 'month']) !!}

                </div>

                <div class="form-group">
                    <label for="faq_category" class=" control-label">Year</label>

                    <input type="text" id="holidayYear" name="year" class="form-control"  data-mask="">

                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
            <div class="col-sm-2"></div>
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
        $("#holidayYear").inputmask("yyyy", {"placeholder": ""});
    </script>
@endsection
