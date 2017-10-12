<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <title>Pabrik Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The styles -->
    <link  href="<?= base_url() ?>assets/css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="<?= base_url() ?>assets/css/charisma-app.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico">

</head>

<body>
<div class="ch-container">
    <div class="row">
        
    <div class="row">
        <div class="col-md-12 center login-header">
            <h2>Welcome to System Pabrik</h2>
        </div>
        <!--/span-->
    </div><!--/row-->

    <div class="row">
        <div class="well col-md-5 center login-box">
            
            <div class="alert alert-danger" id="incorrect" style="display: none;">
                Error! Username and Password incorrect.
            </div>
            <div class="alert alert-info" id="entry_login">
                Please login with your Username and Password.
            </div>

            <form class="form-horizontal" action="" method="post" id="login">
                <fieldset>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
                        <input type="text" class="form-control" placeholder="Username" name="username">
                    </div>
                    <div class="clearfix"></div><br>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <div class="clearfix"></div>

                    <div class="clearfix"></div>

                    <p class="center col-md-5">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </p>
                </fieldset>
            </form>
        </div>
        <!--/span-->
    </div><!--/row-->
</div><!--/fluid-row-->

</div><!--/.fluid-container-->

<!-- jQuery-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-2.2.4.min.js')?>"></script>
  

    <script type="text/javascript">
      $(document).ready(function(){
      });

      $("#login").submit(function(event){
   
        $.ajax({
          url: '<?php echo base_url();?>Login/do_login',
          type: 'POST',
          data: $( "#login" ).serialize(),
          dataType: 'json',
          success: function (data) {
            if (data.status=='200') {
                window.location.href = "<?php echo base_url('Dashboard');?>";
            } else if (data.status=='204') {
              document.getElementById('login').reset();
              document.getElementById('incorrect').style.display = 'block';
              document.getElementById('entry_login').style.display = 'none';
            }
          }
        });

        return false;
      });

    </script>


</body>
</html>
