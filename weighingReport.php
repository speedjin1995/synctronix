<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<?php
require_once "php/db_connect.php";

$vehicles = $db->query("SELECT * FROM Vehicle WHERE status = '0'");
$vehicles2 = $db->query("SELECT * FROM Vehicle WHERE status = '0'");
$customer = $db->query("SELECT * FROM Customer WHERE status = '0'");
$customer2 = $db->query("SELECT * FROM Customer WHERE status = '0'");
$product = $db->query("SELECT * FROM Product WHERE status = '0'");
$product2 = $db->query("SELECT * FROM Product WHERE status = '0'");
$transporter = $db->query("SELECT * FROM Transporter WHERE status = '0'");
$destination = $db->query("SELECT * FROM Destination WHERE status = '0'");
$supplier = $db->query("SELECT * FROM Supplier WHERE status = '0'");
$unit = $db->query("SELECT * FROM Unit WHERE status = '0'");
?>

<head>

    <title>Reports | Synctronix - Weighing System</title>
    <?php include 'layouts/title-meta.php'; ?>

    <!-- jsvectormap css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include jQuery Validate plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <?php include 'layouts/head-css.php'; ?>
    <style>
        .mb-3 {
            margin-bottom: 0.5rem !important;
        }

        .modal-header {
            padding: var(1rem, 1rem) !important;
        }
    </style>
</head>

<?php include 'layouts/body.php'; ?>

<!-- <div class="loading" id="spinnerLoading" style="display:none">
  <div class='mdi mdi-loading' style='transform:scale(0.79);'>
    <div></div>
  </div>
</div> -->

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="h-100">
                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            <!--h4 class="fs-16 mb-1">Good Morning, Anna!</h4>
                                            <p class="text-muted mb-0">Here's what's happening with your store
                                                today.</p-->
                                        </div>
                                        <div class="mt-3 mt-lg-0">
                                            <form action="javascript:void(0);">
                                                <div class="row g-3 mb-0 align-items-center">

                                            </form>
                                        </div>
                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="col-xxl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header fs-5" href="#collapseSearch" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSearch">
                                        <i class="mdi mdi-chevron-down pull-right"></i>
                                        Search Records
                                    </div>
                                    <div id="collapseSearch" class="collapse" aria-labelledby="collapseSearch">                                    
                                        <div class="card-body">
                                            <form action="javascript:void(0);">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="fromDateSearch" class="form-label">From Date</label>
                                                            <input type="date" class="form-control" data-provider="flatpickr" id="fromDateSearch">
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="toDateSearch" class="form-label">To Date</label>
                                                            <input type="date" class="form-control" data-provider="flatpickr" id="toDateSearch">
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="statusSearch" class="form-label">Status</label>
                                                            <select id="statusSearch" class="form-select"  >
                                                                <option selected>-</option>
                                                                <option value="Sales">Sales</option>
                                                                <option value="Purchase">Purchase</option>
                                                                <option value="Local">Local</option>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="customerNoSearch" class="form-label">Customer No</label>
                                                            <select id="customerNoSearch" class="form-select" >
                                                                <option selected>-</option>
                                                                <?php while($rowPF = mysqli_fetch_assoc($customer2)){ ?>
                                                                    <option value="<?=$rowPF['customer_code'] ?>"><?=$rowPF['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="vehicleNo" class="form-label">Vehicle No</label>
                                                            <input type="text" class="form-control" placeholder="Vehicle No" id="vehicleNo">
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="invoiceNoSearch" class="form-label">Weighing Type</label>
                                                            <select id="invoiceNoSearch" class="form-select"  >
                                                                <option selected>-</option>
                                                                <option value="Normal">Normal</option>
                                                                <option value="Container">Container</option>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->                                               
                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="ForminputState" class="form-label">Product</label>
                                                            <select id="transactionStatusSearch" class="form-select" >
                                                                <option selected>-</option>
                                                                <?php while($rowProductF=mysqli_fetch_assoc($product2)){ ?>
                                                                    <option value="<?=$rowProductF['product_code'] ?>"><?=$rowProductF['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="text-end">
                                                            <button type="submit" class="btn btn-primary" id="filterSearch"><i class="bx bx-search-alt"></i> Search</button>
                                                        </div>
                                                    </div><!--end col-->
                                                </div><!--end row-->
                                            </form>                                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-4 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        Sales</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" id="salesInfo">0</span>
                                                    </h4>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-success rounded fs-3">
                                                        <i class="bx bx-dollar-circle text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-4 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        Purchase</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" id="purchaseInfo">0</span></h4>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-info rounded fs-3">
                                                        <i class="bx bx-shopping-bag text-info"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-4 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Local</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" id="localInfo">0</span>
                                                    </h4>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-warning rounded fs-3">
                                                        <i class="bx bx-user-circle text-warning"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </div> <!-- end row-->


                            <div class="row">
                                <div class="col">
                                    <div class="h-100">
                                        <!--datatable--> 
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <h5 class="card-title mb-0">Weighing Records</h5>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="card-body">
                                                        <table id="weightTable" class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Status</th>
                                                                    <th>Weight Status</th>
                                                                    <th>Transaction Id</th>
                                                                    <th>Vehicle No</th>
                                                                    <th>Product Description Detail</th>
                                                                    <th>Incoming(Gross Weight)</th>
                                                                    <th>Incoming(Gross) Date Time</th>
                                                                    <th>Outgoing(Tare) Weight</th>
                                                                    <th>Outgoing(Tare) Date Time</th>
                                                                    <th>ToTal Nett Weight</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end row-->
                                    </div> <!-- end .h-100-->
                                </div> <!-- end col -->
                            </div><!-- container-fluid -->
                    

                        </div> <!-- end .h-100-->

                    </div> <!-- end col -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            </div>

            <?php include 'layouts/footer.php'; ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include 'layouts/customizer.php'; ?>
    <?php include 'layouts/vendor-scripts.php'; ?>
    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>
    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>
    <!-- Dashboard init -->
    <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>   
    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>
    <!-- notifications init -->
    <script src="assets/js/pages/notifications.init.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="assets/js/pages/datatables.init.js"></script>
    <!-- Additional js -->
    <script src="assets/js/additional.js"></script>

    <script type="text/javascript">
    $(function () {
        const today = new Date();
        const tomorrow = new Date(today);
        const yesterday = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        yesterday.setDate(yesterday.getDate() - 1);

        //Date picker
        $('#fromDateSearch').flatpickr({
            dateFormat: "d-m-Y",
            defaultDate: yesterday
        });

        $('#toDateSearch').flatpickr({
            dateFormat: "d-m-Y",
            defaultDate: today
        });

        $('#transactionDate').flatpickr({
            dateFormat: "d-m-Y",
            defaultDate: today
        });

        var fromDateI = $('#fromDateSearch').val();
        var toDateI = $('#toDateSearch').val();
        var statusI = $('#statusSearch').val() ? $('#statusSearch').val() : '';
        var customerNoI = $('#customerNoSearch').val() ? $('#customerNoSearch').val() : '';
        var vehicleNoI = $('#vehicleNo').val() ? $('#vehicleNo').val() : '';
        var invoiceNoI = $('#invoiceNoSearch').val() ? $('#invoiceNoSearch').val() : '';
        var transactionStatusI = $('#transactionStatusSearch').val() ? $('#transactionStatusSearch').val() : '';

        var table = $("#weightTable").DataTable({
            "responsive": true,
            "autoWidth": false,
            'processing': true,
            'serverSide': true,
            'searching': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'php/filterReports.php',
                'data': {
                    fromDate: fromDateI,
                    toDate: toDateI,
                    status: statusI,
                    customer: customerNoI,
                    vehicle: vehicleNoI,
                    invoice: invoiceNoI,
                    product: transactionStatusI,
                } 
            },
            'columns': [
                { data: 'id' },
                { data: 'transaction_status' },
                { data: 'weight_type' },
                { data: 'transaction_id' },
                { data: 'lorry_plate_no1' },
                { data: 'product_description' },
                { data: 'gross_weight1' },
                { data: 'gross_weight1_date' },
                { data: 'tare_weight1' },
                { data: 'tare_weight1_date' },
                { data: 'nett_weight1' },
                { 
                    data: 'id',
                    render: function ( data, type, row ) {
                        // return '<div class="row"><div class="col-3"><button type="button" id="edit'+data+'" onclick="edit('+data+')" class="btn btn-success btn-sm"><i class="fas fa-pen"></i></button></div><div class="col-3"><button type="button" id="deactivate'+data+'" onclick="deactivate('+data+')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div></div>';
                        return '<div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
                        '<i class="ri-more-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end">' +
                        '<li><a class="dropdown-item edit-item-btn" id="edit'+data+'" onclick="edit('+data+')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>' +
                        '<li><a class="dropdown-item print-item-btn" id="print'+data+'" onclick="print('+data+')"><i class="ri-printer-fill align-bottom me-2 text-muted"></i> Print</a></li>' +
                        '<li><a class="dropdown-item remove-item-btn" id="deactivate'+data+'" onclick="deactivate('+data+')"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a></li></ul></div>';
                    }
                }
            ],
            "drawCallback": function(settings) {
                $('#salesInfo').text(settings.json.salesTotal);
                $('#purchaseInfo').text(settings.json.purchaseTotal);
                $('#localInfo').text(settings.json.localTotal);
            }   
        });

        $('#submitWeight').on('click', function(){
            // Check weight
            var trueWeight = 0;
            var variance = $('#productVariance').val() || '';
            var high = $('#productHigh').val() || '';
            var low = $('#productLow').val() || '';
            var final = $('#finalWeight').val() || '0';
            var completed = 'N';
            var pass = true;

            if($('#transactionStatus').val() == "Purchase" || $('#transactionStatus').val() == "Local"){
                trueWeight = parseFloat($('#addModal').find('#supplierWeight').val());
            }
            else{
                trueWeight = parseFloat($('#addModal').find('#orderWeight').val());
            }

            if($('#weightType').val() == 'Normal' && ($('#grossIncoming').val() && $('#tareOutgoing').val())){
                isComplete = 'Y';
            }
            else if($('#weightType').val() == 'Container' && ($('#grossIncoming').val() && $('#tareOutgoing').val() && $('#grossIncoming2').val() && $('#tareOutgoing2').val())){
                isComplete = 'Y';
            }
            else{
                isComplete = 'N';
            }

            if (isComplete == 'Y' && variance != '') {
                final = parseFloat(final);
                low = low != '' ? parseFloat(low) : null;
                high = high != '' ? parseFloat(high) : null;
                
                if (variance == 'W') {
                    if (low !== null && (final < trueWeight - low)) {
                        pass = false;
                    } 
                    else if (high !== null && (final > trueWeight + high)) {
                        pass = false;
                    }
                } 
                else if (variance == 'P') {
                    if (low !== null && (final < trueWeight * (1 - low / 100))) {
                        pass = false;
                    } 
                    else if (high !== null && (final > trueWeight * (1 + high / 100))) {
                        pass = false;
                    }
                }
            }

            if(pass && $('#weightForm').valid()){
                $('#spinnerLoading').show();
                $.post('php/weight.php', $('#weightForm').serialize(), function(data){
                    var obj = JSON.parse(data); 
                    if(obj.status === 'success'){
                        <?php
                            if(isset($_GET['weight'])){
                                echo "window.location = 'weighing.php';";
                            }
                        ?>
                        table.ajax.reload();
                        window.location = 'weighing.php';
                        $('#spinnerLoading').hide();
                        $('#addModal').modal('hide');
                        $("#successBtn").attr('data-toast-text', obj.message);
                        $("#successBtn").click();
                    }
                    else if(obj.status === 'failed'){
                        $('#spinnerLoading').hide();
                        $("#failBtn").attr('data-toast-text', obj.message );
                        $("#failBtn").click();
                    }
                    else{
                        $('#spinnerLoading').hide();
                        $("#failBtn").attr('data-toast-text', 'Failed to save');
                        $("#failBtn").click();
                    }
                });
            }
            else{
                let userChoice = confirm('The final value is out of the acceptable range. Do you want to send for approval (OK) or bypass (Cancel)?');
                if (userChoice) {
                    $('#addModal').find('#status').val("pending");
                    $('#spinnerLoading').show();
                    $.post('php/weight.php', $('#weightForm').serialize(), function(data){
                        var obj = JSON.parse(data); 
                        if(obj.status === 'success'){
                            <?php
                                if(isset($_GET['weight'])){
                                    echo "window.location = 'weighing.php';";
                                }
                            ?>
                            table.ajax.reload();
                            window.location = 'weighing.php';
                            $('#spinnerLoading').hide();
                            $('#addModal').modal('hide');
                            $("#successBtn").attr('data-toast-text', obj.message);
                            $("#successBtn").click();
                        }
                        else if(obj.status === 'failed'){
                            $('#spinnerLoading').hide();
                            $("#failBtn").attr('data-toast-text', obj.message );
                            $("#failBtn").click();
                        }
                        else{
                            $('#spinnerLoading').hide();
                            $("#failBtn").attr('data-toast-text', 'Failed to save');
                            $("#failBtn").click();
                        }
                    });
                } 
                else {
                    $('#bypassModal').find('#passcode').val("");
                    $('#bypassModal').find('#reason').val("");
                    $('#bypassModal').modal('show');
            
                    $('#bypassForm').validate({
                        errorElement: 'span',
                        errorPlacement: function (error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-group').append(error);
                        },
                        highlight: function (element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');
                        }
                    });
                }
            }
        });

        $('#submitBypass').on('click', function(){
            if($('#bypassForm').valid()){
                $('#addModal').find('#bypassReason').val($('#bypassModal').find('#reason').val());
                $('#spinnerLoading').show();
                $.post('php/weight.php', $('#weightForm').serialize(), function(data){
                    var obj = JSON.parse(data); 
                    if(obj.status === 'success'){
                        <?php
                            if(isset($_GET['weight'])){
                                echo "window.location = 'weighing.php';";
                            }
                        ?>
                        table.ajax.reload();
                        window.location = 'weighing.php';
                        $('#spinnerLoading').hide();
                        $('#addModal').modal('hide');
                        $("#successBtn").attr('data-toast-text', obj.message);
                        $("#successBtn").click();
                    }
                    else if(obj.status === 'failed'){
                        $('#spinnerLoading').hide();
                        $("#failBtn").attr('data-toast-text', obj.message );
                        $("#failBtn").click();
                    }
                    else{
                        $('#spinnerLoading').hide();
                        $("#failBtn").attr('data-toast-text', 'Failed to save');
                        $("#failBtn").click();
                    }
                });
            }
        });

        $('#filterSearch').on('click', function(){
            var fromDateI = $('#fromDateSearch').val();
            var toDateI = $('#toDateSearch').val();
            var statusI = $('#statusSearch').val() ? $('#statusSearch').val() : '';
            var customerNoI = $('#customerNoSearch').val() ? $('#customerNoSearch').val() : '';
            var vehicleNoI = $('#vehicleNo').val() ? $('#vehicleNo').val() : '';
            var invoiceNoI = $('#invoiceNoSearch').val() ? $('#invoiceNoSearch').val() : '';
            var transactionStatusI = $('#transactionStatusSearch').val() ? $('#transactionStatusSearch').val() : '';

            //Destroy the old Datatable
            $("#weightTable").DataTable().clear().destroy();

            //Create new Datatable
            table = $("#weightTable").DataTable({
                "responsive": true,
                "autoWidth": false,
                'processing': true,
                'serverSide': true,
                'searching': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'php/filterReports.php',
                    'data': {
                        fromDate: fromDateI,
                        toDate: toDateI,
                        status: statusI,
                        customer: customerNoI,
                        vehicle: vehicleNoI,
                        invoice: invoiceNoI,
                        product: transactionStatusI,
                    } 
                },
                'columns': [
                    { data: 'id' },
                    { data: 'transaction_status' },
                    { data: 'weight_type' },
                    { data: 'transaction_id' },
                    { data: 'lorry_plate_no1' },
                    { data: 'product_description' },
                    { data: 'gross_weight1' },
                    { data: 'gross_weight1_date' },
                    { data: 'tare_weight1' },
                    { data: 'tare_weight1_date' },
                    { data: 'nett_weight1' },
                    { 
                        data: 'id',
                        render: function ( data, type, row ) {
                            // return '<div class="row"><div class="col-3"><button type="button" id="edit'+data+'" onclick="edit('+data+')" class="btn btn-success btn-sm"><i class="fas fa-pen"></i></button></div><div class="col-3"><button type="button" id="deactivate'+data+'" onclick="deactivate('+data+')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div></div>';
                            return '<div class="dropdown d-inline-block"><button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">' +
                            '<i class="ri-more-fill align-middle"></i></button><ul class="dropdown-menu dropdown-menu-end">' +
                            '<li><a class="dropdown-item edit-item-btn" id="edit'+data+'" onclick="edit('+data+')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>' +
                            '<li><a class="dropdown-item print-item-btn" id="print'+data+'" onclick="print('+data+')"><i class="ri-printer-fill align-bottom me-2 text-muted"></i> Print</a></li>' +
                            '<li><a class="dropdown-item remove-item-btn" id="deactivate'+data+'" onclick="deactivate('+data+')"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete </a></li></ul></div>';
                        }
                    }
                ],
                "drawCallback": function(settings) {
                    $('#salesInfo').text(settings.json.salesTotal);
                    $('#purchaseInfo').text(settings.json.purchaseTotal);
                    $('#localInfo').text(settings.json.localTotal);
                }   
            });
        });

        $('#addWeight').on('click', function(){
            $('#addModal').find('#id').val("");
            $('#addModal').find('#transactionId').val("");
            $('#addModal').find('#transactionStatus').val("Sales").trigger('change');
            $('#addModal').find('#weightType').val("Normal").trigger('change');
            $('#addModal').find('#transactionDate').val(formatDate2(today));
            $('#addModal').find('#vehiclePlateNo1').val("");
            $('#addModal').find('#vehiclePlateNo2').val("");
            $('#addModal').find('#supplierWeight').val("");
            $('#addModal').find('#bypassReason').val("");
            $('#addModal').find('#customerCode').val("");
            $('#addModal').find('#customerName').val("");
            $('#addModal').find('#supplierCode').val("");
            $('#addModal').find('#supplierName').val("");
            $('#addModal').find('#productCode').val("");
            $('#addModal').find('#productName').val("");
            $('#addModal').find('#containerNo').val("");
            $('#addModal').find('#invoiceNo').val("");
            $('#addModal').find('#purchaseOrder').val("");
            $('#addModal').find('#deliveryNo').val("");
            $('#addModal').find('#transporterCode').val("");
            $('#addModal').find('#transporter').val("");
            $('#addModal').find('#destinationCode').val("");
            $('#addModal').find('#destination').val("");
            $('#addModal').find('#otherRemarks').val("");
            $('#addModal').find('#grossIncoming').val("");
            $('#addModal').find('#grossIncomingDate').val("");
            $('#addModal').find('#tareOutgoing').val("");
            $('#addModal').find('#tareOutgoingDate').val("");
            $('#addModal').find('#nettWeight').val("");
            $('#addModal').find('#grossIncoming2').val("");
            $('#addModal').find('#status').val("");
            $('#addModal').find('#grossIncomingDate2').val("");
            $('#addModal').find('#tareOutgoing2').val("");
            $('#addModal').find('#tareOutgoingDate2').val("");
            $('#addModal').find('#nettWeight2').val("");
            $('#addModal').find('#reduceWeight').val("");
            // $('#addModal').find('#vehicleNo').val(obj.message.final_weight);
            $('#addModal').find('#weightDifference').val("");
            // $('#addModal').find('#id').val(obj.message.is_complete);
            // $('#addModal').find('#vehicleNo').val(obj.message.is_cancel);
            $('#addModal').find('#manualWeight').val("");
            //$('#addModal').find('#indicatorId').val("");
            $('#addModal').find('#weighbridge').val("");
            //$('#addModal').find('#indicatorId2').val("");
            $('#addModal').find('#productDescription').val("");
            $('#addModal').find('#productHigh').val("");
            $('#addModal').find('#productLow').val("");
            $('#addModal').find('#productVariance').val("");
            $('#addModal').find('#orderWeight').val("0");
            $('#addModal').find('#subTotalPrice').val("0.00");
            $('#addModal').find('#sstPrice').val("0.00");
            $('#addModal').find('#productPrice').val("0.00");
            $('#addModal').find('#totalPrice').val("0.00");
            $('#addModal').find('#finalWeight').val("");
            $('#addModal').modal('show');
            
            $('#weightForm').validate({
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

        $('#weightType').on('change', function(){
            if($(this).val() == "Container")
            {
                $('#containerCard').show();
            }
            else
            {
                $('#containerCard').hide();
            }
        });

        $('#manualVehicle').on('click', function(){
            if($(this).is(':checked')){
                $(this).val(1);
                $('.index-vehicle').hide();
                $('#vehicleNoTxt').show();
            }
            else{
                $(this).val(0);
                $('#vehicleNoTxt').hide();
                $('.index-vehicle').show();
            }
        });

        $('#vehiclePlateNo1').on('change', function(){
            var tare = $('#vehiclePlateNo1 :selected').data('weight') ? parseFloat($('#vehiclePlateNo1 :selected').data('weight')) : 0;
        
            if($('#transactionStatus').val() == "Purchase" || $(this).val() == "Local"){
                $('#grossIncoming').val(parseFloat(tare).toFixed(0));
                $('#grossIncoming').trigger('keyup');
            }
            else{
                $('#tareOutgoing').val(parseFloat(tare).toFixed(0));
                $('#tareOutgoing').trigger('keyup');
            }
        });

        $('#vehiclePlateNo2').on('change', function(){
            var tare = $('#vehiclePlateNo2 :selected').data('weight') ? parseFloat($('#vehiclePlateNo2 :selected').data('weight')) : 0;
        
            if($('#transactionStatus').val() == "Purchase" || $(this).val() == "Local"){
                $('#grossIncoming2').val(parseFloat(tare).toFixed(0));
                $('#grossIncoming2').trigger('keyup');
            }
            else{
                $('#tareOutgoing2').val(parseFloat(tare).toFixed(0));
                $('#tareOutgoing2').trigger('keyup');
            }
        });

        $('#manualVehicle2').on('click', function(){
            if($(this).is(':checked')){
                $(this).val(1);
                $('.index-vehicle2').hide();
                $('#vehicleNoTxt2').show();
            }
            else{
                $(this).val(0);
                $('#vehicleNoTxt2').hide();
                $('.index-vehicle2').show();
            }
        });

        $('.radio-manual-weight').on('click', function(){
            if($('input[name="manualWeight"]:checked').val() == "true"){
                $('#tareOutgoing').removeAttr('readonly');
                $('#grossIncoming').removeAttr('readonly');
                $('#tareOutgoing2').removeAttr('readonly');
                $('#grossIncoming2').removeAttr('readonly');
            }
            else{
                $('#grossIncoming').attr('readonly', 'readonly');
                $('#tareOutgoing').attr('readonly', 'readonly');
                $('#grossIncoming2').attr('readonly', 'readonly');
                $('#tareOutgoing2').attr('readonly', 'readonly');
            }
        });

        $('#grossIncoming').on('keyup', function(){
            var gross = $(this).val() ? parseFloat($(this).val()) : 0;
            var tare = $('#tareOutgoing').val() ? parseFloat($('#tareOutgoing').val()) : 0;
            var nett = Math.abs(gross - tare);
            $('#nettWeight').val(nett.toFixed(0));
            $('#grossIncomingDate').val(formatDate2(today));
            $('#nettWeight').trigger('change');
        });

        $('#grossCapture').on('click', function(){
            var text = $('#indicatorWeight').text();
            $('#grossIncoming').val(parseFloat(text).toFixed(0));
            $('#grossIncoming').trigger('keyup');
        });

        $('#tareOutgoing').on('keyup', function(){
            var tare = $(this).val() ? parseFloat($(this).val()) : 0;
            var gross = $('#grossIncoming').val() ? parseFloat($('#grossIncoming').val()) : 0;
            var nett = Math.abs(gross - tare);
            $('#nettWeight').val(nett.toFixed(0));
            $('#tareOutgoingDate').val(formatDate2(today));
            $('#nettWeight').trigger('change');
        });

        $('#tareCapture').on('click', function(){
            var text = $('#indicatorWeight').text();
            $('#tareOutgoing').val(parseFloat(text).toFixed(0));
            $('#tareOutgoing').trigger('keyup');
        });

        $('#nettWeight').on('change', function(){
            var nett1 = $(this).val() ? parseFloat($(this).val()) : 0;
            var nett2 = $('#nettWeight2').val() ? parseFloat($('#nettWeight2').val()) : 0;
            var current = Math.abs(nett1 - nett2);
            $('#currentWeight').text(current.toFixed(0));
            $('#finalWeight').val(current.toFixed(0));
            $('#currentWeight').trigger('change');
            $('#finalWeight').trigger('change');
        });

        $('#finalWeight').on('change', function(){
            debugger;
            var nett1 = $(this).val() ? parseFloat($(this).val()) : 0;
            var nett2 = 0;

            if($('#transactionStatus').val() == "Purchase" || $('#transactionStatus').val() == "Local"){
                nett2 = parseFloat($('#addModal').find('#supplierWeight').val());
            }
            else{
                nett2 = parseFloat($('#addModal').find('#orderWeight').val());
            }
            
            var current = nett1 - nett2;
            $('#weightDifference').val(current.toFixed(0));
        });

        $('#orderWeight').on('change', function(){
            var nett1 = $('#finalWeight').val() ? parseFloat($('#finalWeight').val()) : 0;
            var nett2 = $(this).val() ? parseFloat($(this).val()) : 0;
            var current = nett1 - nett2;
            $('#weightDifference').val(current.toFixed(0));
        });

        $('#supplierWeight').on('change', function(){
            var nett1 = $('#finalWeight').val() ? parseFloat($('#finalWeight').val()) : 0;
            var nett2 = $(this).val() ? parseFloat($(this).val()) : 0;
            var current = nett1 - nett2;
            $('#weightDifference').val(current.toFixed(0));
        });

        $('#grossIncoming2').on('keyup', function(){
            var gross = $(this).val() ? parseFloat($(this).val()) : 0;
            var tare = $('#tareOutgoing2').val() ? parseFloat($('#tareOutgoing2').val()) : 0;
            var nett = Math.abs(gross - tare);
            $('#nettWeight2').val(nett.toFixed(0));
            $('#grossIncomingDate2').val(formatDate2(today));
            $('#nettWeight2').trigger('change');
        });

        $('#grossCapture2').on('click', function(){
            var text = $('#indicatorWeight').text();
            $('#grossIncoming2').val(parseFloat(text).toFixed(0));
            $('#grossIncoming2').trigger('keyup');
        });

        $('#tareOutgoing2').on('keyup', function(){
            var tare = $(this).val() ? parseFloat($(this).val()) : 0;
            var gross = $('#grossIncoming2').val() ? parseFloat($('#grossIncoming2').val()) : 0;
            var nett = Math.abs(gross - tare);
            $('#nettWeight2').val(nett.toFixed(0));
            $('#tareOutgoingDate2').val(formatDate2(today));
            $('#nettWeight2').trigger('change');
        });

        $('#tareCapture2').on('click', function(){
            var text = $('#indicatorWeight').text();
            $('#tareOutgoing2').val(parseFloat(text).toFixed(0));
            $('#tareOutgoing2').trigger('keyup');
        });

        $('#nettWeight2').on('change', function(){
            var nett2 = $(this).val() ? parseFloat($(this).val()) : 0;
            var nett1 = $('#nettWeight').val() ? parseFloat($('#nettWeight').val()) : 0;
            var current = Math.abs(nett1 - nett2);
            $('#currentWeight').text(current.toFixed(0));
            $('#finalWeight').val(current.toFixed(0));
            $('#currentWeight').trigger('change');
            $('#finalWeight').trigger('change');
        });

        $('#currentWeight').on('change', function(){
            var price = $('#productPrice').val() ? parseFloat($('#productPrice').val()).toFixed(2) : 0.00;
            var weight = $('#currentWeight').text() ? parseFloat($('#currentWeight').text()) : 0;
            var subTotalPrice = price * weight;
            var sstPrice = subTotalPrice * 0.06;
            var totalPrice = subTotalPrice + sstPrice;
            $('#subTotalPrice').val(subTotalPrice.toFixed(2));
            $('#sstPrice').val(sstPrice.toFixed(2));
            $('#totalPrice').val(totalPrice.toFixed(2));
        });

        $('#transactionStatus').on('change', function(){
            if($(this).val() == "Purchase" || $(this).val() == "Local")
            {
                $('#divWeightDifference').show();
                $('#divSupplierWeight').show();
                $('#addModal').find('#orderWeight').val("");
                $('#addModal').find('#supplierWeight').val("0");
                $('#divSupplierName').show();
                $('#divOrderWeight').hide();
                $('#divCustomerName').hide();
            }
            else{
                $('#divOrderWeight').show();
                $('#addModal').find('#orderWeight').val("0");
                $('#addModal').find('#supplierWeight').val("");
                $('#divWeightDifference').show();
                $('#divSupplierWeight').hide();
                $('#divSupplierName').hide();
                $('#divCustomerName').show();
            }
        });

        //productName
        $('#productName').on('change', function(){
            $('#productCode').val($('#productName :selected').data('code'));
            $('#productDescription').val($('#productName :selected').data('description'));
            $('#productPrice').val($('#productName :selected').data('price'));
            $('#productHigh').val($('#productName :selected').data('high'));
            $('#productLow').val($('#productName :selected').data('low'));
            $('#productVariance').val($('#productName :selected').data('variance'));

            var price = $('#productPrice').val() ? parseFloat($('#productPrice').val()).toFixed(2) : 0.00;
            var weight = $('#currentWeight').text() ? parseFloat($('#currentWeight').text()) : 0;
            var subTotalPrice = price * weight;
            var sstPrice = subTotalPrice * 0.06;
            var totalPrice = subTotalPrice + sstPrice;
            $('#subTotalPrice').val(subTotalPrice.toFixed(2));
            $('#sstPrice').val(sstPrice.toFixed(2));
            $('#totalPrice').val(totalPrice.toFixed(2));
        });

        //supplierName
        $('#supplierName').on('change', function(){
            $('#supplierCode').val($('#supplierName :selected').data('code'));
        });

        //transporter
        $('#transporter').on('change', function(){
            $('#transporterCode').val($('#transporter :selected').data('code'));
        });

        //destination
        $('#destination').on('change', function(){
            $('#destinationCode').val($('#destination :selected').data('code'));
        });

        //customerName
        $('#customerName').on('change', function(){
            $('#customerCode').val($('#customerName :selected').data('code'));
        });

        <?php
            if(isset($_GET['weight'])){
                echo 'edit('.$_GET['weight'].');';
            }
        ?>
    });

    function edit(id){
        $('#spinnerLoading').show();
        $.post('php/getWeight.php', {userID: id}, function(data)
        {
            var obj = JSON.parse(data);
            if(obj.status === 'success'){
                $('#addModal').find('#id').val(obj.message.id);
                $('#addModal').find('#transactionId').val(obj.message.transaction_id);
                $('#addModal').find('#transactionStatus').val(obj.message.transaction_status);
                $('#addModal').find('#weightType').val(obj.message.weight_type);
                $('#addModal').find('#transactionDate').val(formatDate2(new Date(obj.message.transaction_date)));
                $('#addModal').find('#vehiclePlateNo1').val(obj.message.lorry_plate_no1);

                if(obj.message.vehicleNoTxt != null)
                {
                    $('#addModal').find('#vehicleNoTxt').val(obj.message.vehicleNoTxt);
                }

                $('#addModal').find('#vehiclePlateNo2').val(obj.message.lorry_plate_no2);
                $('#addModal').find('#supplierWeight').val(obj.message.supplier_weight);
                $('#addModal').find('#customerCode').val(obj.message.customer_code);
                $('#addModal').find('#customerName').val(obj.message.customer_name);
                $('#addModal').find('#supplierCode').val(obj.message.supplier_code);
                $('#addModal').find('#supplierName').val(obj.message.supplier_name);
                $('#addModal').find('#productCode').val(obj.message.product_code);
                $('#addModal').find('#containerNo').val(obj.message.container_no);
                $('#addModal').find('#invoiceNo').val(obj.message.invoice_no);
                $('#addModal').find('#purchaseOrder').val(obj.message.purchase_order);
                $('#addModal').find('#deliveryNo').val(obj.message.delivery_no);
                $('#addModal').find('#transporterCode').val(obj.message.transporter_code);
                $('#addModal').find('#transporter').val(obj.message.transporter);
                $('#addModal').find('#destinationCode').val(obj.message.destination_code);
                $('#addModal').find('#destination').val(obj.message.destination);
                $('#addModal').find('#otherRemarks').val(obj.message.remarks);
                $('#addModal').find('#grossIncoming').val(obj.message.gross_weight1);
                $('#addModal').find('#grossIncomingDate').val(formatDate2(new Date(obj.message.gross_weight1_date)));
                $('#addModal').find('#tareOutgoing').val(obj.message.tare_weight1);
                $('#addModal').find('#tareOutgoingDate').val(obj.message.tare_weight1_date != null ? formatDate2(new Date(obj.message.tare_weight1_date)) : '');
                $('#addModal').find('#nettWeight').val(obj.message.nett_weight1);
                $('#addModal').find('#grossIncoming2').val(obj.message.gross_weight2);
                $('#addModal').find('#grossIncomingDate2').val(obj.message.gross_weight2_date != null ? formatDate2(new Date(obj.message.gross_weight2_date)) : '');
                $('#addModal').find('#tareOutgoing2').val(obj.message.tare_weight2);
                $('#addModal').find('#tareOutgoingDate2').val(obj.message.tare_weight2_date != null ? formatDate2(new Date(obj.message.tare_weight2_date)) : '');
                $('#addModal').find('#nettWeight2').val(obj.message.nett_weight2);
                $('#addModal').find('#reduceWeight').val(obj.message.reduce_weight);
                // $('#addModal').find('#vehicleNo').val(obj.message.final_weight);
                $('#addModal').find('#weightDifference').val(obj.message.weight_different);
                // $('#addModal').find('#id').val(obj.message.is_complete);
                // $('#addModal').find('#vehicleNo').val(obj.message.is_cancel);
                //$('#addModal').find('#manualWeight').val(obj.message.manual_weight);
                if(obj.message.manual_weight == 'true'){
                    $("#manualWeightYes").prop("checked", true);
                    $("#manualWeightNo").prop("checked", false);
                }
                else{
                    $("#manualWeightYes").prop("checked", false);
                    $("#manualWeightNo").prop("checked", true);
                }

                $('#addModal').find('#indicatorId').val(obj.message.indicator_id);
                $('#addModal').find('#weighbridge').val(obj.message.weighbridge_id);
                $('#addModal').find('#indicatorId2').val(obj.message.indicator_id_2);
                $('#addModal').find('#productName').val(obj.message.product_name).trigger('change');
                $('#addModal').find('#productDescription').val(obj.message.product_description);
                $('#addModal').find('#subTotalPrice').val(obj.message.product_description);
                $('#addModal').find('#sstPrice').val(obj.message.product_description);
                $('#addModal').find('#totalPrice').val(obj.message.total_price);
                $('#addModal').find('#finalWeight').val(obj.message.final_weight);
                $('#addModal').modal('show');
            
                $('#weightForm').validate({
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            }
            else if(obj.status === 'failed'){
                $('#spinnerLoading').hide();
                $("#failBtn").attr('data-toast-text', obj.message );
                $("#failBtn").click();
            }
            else{
                $('#spinnerLoading').hide();
                $("#failBtn").attr('data-toast-text', obj.message );
                $("#failBtn").click();
            }
            $('#spinnerLoading').hide();
        });
    }

    function deactivate(id){
        $('#spinnerLoading').show();
        $.post('php/deleteWeight.php', {userID: id}, function(data){
            var obj = JSON.parse(data);
            
            if(obj.status === 'success'){
                table.ajax.reload();
                $('#spinnerLoading').hide();
                $("#successBtn").attr('data-toast-text', obj.message);
                $("#successBtn").click();
            }
            else if(obj.status === 'failed'){
                $('#spinnerLoading').hide();
                $("#failBtn").attr('data-toast-text', obj.message );
                $("#failBtn").click();
            }
            else{
                $('#spinnerLoading').hide();
                $("#failBtn").attr('data-toast-text', obj.message );
                $("#failBtn").click();
            }
        });
    }
    </script>
</body>
</html>