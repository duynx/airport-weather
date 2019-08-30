<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header')?>
<div class="container">
    <div class="row">
        <ul class="pager">
            <li class="next"><a href="<?= base_url('logout') ?>">Logout</a></li>
        </ul>
    </div>
    <h2>Airport Weather</h2>
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        </div>
    </div>
    <form action="" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="airport">Airport</label>
                    <input type="text" class="form-control" id="airport" placeholder="Enter airport name" name="airport" value="<?= set_value('airport'); ?>">
                    <input type="hidden" name="icao" id="icao" value="<?= set_value('icao') ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="datepicker">Date</label>
                    <input type="text" class="form-control" id="datepicker" placeholder="Select date" name="date" value="<?= set_value('date'); ?>" readonly>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="timepicker">Time</label>
                    <input type="text" class="form-control" id="timepicker" placeholder="Select time" name="time" value="<?= set_value('time'); ?>" readonly>
                </div>
            </div>
            <div class="col-md-2" style="padding:25px 0">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12" id="result">
            <font color='red'><?php echo $this->session->flashdata('mess')?></font>
            <code>
                <?php $weather = $this->session->flashdata('rs');
                if(!empty($weather)) {
                    foreach ($weather as $w) {
                        echo '<p>' . $w . '</p>';
                    }
                }
                ?>
            </code>
        </div>
    </div>
</div>

</body>
<link rel="stylesheet" type="text/css" href="<?= public_helper('css/jquery.datetimepicker.css')?>"/ >
<link rel="stylesheet" type="text/css" href="<?= public_helper('css/autocomplete.css')?>"/ >
<script src="<?= public_helper('js/jquery.js')?>"></script>
<script src="<?= public_helper('js/jquery.datetimepicker.full.min.js')?>"></script>
<script src="<?= public_helper('js/jquery.autocomplete.js')?>"></script>
<script>
    jQuery('#airport').autocomplete({
        serviceUrl: '<?= base_url('/ajax-airport-search') ?>',
        onSelect: function (suggestion) {
            $('#icao').val(suggestion.data);
        }
    });

    jQuery('#datepicker').datetimepicker({
        timepicker:false,
        format:'Y/m/d'
    });
    jQuery('#timepicker').datetimepicker({
        step:60,
        datepicker:false,
        format:'H:i'
    });
</script>
</html>


