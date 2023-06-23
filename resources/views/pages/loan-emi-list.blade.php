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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>EMIs Amount</th>
                                    <th>EMIs Date</th>
                                    <th class="no-content">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loan_details as $loan)

                                <tr>
                                    <td>{{$loan->Customer->name ?? "-"}}</td>
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
 <div class="modal fade" id="receving_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle1">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <input type="hidden" id="loan_id" name="loan_id">
                                            Are You Sure You have Received EMIs ? </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                                <button type="button" class="btn btn-primary received_emis">Yes</button>
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
    $.ajax({
        type: "GET",
        url: "emi-received",
        data: {
            loan_id: loan_id
        },
        beforeSend: function() {

        },
        success: function(data) {
            if (data.success == true) {
                alert(data.success_message);
                window.location.reload();
            } else {
                alert(data.error_message);
            }

        }
    });
});
</script>

@endsection