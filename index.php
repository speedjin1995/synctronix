<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>

<head>

    <title>Weighing | Synctronix - Weighing System</title>
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

    <?php include 'layouts/head-css.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>

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
                                                    <!-- <div class="col-sm-auto">
                                                        <div class="input-group">
                                                            <input type="text"
                                                                class="form-control border-0 dash-filter-picker shadow"
                                                                data-provider="flatpickr" data-range-date="true"
                                                                data-date-format="d M, Y"
                                                                data-deafult-date="01 Jan 2023 to 31 Jan 2023">
                                                            <div
                                                                class="input-group-text bg-primary border-primary text-white">
                                                                <i class="ri-calendar-2-line"></i>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <!--end col-->
                                                    <!--div class="col-auto">
                                                        <button type="button" class="btn btn-soft-success"><i
                                                                class="ri-add-circle-line align-middle me-1"></i>
                                                            Add Product</button>
                                                    </div>
                                                    <!--end col-->
                                                    <!--div class="col-auto">
                                                        <button type="button"
                                                            class="btn btn-soft-info btn-icon waves-effect waves-light layout-rightside-btn"><i
                                                                class="ri-pulse-line"></i></button>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                    </div><!-- end card header -->
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
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
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span
                                                            class="counter-value" data-target="559.25">0</span>k
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

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        Purchase</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-danger fs-14 mb-0">
                                                        <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                        -3.57 %
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" data-target="36894">0</span></h4>
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

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                    Miscellaneous</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-success fs-14 mb-0">
                                                        <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                        +29.08 %
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" data-target="183.35">0</span>M
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
                                <div class="col-xl-3 col-md-6 add-new-weight">
                                    <button type="button" class="btn btn-lg btn-soft-success" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable"><i
                                            class="ri-add-circle-line align-middle me-1"></i>
                                        Add New Weight</button>

                                    <!-- /.modal-dialog -->
                                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add New Entry</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="javascript:void(0);">
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <div class="col-xl-5 col-md-6 col-md-6">
                                                                    <div class="card bg-primary">
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>
                                                                                    <h2 class="mt-4 ff-secondary fw-semibold display-3 text-white"><span class="counter-value"
                                                                                            data-target="0">0</span> Kg</h2>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="avatar-sm flex-shrink-0">
                                                                                        <span class="avatar-title bg-soft-light rounded-circle fs-2">
                                                                                            <i class="mdi mdi-weight-kilogram"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div><!-- end card body -->
                                                                    </div> <!-- end card-->
                                                                </div> <!-- end col-->
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                                <div class="card bg-light">
                                                                    <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="transactionId" class="col-sm-4 col-form-label">Transaction ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="transactionId" placeholder="Transaction ID">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="transactionDate" class="col-sm-4 col-form-label">Transaction Date</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="date" class="form-control" data-provider="flatpickr" id="transactionDate">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="invoiceNo" class="col-sm-4 col-form-label">Invoice No</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="invoiceNo" placeholder="Invoice No">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="weightType" class="col-sm-4 col-form-label">Weight Type</label>
                                                                                <div class="col-sm-8">
                                                                                    <select id="weightType" class="form-select" data-choices data-choices-sorting="true" >
                                                                                        <option selected>Normal</option>
                                                                                        <option>Container</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="deliveryNo" class="col-sm-4 col-form-label">Delivery No</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="deliveryNo" placeholder="Delivery No">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="transactionStatus" class="col-sm-4 col-form-label">Transaction Status</label>
                                                                                <div class="col-sm-8">
                                                                                    <select id="transactionStatus" class="form-select" data-choices data-choices-sorting="true" >
                                                                                        <option selected>Sales</option>
                                                                                        <option>Purchase</option>
                                                                                        <option>Local</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="purchaseOrder" class="col-sm-4 col-form-label">Purchase Order</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="purchaseOrder" placeholder="Purchase Order">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="weighbridge" class="col-sm-4 col-form-label">Weighbridge</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="weighbridge" placeholder="Weigh1" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="containerNo" class="col-sm-4 col-form-label">Container No</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="containerNo" placeholder="Container No">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="indicatorId" class="col-sm-4 col-form-label">Indicator ID</label>
                                                                                <div class="col-sm-8">
                                                                                    <select id="transactionStatus" class="form-select" data-choices data-choices-sorting="true" >
                                                                                        <option selected>ind12345</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="customerName" class="col-sm-4 col-form-label">Customer Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="customerName" placeholder="Customer Name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="manualWeight" class="col-sm-4 col-form-label">Manual Weight</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="manualWeight" placeholder="No" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="productName" class="col-sm-4 col-form-label">Product Name</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="productName" placeholder="Product Name">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="transporter" class="col-sm-4 col-form-label">Transporter</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="transporter" placeholder="col-form-label-sm">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="destination" class="col-sm-4 col-form-label">Destination</label>
                                                                                <div class="col-sm-8">
                                                                                    <input type="email" class="form-control" id="destination" placeholder="Destination">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xxl-6 col-lg-6 mb-3">
                                                                            <div class="row">
                                                                                <label for="reduceWeight" class="col-sm-4 col-form-label">Reduce Weight</label>
                                                                                <div class="col-sm-8">
                                                                                    <div class="input-group">
                                                                                        <input type="email" class="form-control" id="reduceWeight" placeholder="0">
                                                                                        <div class="input-group-text">Kg</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xxl-12 col-lg-12 mb-3">
                                                                            <div class="row">
                                                                                <label for="otherRemarks" class="col-sm-2 col-form-label">Other Remarks</label>
                                                                                <div class="col-sm-10">
                                                                                    <textarea class="form-control" id="otherRemarks" rows="3" placeholder="Other Remarks"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xxl-6 col-lg-6 ">
                                                                <div class="card bg-light">
                                                                    <div class="card-body">
                                                                        <div class="row mb-3">
                                                                            <label for="vehiclePlateNo1" class="col-sm-4 col-form-label">Vehicle Plate No 1</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="email" class="form-control" id="vehiclePlateNo1" placeholder="Vehicle Plate No 1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="grossIncoming" class="col-sm-4 col-form-label">1.Gross Incoming</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <input type="email" class="form-control" id="grossIncoming" placeholder="0">
                                                                                    <div class="input-group-text">Kg</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="grossIncomingDate" class="col-sm-4 col-form-label">Gross Incoming Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" class="form-control" data-provider="flatpickr" id="grossIncomingDate">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="tareOutgoing" class="col-sm-4 col-form-label">2.Tare Outgoing</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="email" class="form-control" id="tareOutgoing" placeholder="Tare Outgoing">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="tareOutgoingDate" class="col-sm-4 col-form-label">Tare Outgoing Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" class="form-control" data-provider="flatpickr" id="tareOutgoingDate">
                                                                            </div>
                                                                        </div>                                                                        
                                                                        <div class="row mb-3">
                                                                            <label for="nettWeight" class="col-sm-4 col-form-label">Nett Weight</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <input type="email" class="form-control" id="nettWeight" placeholder="0">
                                                                                    <div class="input-group-text">Kg</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-grid" >
                                                                            <button class="btn btn-primary" type="button">Button</button>
                                                                        </div>
                                                                    </div>                                                                                                                                  
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-6 col-lg-6 ">
                                                                <div class="card bg-light">
                                                                    <div class="card-body">
                                                                        <div class="row mb-3">
                                                                            <label for="vehiclePlateNo2" class="col-sm-4 col-form-label">Vehicle Plate No 2</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="email" class="form-control" id="vehiclePlateNo1" placeholder="Vehicle Plate No 1">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="grossIncoming2" class="col-sm-4 col-form-label">3.Gross Incoming</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <input type="email" class="form-control" id="grossIncoming2" placeholder="0">
                                                                                    <div class="input-group-text">Kg</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="grossIncomingDate2" class="col-sm-4 col-form-label">Gross Incoming Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" class="form-control" data-provider="flatpickr" id="grossIncomingDate2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="tareOutgoing2" class="col-sm-4 col-form-label">4.Tare Outgoing</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="email" class="form-control" id="tareOutgoing" placeholder="Tare Outgoing2">
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mb-3">
                                                                            <label for="tareOutgoingDate2" class="col-sm-4 col-form-label">Tare Outgoing Date</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="date" class="form-control" data-provider="flatpickr" id="tareOutgoingDate2">
                                                                            </div>
                                                                        </div>                                                                        
                                                                        <div class="row mb-3">
                                                                            <label for="nettWeight2" class="col-sm-4 col-form-label">Nett Weight</label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <input type="email" class="form-control" id="nettWeight2" placeholder="0">
                                                                                    <div class="input-group-text">Kg</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-grid">
                                                                            <button class="btn btn-primary" type="button">Button</button>
                                                                        </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div><!--end col-->                                                               
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                </div>
                            </div> <!-- end row-->


                            <!--datatable--> 
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Previous Records</h5>
                                        </div>
                                        <div class="card-body">
                                            <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>SR No.</th>
                                                        <th>ID</th>
                                                        <th>Purchase ID</th>
                                                        <th>Title</th>
                                                        <th>User</th>
                                                        <th>Assigned To</th>
                                                        <th>Created By</th>
                                                        <th>Create Date</th>
                                                        <th>Status</th>
                                                        <th>Priority</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>01</td>
                                                        <td>VLZ-452</td>
                                                        <td>VLZ1400087402</td>
                                                        <td><a href="#!">Post launch reminder/ post list</a></td>
                                                        <td>Joseph Parker</td>
                                                        <td>Alexis Clarke</td>
                                                        <td>Joseph Parker</td>
                                                        <td>03 Oct, 2021</td>
                                                        <td><span class="badge badge-soft-info">Re-open</span></td>
                                                        <td><span class="badge bg-danger">High</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>02</td>
                                                        <td>VLZ-453</td>
                                                        <td>VLZ1400087425</td>
                                                        <td><a href="#!">Additional Calendar</a></td>
                                                        <td>Diana Kohler</td>
                                                        <td>Admin</td>
                                                        <td>Mary Rucker</td>
                                                        <td>05 Oct, 2021</td>
                                                        <td><span class="badge badge-soft-secondary">On-Hold</span></td>
                                                        <td><span class="badge bg-info">Medium</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>03</td>
                                                        <td>VLZ-454</td>
                                                        <td>VLZ1400087438</td>
                                                        <td><a href="#!">Make a creating an account profile</a></td>
                                                        <td>Tonya Noble</td>
                                                        <td>Admin</td>
                                                        <td>Tonya Noble</td>
                                                        <td>27 April, 2022</td>
                                                        <td><span class="badge badge-soft-danger">Closed</span></td>
                                                        <td><span class="badge bg-success">Low</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>04</td>
                                                        <td>VLZ-455</td>
                                                        <td>VLZ1400087748</td>
                                                        <td><a href="#!">Apologize for shopping Error!</a></td>
                                                        <td>Joseph Parker</td>
                                                        <td>Alexis Clarke</td>
                                                        <td>Joseph Parker</td>
                                                        <td>14 June, 2021</td>
                                                        <td><span class="badge badge-soft-warning">Inprogress</span></td>
                                                        <td><span class="badge bg-info">Medium</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>05</td>
                                                        <td>VLZ-456</td>
                                                        <td>VLZ1400087547</td>
                                                        <td><a href="#!">Support for theme</a></td>
                                                        <td>Donald Palmer</td>
                                                        <td>Admin</td>
                                                        <td>Donald Palmer</td>
                                                        <td>25 June, 2021</td>
                                                        <td><span class="badge badge-soft-danger">Closed</span></td>
                                                        <td><span class="badge bg-success">Low</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>06</td>
                                                        <td>VLZ-457</td>
                                                        <td>VLZ1400087245</td>
                                                        <td><a href="#!">Benner design for FB & Twitter</a></td>
                                                        <td>Mary Rucker</td>
                                                        <td>Jennifer Carter</td>
                                                        <td>Mary Rucker</td>
                                                        <td>14 Aug, 2021</td>
                                                        <td><span class="badge badge-soft-warning">Inprogress</span></td>
                                                        <td><span class="badge bg-info">Medium</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>07</td>
                                                        <td>VLZ-458</td>
                                                        <td>VLZ1400087785</td>
                                                        <td><a href="#!">Change email option process</a></td>
                                                        <td>James Morris</td>
                                                        <td>Admin</td>
                                                        <td>James Morris</td>
                                                        <td>12 March, 2022</td>
                                                        <td><span class="badge badge-soft-primary">Open</span></td>
                                                        <td><span class="badge bg-danger">High</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>08</td>
                                                        <td>VLZ-460</td>
                                                        <td>VLZ1400087745</td>
                                                        <td><a href="#!">Support for theme</a></td>
                                                        <td>Nathan Cole</td>
                                                        <td>Nancy Martino</td>
                                                        <td>Nathan Cole</td>
                                                        <td>28 Feb, 2022</td>
                                                        <td><span class="badge badge-soft-secondary">On-Hold</span></td>
                                                        <td><span class="badge bg-success">Low</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>09</td>
                                                        <td>VLZ-461</td>
                                                        <td>VLZ1400087179</td>
                                                        <td><a href="#!">Form submit issue</a></td>
                                                        <td>Grace Coles</td>
                                                        <td>Admin</td>
                                                        <td>Grace Coles</td>
                                                        <td>07 Jan, 2022</td>
                                                        <td><span class="badge badge-soft-success">New</span></td>
                                                        <td><span class="badge bg-danger">High</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>VLZ-462</td>
                                                        <td>VLZ140008856</td>
                                                        <td><a href="#!">Edit customer testimonial</a></td>
                                                        <td>Freda</td>
                                                        <td>Alexis Clarke</td>
                                                        <td>Freda</td>
                                                        <td>16 Aug, 2021</td>
                                                        <td><span class="badge badge-soft-danger">Closed</span></td>
                                                        <td><span class="badge bg-info">Medium</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>11</td>
                                                        <td>VLZ-463</td>
                                                        <td>VLZ1400078031</td>
                                                        <td><a href="#!">Ca i have an e-copy invoice</a></td>
                                                        <td>Williams</td>
                                                        <td>Admin</td>
                                                        <td>Williams</td>
                                                        <td>24 Feb, 2022</td>
                                                        <td><span class="badge badge-soft-primary">Open</span></td>
                                                        <td><span class="badge bg-success">Low</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>12</td>
                                                        <td>VLZ-464</td>
                                                        <td>VLZ1400087416</td>
                                                        <td><a href="#!">Brand logo design</a></td>
                                                        <td>Richard V.</td>
                                                        <td>Admin</td>
                                                        <td>Richard V.</td>
                                                        <td>16 March, 2021</td>
                                                        <td><span class="badge badge-soft-warning">Inprogress</span></td>
                                                        <td><span class="badge bg-danger">High</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>13</td>
                                                        <td>VLZ-466</td>
                                                        <td>VLZ1400089015</td>
                                                        <td><a href="#!">Issue with finding information about order ?</a></td>
                                                        <td>Olive Gunther</td>
                                                        <td>Alexis Clarke</td>
                                                        <td>Schaefer</td>
                                                        <td>32 March, 2022</td>
                                                        <td><span class="badge badge-soft-success">New</span></td>
                                                        <td><span class="badge bg-danger">High</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>14</td>
                                                        <td>VLZ-467</td>
                                                        <td>VLZ1400090324</td>
                                                        <td><a href="#!">Make a creating an account profile</a></td>
                                                        <td>Edwin</td>
                                                        <td>Admin</td>
                                                        <td>Edwin</td>
                                                        <td>05 April, 2022</td>
                                                        <td><span class="badge badge-soft-warning">Inprogress</span></td>
                                                        <td><span class="badge bg-success">Low</span></td>
                                                        <td>
                                                            <div class="dropdown d-inline-block">
                                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-fill align-middle"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a></li>
                                                                    <li><a class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                                    <li>
                                                                        <a class="dropdown-item remove-item-btn">
                                                                            <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end row-->
                    

                        </div> <!-- end .h-100-->

                    </div> <!-- end col -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="assets/js/pages/datatables.init.js"></script>

    </body>

    </html>