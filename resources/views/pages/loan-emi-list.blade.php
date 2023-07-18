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
                    <li class="breadcrumb-item active"><a href="#">Loan Emi List</a></li>
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
                    <h4 class="card-title">Current Month Emis</h4>
                </div>
                <div class="form-row" style="margin-left: 30px;">
                    <div class="col-6 mb-3">
                        <label for="username">Month Filter</label>
                        <input type="month" class="form-control" name="name" id="select_month">
                    </div>
                    <div class="col-4 mt-3">
                        <button type="button" class="btn btn-warning filter" style="margin-top:10px;">Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="emi_table" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Contact No</th>
                                    <th>EMIs Amount</th>
                                    <th>EMIs Date</th>
                                    <th class="no-content">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loan_details as $loan)

                                <tr>
                                    <td>{{$loan->Customer->name ?? "-"}}</td>
                                    <td>{{$loan->Customer->contact_no ?? "-"}}</td>
                                    <td>{{$loan->emi_amount ?? "-"}}</td>
                                    <?php $last_emi_date = DB::table('loan_emis')->where('loan_id', $loan->id)->orderBy('id', 'desc')->first();
                                    if (empty($loan->LoanEmi)) {
                                        $current_month = date('m');
                                        if(!empty($last_emi_date)){
                                            $current_month = date('m');
                                            $emi_date = $last_emi_date->emi_date;
                                            $date_explode = explode('-', $emi_date);
                                            $emi_date = @$date_explode[0].'-'. @$current_month.'-'. @$date_explode[2];
                                        }else{
                                            $emi_date = $loan->emi_date;
                                        }
                                        // $emi_date = $last_emi_date->emi_date;
                                        // $date_explode = explode('-', $emi_date);
                                        // $emi_date = $date_explode[0].'-'. $current_month.'-'. $date_explode[2];
                                    } else {
                                        if(!empty($last_emi_date)){
                                            $current_month = date('m');
                                            $emi_date = $last_emi_date->emi_date;
                                            $date_explode = explode('-', $emi_date);
                                            $emi_date = @$date_explode[0].'-'. @$current_month.'-'. @$date_explode[2];
                                        }else{
                                            $emi_date = $loan->emi_date;
                                        }
                                        
                                    }
                                    ?>
                                    <td>{{$emi_date ?? "-"}}</td>
                                    @if(empty($loan->LoanEmi))
                                    <td><button type="button" class="btn btn-danger pending_emi"
                                            value="{{$loan->id}}">Pending</button></td>
                                    @else
                                    <td><button type="button" class="btn btn-success">Received</button></td>
                                    @endif


                                </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END: Card DATA-->
</div>
<!-- Modal -->
<div class="modal fade" id="receving_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle1">Received EMIs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="loan_id" name="loan_id">
                Are You Sure You have Received EMIs ?
                <div class="form-group mx-sm-3 mb-2 mt-3">
                    <label for="inputPassword2" class="sr-only">Password</label>
                    <input type="text" class="form-control" id="remarks" placeholder="Remarks" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary received_emis">Yes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filter_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle1">Received EMIs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="filter_loan_id" name="filter_loan_id">
                <input type="text" id="filter_emi_date" name="filter_emi_date">
                Are You Sure You have Received EMIs ?
                <div class="form-group mx-sm-3 mb-2 mt-3">
                    <label for="inputPassword2" class="sr-only">Password</label>
                    <input type="text" class="form-control" id="filter_remarks" placeholder="Remarks" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary filter_received_emis">Yes</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('dist/vendors/jquery/jquery-3.3.1.min.js')}}"></script>
<script>
$(".pending_emi").click(function() {
    var loan_id = $(this).val();
    $('#receving_model').modal('show');
    $('#loan_id').val(loan_id);
});

$(document).on('click', '.received_emis', function() {
    var loan_id = $('#loan_id').val();
    var remarks = $('#remarks').val();
    if (!remarks) {
        alert('Pleasee enter remarks');
        return false;
    }
    $.ajax({
        type: "GET",
        url: "emi-received",
        data: {
            loan_id: loan_id,
            remarks: remarks
        },
        beforeSend: function() {
            $('.received_emis').html('Please Wait...');
            $(".received_emis").attr("disabled", true);
        },
        success: function(data) {
            $('.received_emis').html('Yes');
            $(".received_emis").attr("disabled", false);
            if (data.success == true) {
                swal('success', data.success_message, 'success');
                window.location.reload();
            } else {
                swal('error', data.error_message, 'error');
            }

        }
    });
});
$(document).on('click', '.filter', function() {
    var select_month = $('#select_month').val();

    $.ajax({
        type: "GET",
        url: "filter-data",
        data: {
            select_month: select_month,
        },
        beforeSend: function() {
            $('#emi_table').dataTable().fnClearTable();
            $('#emi_table').dataTable().fnDestroy();
        },
        success: function(data) {
            console.log(data.emi_months);

            $.each(data.emi_months, function(index, value) {

                
                var emi_date = value.emi_date;
                var emi = emi_date.split("-");
                var select_month = data.select_month + '-' + emi[2];

                var date1 = new Date(data.select_month);
                var date2 = emi[0]+ '-' + emi[1];
                var date3 = new Date(date2)
                if(date1 >= date3){

                if (value.loan_emi_filter == '' || value.loan_emi_filter == null) {

                    var button = `<button type="button" class="btn btn-danger last_month"
                                            value="` + value.id + `" data-emi="` + select_month +
                        `" >Pending</button></td>`;
                } else {
                    var button = `<button type="button" class="btn btn-success"
                                            value="` + value.id + `" >Receive</button></td>`;
                }

                $('#emi_table tbody').append("<tr><td>" + value
                    .customer.name + "</td><td>" + value
                    .customer.contact_no +
                    "</td><td>" + value.emi_amount + "</td><td>" + select_month +
                    "</td><td>" + button + "</td></tr>");
            }

            });

            (function($) {
                "use strict";
                var editor;
                $('#emi_table').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    responsive: true
                });



            })(jQuery);


        }

    });
});

$(document).on('click', '.last_month', function() {
    let dataId = $(this).attr("data-emi");
    let loan_id = $(this).val();
    $('#filter_model').modal('show');
    $('#filter_loan_id').val(loan_id);
    $('#filter_emi_date').val(dataId);
});

$(document).on('click', '.filter_received_emis', function() {
    var loan_id = $('#filter_loan_id').val();
    var remarks = $('#filter_remarks').val();
    var emi_date = $('#filter_emi_date').val();

    if (!remarks) {
        alert('Pleasee enter remarks');
        return false;
    }
    $.ajax({
        type: "GET",
        url: "previous-month-emi",
        data: {
            loan_id: loan_id,
            remarks: remarks,
            emi_date: emi_date
        },
        beforeSend: function() {
            $('.filter_received_emis').html('Please Wait...');
            $(".filter_received_emis").attr("disabled", true);
        },
        success: function(data) {
            $('.filter_received_emis').html('Yes');
            $(".filter_received_emis").attr("disabled", false);
            if (data.success == true) {
                swal('success', data.success_message, 'success');
                window.location.reload();
            } else {
                swal('error', data.error_message, 'error');
            }

        }
    });
});
</script>

@endsection