<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<style>
    .dataTables_filter {
        display: none;
    }

    container-fluid {
        max-width: 100% !important;
    }

     @media only screen and (max-width: 369px) {

        table.dataTable thead th,
        table.dataTable thead td {
            padding: 10px 5px;
            border-bottom: 1px solid #000;
        }

    }
    }   
</style>


<?php if (is_user_logged_in()) { ?>
    <div class="container-fluid mt-5" style="overflow: auto;">
        <!-- <h2>Total Points : <span id="totalScore"></span></h2> -->
        <table class="table" id="myscoredata-table" style="width: 1092px !important;">
            <thead>
                <!-- <th>ID</th> -->
                <th>Sport</th>
                <th>League</th>
                <th>Points</th>
                <th>Action</th>
            </thead>
        </table></br></br></br>
        <div>

            <script type="text/javascript">
                var $ = jQuery;
                var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
                $(document).ready(function() {
                    my_score_list();
                })
            </script>


        <?php } else {
        $singinlink = home_url('login/');  ?>
            <h1>You Are Not Log-In,</h1>
            <h1>Log-In To View Your Score.</h1>
            <a class="btn btn-lg" style="background-color: #24890d !important; color: white !important;" <?php echo "href='$singinlink'" ?> role="button">Log-In</a></br></br></br>

        <?php  } ?>