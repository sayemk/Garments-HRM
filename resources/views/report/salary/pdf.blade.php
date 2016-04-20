@extends('layouts.master-pdf')

@section('content')
        <!-- Info boxes -->


    <div class="table-responsive no-padding pdf-font-size">


        <table class="table table-bordered">

            <tr>
                <td>#</td>
                <td>Name</td>
                <td>Card No</td>
                <td>Degination</td>
                <td>Grade</td>
                <td style="min-widtd: 90px">Date of Joining</td>
                <td>Basic</td>
                <td>H/R</td>
                <td>M/A</td>
                <td>T/A</td>
                <td>F/A</td>
                <td>Gross</td>
                <td>Day of Month</td>
                <td>Present Days</td>
                <td>Montd Holidays</td>
                <td>Leaves</td>
                <td>Total  Days</td>
                <td>Abs. Day</td>
                <td>Abs. Dedc. </td>
                <td>Net Salary</td>
                <td>Attn. Bonus</td>
                <td>OT Rate</td>
                <td>OT Hours</td>
                <td>OT Amount</td>
                <td>Pay Able</td>
                <td>Adv. Amount</td>
                <td>Stamp</td>
                <td>Net Paid</td>
            </tr>

            <?php

                $counter =0;

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
                    <td>{{ $salary->days_of_month}}</td>
                    <td>{{ $salary->present_days }}</td>
                    <td>{{ $salary->no_holidays }}</td>
                    <td>{{ $salary->leave_days }}</td>
                    <td>{{ $salary->days_of_montd }}</td>
                    <td>{{ $salary->abs_days }}</td>
                    <td>{{ $salary->abs_deduction }}</td>
                    <td>{{ $salary->net_salary }}</td>
                    <td>{{ $salary->att_bonus }}</td>
                    <td>{{ $salary->ot_rate }}</td>
                    <td>{{ $salary->ot_hours }}</td>
                    <td>{{ $salary->ot_amount }}</td>
                    <td>{{ $salary->payable }}</td>
                    <td>{{ $salary->adv_amount }}</td>
                    <td>{{ $salary->stamp }}</td>
                    <td>{{ $salary->net_paid }}</td>
                </tr>

            @endforeach
            
        </table>


    </div>

@endsection
