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
                                    <th class="no-content" style="width: 94px;">Actions</th>
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
                                            class=" btn btn-sm btn-primary ml-2">view</a>
                                        <?php 
                                        $emi_date = explode('-',@$loan->LoanDetail->emi_date);
                                        $emi_date = @$emi_date[0].'-'.@$emi_date[1];
                                        $today_month = date('Y-m');
                                        ?>
                                        @if($today_month > $emi_date && $loan->LoanDetail->previous_status == 0)
                                        <button type="button" class="btn btn-warning edit"
                                            value="{{$loan->LoanDetail->id}}"
                                            data-amount="{{$loan->LoanDetail->total_amount}}"
                                            data-date="{{$loan->LoanDetail->emi_date}}"
                                            data-total-emi="{{$loan->LoanDetail->no_of_emi}}"
                                            data-emi-amount="{{$loan->LoanDetail->emi_amount}}"
                                            style="height:28px;">Edit</button>
                                        @endif
                                    </td>
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

<!-- Modal -->
<div class="modal fade" id="edit_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle1">Received EMIs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="update_previous">
                <div class="modal-body">
                    <input type="hidden" id="loan_id" name="loan_id">
                    <input type="hidden" id="total_emi" name="total_emi">
                    <input type="hidden" id="emi_amount" name="emi_amount">
                    <div class="col-12 mb-3">
                        <label for="username">Total Amount</label>
                        <input type="text" class="form-control" name="total_amount" id="total_amount" readonly>

                    </div>
                    <div class="col-12 mb-3">
                        <label for="username">No of month emi receive</label>
                        <input type="number" class="form-control" name="count_emi" id="count_emi"
                            oninput="calculateEMIMonth()">

                    </div>
                    <div class="col-12 mb-3">
                        <label for="username">Received Amount</label>
                        <input type="number" class="form-control" name="received_amount" id="received_amount" readonly>

                    </div>
                    <div class="col-12 mb-3">
                        <label for="username">From Date</label>
                        <input type="date" class="form-control" name="" id="frm_date" readonly>

                    </div>
                    <!-- <div class="col-12 mb-3">
                        <label for="username">To Date</label>
                        <input type="date" class="form-control" name="end_emi_date" id="end_emi_date" required>

                    </div> -->
                    <div class="col-12 mb-3">
                        <label for="username">Remarks</label>
                        <input type="text" class="form-control" name="remarks" id="remarks" required>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('dist/vendors/jquery/jquery-3.3.1.min.js')}}"></script>
<script>
$(".edit").click(function() {
    var loan_id = $(this).val();
    var total_amount = $(this).attr('data-amount');
    var date = $(this).attr('data-date');
    var total_emi = $(this).attr('data-total-emi');
    var emi_amount = $(this).attr('data-emi-amount');

    $('#edit_model').modal('show');
    $('#loan_id').val(loan_id);
    $('#total_amount').val(total_amount);
    $('#frm_date').val(date);
    $('#total_emi').val(total_emi);
    $('#emi_amount').val(emi_amount);
});

// 
$("#update_previous").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    var base_url = window.location.origin;
    $.ajax({
        url: "update-previous-data",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(".indicator-progress").show();
            $(".indicator-label").hide();
            $('.disableme').prop('disabled', true);
        },
        success: (data) => {
            $('.disableme').prop('disabled', true);
            $(".indicator-progress").hide();
            $(".indicator-label").show();
            if (data.success == true) {
                swal("success", data.message, "success");
                window.location.reload();
            } else {
                swal("error", data.message, "error");
            }
        },
    });
});

function calculateEMIMonth() {
    var emi_receve = $('#count_emi').val();
    var emi_amt = $('#emi_amount').val();
    var start_emi_date = $('#frm_date').val();
    let currentDate = new Date().toJSON().slice(0, 10);

    var $startdate = new Date($('#frm_date').val())
    var $enddate = new Date(new Date().toJSON().slice(0, 10))
    var $months = $enddate.getMonth() - $startdate.getMonth() + (12 * ($enddate.getFullYear() - $startdate
        .getFullYear())) + 1;
    if (emi_receve > $months) {
        swal('error', 'Please select', 'error');
        $('#count_emi').val('');
        $('#received_amount').val('');
        return false;
    }
    var receved_amt = emi_amt * emi_receve;
    $('#received_amount').val(receved_amt.toFixed(2));

}
</script>


@endsection