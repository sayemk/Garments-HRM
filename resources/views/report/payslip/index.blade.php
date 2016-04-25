@extends('layouts.master')

@section('title','Payslip')
@section('sidebar')

@include('layouts.sidebar',['active' =>'payslip','parent_menu'=>'reports'])

@endsection

@section('content')
        <!-- Info boxes -->

<div class="box box-primary">

    <h3 class="box-title padding-left">Payslip</h3>

    <div class="box-body table-responsive no-padding">

        {!! $filter !!}
        <div class="pull-right">
            <button id="print_btn" class="btn btn-primary print_btn" >Print Payslip</button> &nbsp;
            <button id="report_download_btn" class="btn btn-primary " data-link="/report/payslip/download">Download Report</button>
            <br>
        </div>


        <div class="clearfix"></div>
        <div class="row" id="jquery_print">
            @foreach($salaries as $salary)
            <div class="col-xs-4">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center">
                            <p style="font-size: 20px">ডিকে গ্লোবাল ফ্যাশন ও্য়্যার লিমিটেড</p>
                            <span style="font-size: 14px">মোল্লা সুপার মার্কেট, বেরন, জামপাড়া, আশুলিয়া, সাভার, ঢাকা </span>
                        </th>
                    </tr>
                    </thead>

                        <tr>
                            <th>মাসের নাম</th>
                            <td>{{ months()[$salary->month] }}_{{ $salary->year }}</td>
                        </tr>

                        <tr>
                            <th>নাম</th>
                            <td>{{ $salary->employee->name }}</td>
                        </tr>
                        <tr>
                            <th>পদবী</th>
                            <td>{{ @$salary->employee->designations[0]->name }}</td>
                        </tr>
                        <tr>
                            <th>কার্ড নং</th>
                            <td>{{ $salary->employee->employee_id }}</td>
                        </tr>
                        <tr>
                            <th>গ্রেড</th>
                            <td>{{ $salary->employee->grade->name }}</td>
                        </tr>
                        <tr>
                            <th>যোগদান তারিখ</th>
                            <td>{{ $salary->employee->joining_date }}</td>
                        </tr>
                        <tr>
                            <th>মূল বেতন</th>
                            <td>{{ $salary->salaryStructure->basic }}</td>
                        </tr>
                        <tr>
                            <th>বাড়িভাড়া</th>
                            <td>{{ $salary->salaryStructure->house_rent }}</td>
                        </tr>
                        <tr>
                            <th>চিকিৎসা ভাতা</th>
                            <td>{{ $salary->salaryStructure->m_a }}</td>
                        </tr>
                        <tr>
                            <th>যাতায়াত ভাতা</th>
                            <td>{{ $salary->salaryStructure->t_a }}</td>
                        </tr>
                        <tr>
                            <th>খাদ্য ভাতা</th>
                            <td>{{ $salary->salaryStructure->f_a }}</td>
                        </tr>
                        <tr>
                            <th>মোট বেতন</th>
                            <td>{{ $salary->salaryStructure->gross }}</td>
                        </tr>
                        <tr>
                            <th>উপস্থিত দিন</th>
                            <td>{{ $salary->present_days }}</td>
                        </tr>
                        <tr>
                            <th>ছুটির দিন</th>
                            <td>{{ $salary->no_holidays }}</td>
                        </tr>
                        <tr>
                            <th>সাময়িক ছুটি</th>
                            <td>{{ $salary->leave_days }}</td>
                        </tr>
                        <tr>
                            <th>অনুপস্থিত দিন</th>
                            <td>{{ $salary->abs_days }}</td>
                        </tr>
                        <tr>
                            <th>মোট কর্মদিবস</th>
                            <td>{{ $salary->days_of_month }}</td>
                        </tr>
                        <tr>
                            <th>অনুপস্থিত কর্তন</th>
                            <td>{{ $salary->abs_deduction }}</td>
                        </tr>
                        <tr>
                            <th>মোট বেতন</th>
                            <td>{{ $salary->net_salary }}</td>
                        </tr>
                        <tr>
                            <th>হাজিরা বোনাস</th>
                            <td>{{ $salary->att_bonus }}</td>
                        </tr>
                        <tr>
                            <th>ওভারটাইম হার</th>
                            <td>{{ $salary->ot_rate }}</td>
                        </tr>
                        <tr>
                            <th>ওভারটাইম সময়</th>
                            <td>{{ $salary->ot_hours }}</td>
                        </tr>
                        <tr>
                            <th>ওভারটাইম টাকা</th>
                            <td>{{ $salary->ot_amount }}</td>
                        </tr>
                        <tr>
                            <th>সর্বোমোট  বেতন</th>
                            <td>{{ $salary->payable }}</td>
                        </tr>
                        <tr>
                            <th>অগ্রিম কর্তন</th>
                            <td>{{ $salary->adv_amount }}</td>
                        </tr>
                        <tr>
                            <th>রাজস্ব</th>
                            <td>{{ $salary->stamp }}</td>
                        </tr>
                        <tr>
                            <th>প্রদেয় বেতন</th>
                            <td>{{ $salary->payable-($salary->adv_amount+$salary->stamp) }}</td>
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
        {!! $salaries->render() !!}

    </div>


    <div class="box-footer clearfix">

    </div>
</div>




@endsection
@section('script')
    <script src="{{ asset('/assets/plugins/jQueryPrint/jQuery.print.js') }}"></script>
    <script>

        $(document).on('click', '#report_download_btn', function(event) {

            window.open($(this).attr('data-link')+$(location).attr('search'));


        });

        $("#print_btn").on('click', function() {
            //Print ele2 with default options
            $("#jquery_print").print({
                globalStyles: true,
                mediaPrint: false,
                stylesheet: null,
                noPrintSelector: ".no-print",
                iframe: true,
                append: null,
                prepend: null,
                manuallyCopyFormValues: true,
                deferred: $.Deferred(),
                timeout: 250,
                title: null,
                doctype: '<!doctype html>'
            });

        });

    </script>
@endsection