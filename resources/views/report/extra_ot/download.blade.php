@extends('layouts.master-pdf')

@section('content')
        <!-- Info boxes -->


<div class="table-responsive no-padding pdf-font-size">


    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th width="20px">Name</th>
            <th>Card No</th>
            <th >Degination</th>
            <th>Grade</th>
            <th style="width: 15px">Date of Joining</th>
            <th>Basic</th>
            <th>H/R</th>
            <th>M/A</th>
            <th>T/A</th>
            <th>F/A</th>
            <th>Gross</th>

            <th>OT Rate</th>
            <th>OT Hours</th>
            <th>OT Amount</th>
            <th>Pay Able</th>
            <th width="25px">Signature</th>


        </tr>
        </thead>
        <tbody>
        <?php
        if(!empty(\Input::get('page')))
        {
            $counter = \Input::get('page')*config('hrm.report_row_per_page')-config('hrm.report_row_per_page');
        }else{
            $counter =0;
        }
        ?>
        @foreach($salaries as $salary)
            <tr>
                <td>{{ ++$counter }}</td>
                <td>{{ $salary->employee->name }}</td>
                <td>{{ $salary->employee->employee_id }}</td>
                <td>{{ @$salary->employee->designations[0]->name }}</td>
                <td>{{ $salary->employee->grade->name }}</td>
                <td>{{ $salary->employee->joining_date }}</td>
                <td>{{ $salary->salaryStructure->basic }}</td>
                <td>{{ $salary->salaryStructure->house_rent }}</td>
                <td>{{ $salary->salaryStructure->m_a }}</td>
                <td>{{ $salary->salaryStructure->t_a }}</td>
                <td>{{ $salary->salaryStructure->f_a }}</td>
                <td>{{ $salary->salaryStructure->gross }}</td>

                <td>{{ $salary->ot_rate }}</td>
                <td>{{ $salary->extra_ot_hour }}</td>
                <td>{{ $salary->extra_ot_amount }}</td>
                <td>{{ floor($salary->payable + $salary->extra_ot_amount) }}</td>
                <td></td>


            </tr>

        @endforeach
        </tbody>
    </table>


</div>

@endsection
