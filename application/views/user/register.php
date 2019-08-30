<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('layout/header'); ?>
<div class="container">
    <div class="row">
        <ul class="pager">
            <li class="next"><a href="<?= base_url('login') ?>">Login</a></li>
        </ul>
    </div>
    <h2>Register</h2>
    <div class="row">
        <div class="col-md-12">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            <?php
            if($this->session->flashdata('mess')){
                echo '<div class="alert alert-success">'.$this->session->flashdata('mess').'</div>';
            }
            ?>
        </div>
    </div>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
        </div>
        <div class="form-group">
            <label for="repwd">Confirm Password:</label>
            <input type="password" class="form-control" id="repwd" placeholder="Re-type password" name="repwd">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>

</body>
</html>
