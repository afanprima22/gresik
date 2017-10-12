  </div><!--/fluid-row-->
</div>

    <!-- Ad, you can remove it -->
    <div class="row">

    </div>
    <!-- Ad ends -->
    <hr>

<footer class="row">
        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy; <a href="http://jasasoftdroid.com" target="_blank">Jasa Softdroid</a> 2017</p>

        <!--<p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a
                href="http://jasasoftdroid.com">FSystem</a></p>-->
    </footer>

</div><!--/.fluid-container-->

<!-- jQuery 2.2.3 -->
<script src="<?= base_url() ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>

<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url() ?>assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?= base_url() ?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= base_url() ?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?= base_url() ?>assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?= base_url() ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?= base_url() ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<!-- Number Format -->
<script src="<?= base_url() ?>assets/plugins/numberformat/jquery.number.min.js"></script>
<!-- external javascript -->



<!-- library for cookie management -->
<script src="<?= base_url() ?>assets/js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='<?= base_url() ?>assets/bower_components/moment/min/moment.min.js'></script>
<script src='<?= base_url() ?>assets/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?= base_url() ?>assets/js/jquery.dataTables.min.js'></script>


<!-- select or dropdown enhancer -->
<script src="<?= base_url() ?>assets/bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?= base_url() ?>assets/bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="<?= base_url() ?>assets/js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="<?= base_url() ?>assets/bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="<?= base_url() ?>assets/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?= base_url() ?>assets/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="<?= base_url() ?>assets/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="<?= base_url() ?>assets/js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?= base_url() ?>assets/js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="<?= base_url() ?>assets/js/charisma.js"></script>
<!-- jQuery Validation-->
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/jquery.validate.min.js')?>"></script>
<script src="<?php echo base_url('assets/plugins/jquery-validation/dist/additional-methods.min.js')?>"></script>
<script src="<?php echo base_url('assets/my_custom.js')?>"></script>

<script>
  $(function () {
    //format money
    $('.money').number( true, 0, ',', '.' );
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    $('#reservation2').daterangepicker();
    $('#reservation3').daterangepicker();
    $('#reservation4').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
    $('#datepicker2').datepicker({
      autoclose: true
    });
    $('#datepicker3').datepicker({
      autoclose: true
    });
    $('#datepicker4').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });
</script>
