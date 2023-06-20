@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid site-width">
    <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto">
                    <h4 class="mb-0">Datatable</h4>
                </div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Loan Module</li>
                    <li class="breadcrumb-item active"><a href="#">Customer Loan List</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header  justify-content-between align-items-center">
                    <h4 class="card-title">Customer Loan List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Father Name</th>
                                    <th>Contact No</th>
                                    <th>Loan Amount</th>
                                    <th>Interest Rate (Rupee):</th>
                                    <th>No of Month</th>
                                    <th>EMIs Amount</th>
                                    <th>EMIs Date</th>
                                    <th>Received Amount</th>
                                    <th>Pending Amount</th>
                                    <th class="no-content">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loan_details as $loan)
                                <tr>
                                    <td>{{$loan->name ?? "-"}}</td>
                                    <td>{{$loan->father_name ?? "-"}}</td>
                                    <td>{{$loan->contact_no ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->loan_amount ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->rate_of_interest ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->no_of_emi ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->emi_amount ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->emi_date ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->received_amount ?? "-"}}</td>
                                    <td>{{$loan->LoanDetail->pending_amount ?? "-"}}</td>
                                    <td><a href="{{ url('view-emis-list/'.$loan->id) }}"
                                            class=" btn btn-sm btn-primary ml-2">view</a></td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Father Name</th>
                                    <th>Contact No</th>
                                    <th>Loan Amount</th>
                                    <th>Rate Interest</th>
                                    <th>No of EMIs</th>
                                    <th>EMIs Amount</th>
                                    <th>EMIs Date</th>
                                    <th>Received Amount</th>
                                    <th>Pending Amount</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Card DATA-->
</div>

@endsection