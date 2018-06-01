<?php
include("class.all_registrations.php");

$objReg = new all_registrations();
$data = $objReg->getAllRegistrants();
?>


<!-- Header -->
<?php include("include/header.php"); ?>
<!-- /#Header -->

<!-- Left Panel -->
<?php include("include/left_panel.php"); ?>
<!-- /#left-panel -->

<!-- Right Panel -->

<div id="right-panel" class="right-panel">

    <!-- Header-->
    <?php include("include/sub_header.php"); ?>
    <!-- /header -->
    <!-- Header-->

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="#">NSS Registrations - ALL</a></li>
                        <li><a href="#">All Registrations</a></li>
                        <li class="active">Data table</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Data Table</strong>
                        </div>
                        <div class="card-body">
                            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <!--                                        submission_id
                                                                                email
                                                                                phone
                                                                                age
                                                                                gender
                                                                                tshirt_size
                                                                                additional_guests
                                                                                travel_arrangements
                                                                                same_guest_itinerary
                                                                                arrival_time
                                                                                arrival_date_member
                                                                                arrival_time_member
                                                                                arrival_flight
                                                                                arrival_flight_number
                                                                                arrival_airport
                                                                                require_transportation_from
                                                                                departure_time
                                                                                departure_date_member
                                                                                departure_time_member
                                                                                departure_flight
                                                                                departure_flight_number
                                                                                departure_airport
                                                                                require_transportation_to
                                                                                hotel_arrangements
                                                                                accomodation_same
                                                                                hotel_detail_same
                                                                                transportation_option
                                                                                volunteer
                                                                                medical
                                                                                medical_state_of_license
                                                                                submit_poster
                                                                                poster_description
                                                                                bringing_medical_equipment
                                                                                what_medical_equipment
                                                                                require_transportation_arrival
                                                                                require_transportation_departure
                                                                                hotel_detail
                                                                                ground_transportation
                                                                                submission_date
                                                                                legal
                                                                                ip                      -->
                                        <th>UniqueID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>SNM Branch</th>
                                        <th>Country</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $countRow = 0;
                                    $unique_id = 'not';
                                    
                                    foreach ($data as $key => $record) {
                                        if ($unique_id != $record['unique_id']) {
                                            echo ++$countRow." << NOT EQUAL = ".$record['total'];
                                            echo "<br>";
                                            $unique_id = $record['unique_id'];
                                            $td = "<td rowspan='".$record['total']."'>".$record['unique_id']."</td>";
                                            //$td = "<td >".$record['unique_id']."</td>";
                                            //$td = "rowspan='" . $record['total'] . "'";
                                        } else {
                                            echo ++$countRow." << EQUAL";
                                            echo "<br>";
                                            //$td = "<td >".$record['unique_id']."</td>";
                                            $td = "";
                                        }
                                        ?>
                                        <tr>
                                            <?php echo $td; ?>
                                            <td><?php echo $record['first_name']; ?></td>
                                            <td><?php echo $record['last_name']; ?></td>
                                            <td><?php echo $record['snm_branch']; ?></td>
                                            <td><?php echo $record['country_of_residence']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div><!-- .content -->


</div><!-- /#right-panel -->

<!-- Right Panel -->

<!-- Footer -->
<?php include("include/footer.php"); ?>