@extends('layouts.master-pdf')

@section('content')
        <!-- Info boxes -->


<div class="box-body table-responsive no-padding">


    <div class="row">
        @foreach($salaries as $salary)
            <div class="col-md-4" style="float:left;">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2" style="text-align: center; font-size: 20px">
                            <h1 >ডিকে গ্লোবাল ফ্যাশন ও্য়্যার লিমিটেড</h1>

                        </th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align: center;">
                           মোল্লা সুপার মার্কেট, বেরন, জামপাড়া, আশুলিয়া, সাভার, ঢাকা
                        </th>
                    </tr>
                    </thead>

                    <tr>
                        <th>মাসের নাম</th>
                        <td style="text-align: right">{{ months()[$salary->month] }}_{{ $salary->year }}</td>
                    </tr>

                    <tr>
                        <th>নাম</th>
                        <td style="text-align: right">{{ $salary->employee->name }}</td>
                    </tr>
                    <tr>
                        <th>পদবী</th>
                        <td style="text-align: right">{{ @$salary->employee->designations[0]->name }}</td>
                    </tr>
                    <tr>
                        <th>কার্ড নং</th>
                        <td style="text-align: right">{{ $salary->employee->employee_id }}</td>
                    </tr>
                    <tr>
                        <th>গ্রেড</th>
                        <td style="text-align: right">{{ $salary->employee->grade->name }}</td>
                    </tr>
                    <tr>
                        <th>যোগদান তারিখ</th>
                        <td style="text-align: right">{{ date('d-M-Y',strtotime($salary->employee->joining_date)) }}</td>
                    </tr>
                    <tr>
                        <th>মূল বেতন</th>
                        <td style="text-align: right">{{ $salary->salaryStructure->basic }}</td>
                    </tr>
                    <tr>
                        <th>বাড়িভাড়া</th>
                        <td style="text-align: right">{{ $salary->salaryStructure->house_rent }}</td>
                    </tr>
                    <tr>
                        <th>চিকিৎসা ভাতা</th>
                        <td style="text-align: right">{{ $salary->salaryStructure->m_a }}</td>
                    </tr>
                    <tr>
                        <th>যাতায়াত ভাতা</th>
                        <td style="text-align: right">{{ $salary->salaryStructure->t_a }}</td>
                    </tr>
                    <tr>
                        <th>খাদ্য ভাতা</th>
                        <td style="text-align: right">{{ $salary->salaryStructure->f_a }}</td>
                    </tr>
                    <tr>
                        <th>মোট বেতন</th>
                        <td style="text-align: right">{{ $salary->salaryStructure->gross }}</td>
                    </tr>
                    <tr>
                        <th>উপস্থিত দিন</th>
                        <td style="text-align: right">{{ $salary->present_days }}</td>
                    </tr>
                    <tr>
                        <th>ছুটির দিন</th>
                        <td style="text-align: right">{{ $salary->no_holidays }}</td>
                    </tr>
                    <tr>
                        <th>সাময়িক ছুটি</th>
                        <td style="text-align: right">{{ $salary->leave_days }}</td>
                    </tr>
                    <tr>
                        <th>অনুপস্থিত দিন</th>
                        <td style="text-align: right">{{ $salary->abs_days }}</td>
                    </tr>
                    <tr>
                        <th>মোট কর্মদিবস</th>
                        <td style="text-align: right">{{ $salary->days_of_month }}</td>
                    </tr>
                    <tr>
                        <th>অনুপস্থিত কর্তন</th>
                        <td style="text-align: right">{{ $salary->abs_deduction }}</td>
                    </tr>
                    <tr>
                        <th>মোট বেতন</th>
                        <td style="text-align: right">{{ $salary->net_salary }}</td>
                    </tr>
                    <tr>
                        <th>হাজিরা বোনাস</th>
                        <td style="text-align: right">{{ $salary->att_bonus }}</td>
                    </tr>
                    <tr>
                        <th>ওভারটাইম হার</th>
                        <td style="text-align: right">{{ $salary->ot_rate }}</td>
                    </tr>
                    <tr>
                        <th>ওভারটাইম সময়</th>
                        <td style="text-align: right">{{ $salary->ot_hours }}</td>
                    </tr>
                    <tr>
                        <th>ওভারটাইম টাকা</th>
                        <td style="text-align: right">{{ $salary->ot_amount }}</td>
                    </tr>
                    <tr>
                        <th>সর্বোমোট  বেতন</th>
                        <td>{{ $salary->payable }}</td>
                    </tr>
                    <tr>
                        <th>অগ্রিম কর্তন</th>
                        <td style="text-align: right">{{ $salary->adv_amount }}</td>
                    </tr>
                    <tr>
                        <th>রাজস্ব</th>
                        <td style="text-align: right">{{ $salary->stamp }}</td>
                    </tr>
                    <tr>
                        <th>প্রদেয় বেতন</th>
                        <td style="text-align: right">{{ $salary->payable-($salary->adv_amount+$salary->stamp) }}</td>
                    </tr>
                    <tr>
                        <th>স্বাক্ষর</th>
                        <td></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        @endforeach

    </div>


</div>

@endsection
