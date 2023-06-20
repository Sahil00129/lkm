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
                    <li class="breadcrumb-item">Loan List</li>
                    <li class="breadcrumb-item active"><a href="#">Customer Emi</a></li>
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
                    <h4 class="card-title">Data Tabel</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="display table dataTable table-striped table-bordered">
                            <thead>
                                <tr>
                                <th>Emi Date</th>
                                <th>Receving Date</th>
                                <th>Pending Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                @foreach($Emi_details as $emi)
                                    <?php

                                     $changeformat = date('d-m-Y', strtotime($emi->created_at));
                                    ?>
                                    <tr>
                                        <td>{{$emi->emi_date}}</td>
                                        <td>{{$changeformat}}</td>
                                        <td>{{$emi->pending_amt}}</td>

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
@endsection