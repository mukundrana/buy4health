<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo isset($title) ? $title : 'BUY4HEALTH'; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/dist/css/AdminLTE.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body onload="window.print();">
        <div class="wrapper">
            <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Rent4Health
                            <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
                        </h2>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>Rent4Health</strong><br>
                            F 2&3, Ground Floor<br>
                            Guru Tej Bahadur CHS<br>
                            Aundh Road, Pune <br>
                            Phone : +91-88 22 256 256 ,
                            <br> +91-99 21 755 196<br>
                            Email : info@rent4health.com
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></strong><br>
                            <?php echo $user['address1']; ?>,<br>
                            <?php echo $user['zipcode']; ?><br>
                            <?php echo $user['city'] . ' , ' . $user['state']; ?><br>
                            Phone : <?php echo $user['phone'] . ' , ' . $user['mobile']; ?><br>
                            Email: <?php echo $user['email']; ?>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                        <b>Order ID : </b> <?php echo $user['order_number']; ?><br>
                        <b>Payment Due : </b> <?php echo $user['order_date']; ?><br>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Product Name</th>
                                    <th>Type (Buy & Rent)</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($table)) {
                                    $no = 0;
                                    foreach ($table as $row) {
                                        if (isset($row['type']) && $row['type'] == 'r') {
                                            $type = 'Rent';
                                        } else if (isset($row['type']) && $row['type'] == 's') {
                                            $type = 'Sell';
                                        } else {
                                            $type = '';
                                        }
                                        $no++;
                                        ?><tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['product_name']; ?></td>
                                            <td><?php echo $type; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td><?php echo '&#8377; ' . $row['price']; ?></td>
                                            <td><?php echo '&#8377; ' . $row['total_price']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6">
<!--                        <p class="lead">Payment Methods:</p>
                        <img src="<?php echo base_url(); ?>/assets/dist/img/credit/visa.png" alt="Visa">
                        <img src="<?php echo base_url(); ?>/assets/dist/img/credit/mastercard.png" alt="Mastercard">
                        <img src="<?php echo base_url(); ?>/assets/dist/img/credit/american-express.png" alt="American Express">
                        <img src="<?php echo base_url(); ?>/assets/dist/img/credit/paypal2.png" alt="Paypal">

                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
                            jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>-->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">
                        <p class="lead">Amount Due <?php echo $user['order_date']; ?></p>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Subtotal:</th>
                                    <td><?php
                                        $total = isset($user['total']) && ($user['total'] != '') ? $user['total'] : "0";
                                        echo '&#8377; ' . $total;
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td><?php
                                        $shipping_rate = isset($user['shipping_rate']) && ($user['shipping_rate'] != '') ? $user['shipping_rate'] : "0";
                                        echo '&#8377; ' . $shipping_rate;
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Delivery Charge:</th>
                                    <td><?php
                                        $order_delivery_charge = isset($user['order_delivery_charge']) && ($user['order_delivery_charge'] != '') ? $user['order_delivery_charge'] : "0";
                                        echo '&#8377; ' . $order_delivery_charge;
                                        ?></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td><?php
                                        $total = (int) $user['total'] + (int) $user['shipping_rate'] + (int) $user['order_delivery_charge'];
                                        echo '&#8377; ' . $total;
                                        ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
    </body>
</html>