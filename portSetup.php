<?php include 'layouts/session.php'; ?>
<?php include 'layouts/head-main.php'; ?>
<?php
require_once 'php/db_connect.php';

$id = $_SESSION['userID'];
$stmt = $db->prepare("SELECT * from Port");
//$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$port = '';
$baudrate = '';
$databits = '';
$parity = '';
$stopbits = '';

if(($row = $result->fetch_assoc()) !== null){
    $port = $row['com_port'];
    $baudrate = $row['bits_per_second'];
    $databits = $row['data_bits'];
    $parity = $row['parity'];
    $stopbits = $row['stop_bits'];
}
?>

    <head>
        
        <title>Port Setup | Synctronix - Weighing System</title>
        <?php include 'layouts/title-meta.php'; ?>

        <!-- swiper css -->
        <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css">

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
                        <div class="row col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <form action="php/changepassword.php" method="post">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Serial Port</label>
                                                    <select class="form-control" style="width: 100%;" id="serialPort" name="serialPort" required></select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Baud Rate</label>
                                                    <select class="form-control" style="width: 100%;" id="serialPortBaudRate" name="serialPortBaudRate" required>
                                                        <option value="110" <?=$baudrate == '110' ? 'selected="selected"' : '';?>>110</option>
                                                        <option value="300" <?=$baudrate == '300' ? ' selected="selected"' : '';?>>300</option>
                                                        <option value="600" <?=$baudrate == '600' ? ' selected="selected"' : '';?>>600</option>
                                                        <option value="1200" <?=$baudrate == '1200' ? ' selected="selected"' : '';?>>1200</option>
                                                        <option value="2400" <?=$baudrate == '2400' ? ' selected="selected"' : '';?>>2400</option>
                                                        <option value="4800" <?=$baudrate == '4800' ? ' selected="selected"' : '';?>>4800</option>
                                                        <option value="9600" <?=$baudrate == '9600' ? ' selected="selected"' : '';?>>9600</option>
                                                        <option value="14400" <?=$baudrate == '14400' ? ' selected="selected"' : '';?>>14400</option>
                                                        <option value="19200" <?=$baudrate == '19200' ? ' selected="selected"' : '';?>>19200</option>
                                                        <option value="38400" <?=$baudrate == '38400' ? ' selected="selected"' : '';?>>38400</option>
                                                        <option value="57600" <?=$baudrate == '57600' ? ' selected="selected"' : '';?>>57600</option>
                                                        <option value="115200" <?=$baudrate == '115200' ? ' selected="selected"' : '';?>>115200</option>
                                                        <option value="128000" <?=$baudrate == '128000' ? ' selected="selected"' : '';?>>128000</option>
                                                        <option value="256000" <?=$baudrate == '256000' ? ' selected="selected"' : '';?>>256000</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Data Bits</label>
                                                    <select class="form-control" style="width: 100%;" id="serialPortDataBits" name="serialPortDataBits" required>
                                                        <option value="8" <?=$databits == '8' ? 'selected="selected"' : '';?>>8</option>
                                                        <option value="7" <?=$databits == '7' ? 'selected="selected"' : '';?>>7</option>
                                                        <option value="6" <?=$databits == '6' ? 'selected="selected"' : '';?>>6</option>
                                                        <option value="5" <?=$databits == '5' ? 'selected="selected"' : '';?>>5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Parity</label>
                                                    <select class="form-control" style="width: 100%;" id="serialPortParity" name="serialPortParity" required>
                                                        <option value="N" <?=$parity == 'N' ? 'selected="selected"' : '';?>>None</option>
                                                        <option value="O" <?=$parity == 'O' ? 'selected="selected"' : '';?>>Odd</option>
                                                        <option value="E" <?=$parity == 'E' ? 'selected="selected"' : '';?>>Even</option>
                                                        <option value="M" <?=$parity == 'M' ? 'selected="selected"' : '';?>>Mark</option>
                                                        <option value="S" <?=$parity == 'S' ? 'selected="selected"' : '';?>>Space</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Stop bits</label>
                                                    <select class="form-control" style="width: 100%;" id="serialPortStopBits" name="serialPortStopBits" required>
                                                        <option value="1" <?=$stopbits == '1' ? 'selected="selected"' : '';?>>1</option>
                                                        <option value="1.5" <?=$stopbits == '1.5' ? 'selected="selected"' : '';?>>1.5</option>
                                                        <option value="2" <?=$stopbits == '2' ? 'selected="selected"' : '';?>>2</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- container-fluid -->
                </div><!-- End Page-content -->

                <?php include 'layouts/footer.php'; ?>
            </div><!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        

        <?php include 'layouts/customizer.php'; ?>

        <?php include 'layouts/vendor-scripts.php'; ?>

        <!-- swiper js -->
        <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

        <!-- profile init js -->
        <script src="assets/js/pages/profile.init.js"></script>
        
        <!-- App js -->
        <script src="assets/js/app.js"></script>
    </body>
</html>