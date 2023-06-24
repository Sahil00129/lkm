<footer class="site-footer">
    2023 &copy; Chabra
</footer>
<!-- END: Footer-->


<!-- START: Back to top-->
<a href="#" class="scrollup text-center">
    <i class="icon-arrow-up"></i>
</a>
<!-- END: Back to top-->


<!-- START: Template JS-->
<script src="{{asset('dist/vendors/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('dist/vendors/jquery/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('dist/vendors/moment/moment.js')}}"></script>
<script src="{{asset('dist/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('dist/vendors/slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- END: Template JS-->

<!-- START: APP JS-->
<script src="{{asset('dist/js/app.js')}}"></script>
<!-- END: APP JS-->

<!-- START: Page Vendor JS-->
<script src="dist/vendors/raphael/raphael.min.js')}}"></script>
<script src="{{asset('dist/vendors/morris/morris.min.js')}}"></script>
<script src="{{asset('dist/vendors/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('dist/vendors/starrr/starrr.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.canvaswrapper.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.colorhelpers.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.saturated.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.browser.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.drawSeries.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.uiConstants.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.legend.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('dist/vendors/chartjs/Chart.min.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-jvectormap/jquery-jvectormap-2.0.3.min.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-jvectormap/jquery-jvectormap-world-mill.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-jvectormap/jquery-jvectormap-de-merc.js')}}"></script>
<script src="{{asset('dist/vendors/jquery-jvectormap/jquery-jvectormap-us-aea.js')}}"></script>
<script src="{{asset('dist/vendors/apexcharts/apexcharts.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- START: Page JS-->
<script src="{{asset('dist/js/home.script.js')}}"></script>
<!-- END: Page JS-->

<!-- START: Page Vendor JS-->
<script src="{{asset('dist/vendors/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/jszip/jszip.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('dist/vendors/datatable/buttons/js/buttons.print.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- START: Page Script JS-->
<script src="{{asset('dist/js/datatable.script.js')}}"></script>
<!-- END: Page Script JS-->

<!-- START: Page Vendor JS-->
<script src="{{asset('dist/vendors/sweetalert/sweetalert.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- START: Page Script JS-->
<script src="{{asset('dist/js/sweetalert.script.js')}}"></script>
<!-- END: Page Script JS-->
<script>
var bodycolor = getComputedStyle(document.body).getPropertyValue('--bodycolor');

$(document).ready(function() {
  
    $.ajax({
        type: "GET",
        url: "total-amount-chart",
        success: function(response) {
            var total_amount = parseInt(response.total_amount);
            var pending_amount = parseInt(response.pending_amount);
            var receving_amount = parseInt(response.receving_amount);

            var config = {

                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [total_amount, receving_amount, pending_amount],
                        backgroundColor: [
                            '#1e3d73',
                            '#17a2b8',
                            '#ffc107'
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [
                        'Total Amount',
                        'Receving Amount',
                        'pending Amount',
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            fontColor: bodycolor,
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                }
            };
            var chartjs_other_pie = document.getElementById("chartjs-other-pie");
            if (chartjs_other_pie) {
                var ctx = document.getElementById('chartjs-other-pie').getContext('2d');
                window.myDoughnut = new Chart(ctx, config);
            }
        }
    });
});
</script>