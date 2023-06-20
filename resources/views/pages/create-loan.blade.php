@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid site-width">
    <!-- START: Breadcrumbs-->
    <div class="row ">
        <div class="col-12  align-self-center">
            <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
                <div class="w-sm-100 mr-auto">
                    <h4 class="mb-0">Loan Form</h4>
                </div>

                <ol class="breadcrumb bg-transparent align-self-center m-0 p-0">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item">Loan Module</li>
                    <li class="breadcrumb-item active"><a href="#">Loan</a></li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END: Breadcrumbs-->

    <!-- START: Card Data-->
    <div class="row">

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <!-- <h4 class="card-title">Form</h4> -->
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form id="loan_finance" method="post" action="javascript:void(0)">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-6 mb-3">
                                            <label for="username">Customer's Name</label>

                                            <input type="text" class="form-control" name="name" id="cname">

                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Father's Name</label>
                                            <input type="text" class="form-control" id="f_name" name="father_name">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="username">Address</label>

                                            <input type="text" class="form-control" id="address" name="address">

                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Contact No</label>
                                            <input type="number" class="form-control" id="contact_no" name="contact_no"
                                                required>
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="username">Loan Amount</label>

                                            <input type="number" class="form-control" id="loanAmount" name="loan_amount"
                                                oninput="calculateEMI()" required>

                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Interest Rate (Rupee):</label>
                                            <input type="number" class="form-control" id="interestRate"
                                                name="rate_of_interest" oninput="calculateEMI()" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Number of Months</label>
                                            <input type="number" class="form-control" id="numEMIs" name="no_of_emi"
                                                oninput="calculateEMI()" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Emi Date</label>
                                            <input type="date" class="form-control" id="emiDate" name="emi_date"
                                                required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Emi Amount</label>
                                            <input type="text" class="form-control" id="emi_amount" name="emi_amount"
                                                readonly>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Total Interest to be Paid (₹):</label>
                                            <input type="text" class="form-control" id="interest"
                                                name="interest_to_paid" readonly>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="email">Total Amount (₹):</label>
                                            <input type="text" class="form-control" id="totalAmount" name="total_amount"
                                                readonly>
                                        </div>

                                        <div class="col-12">

                                            <button type="submit" class="btn btn-primary" id="submit">Save</button> <a
                                                href="{{url('create-loan')}}" class="btn btn-outline-warning">Reset</a>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Card DATA-->
</div>
<script src="{{asset('dist/vendors/jquery/jquery-3.3.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
function calculateEMI() {
    var principal = parseFloat(document.getElementById("loanAmount").value);
    var months = parseInt(document.getElementById("numEMIs").value);
    var interestRate = parseFloat(document.getElementById("interestRate").value);

    var monthlyInterestRate = interestRate / 100;
    var totalInterest = principal * monthlyInterestRate * months;
    var totalAmount = principal + totalInterest;
    var emiAmount = totalAmount / months;

    document.getElementById("interest").value = totalInterest.toFixed(2);
    document.getElementById("totalAmount").value = totalAmount.toFixed(2);
    document.getElementById("emi_amount").value = emiAmount.toFixed(2);
}
// 

$("#loan_finance").validate({
    rules: {
        name: {
            required: true,
            maxlength: 50
        },
        father_name: {
            required: true,
            maxlength: 50,
        },
        // contact_no: {
        //     required: true,
        //     maxlength: 10
        // },
    },
    messages: {
        name: {
            required: "Please enter customer name",
            maxlength: "Your name maxlength should be 50 characters long."
        },
        father_name: {
            required: "Please enter father name",
            maxlength: "The name should less than or equal to 50 characters",
        },
        // contact_no: {
        //     required: "Please enter phone number",
        //     maxlength: "Your number maxlength should be 10 characters long."
        // },
    },
    submitHandler: function(form) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submit').html('Please Wait...');
        $("#submit").attr("disabled", true);
        $.ajax({
            url: "{{url('store-loan-detail')}}",
            type: "POST",
            data: $('#loan_finance').serialize(),
            success: function(response) {
                $('#submit').html('Submit');
                $("#submit").attr("disabled", false);
                if (response.success == true) {
                    swal('success',response.success_message,'success');
                    window.location.href = "loan-list";
                } else {
                    alert(response.error_message);
                }
            }
        });
    }
})
</script>
@endsection