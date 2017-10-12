<!DOCTYPE html>
<html>
<head>
  <title>Gresik | <?php echo $title; ?></title>
  <!-- Bootstrap CSS-->
  <style type="text/css">
    body {
      font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
      font-weight: 400;
      font-size:12px;
    }
    p {
      font-size:16px;
    }
    table.hdr-table td { padding:12px; }
  </style>
</head>
<body>
  <div class="container">
  
    <!--<h4 align="center" style="font-size: 16px;"><b><?php echo $title; ?></b></h4>-->
    <table class="table table-striped" border="0" width="100%" cellspacing="0">
      <thead>
        <tr>
          <td colspan="5" style="font-size: 20px;text-align: center;"><b><?php echo $title; ?></b></td>
        </tr>
        <tr>
          <td width="0%"></td>
          <td width="40%"></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td><b>Tanggal</b></td>
          <td>: <?=$mixer_date?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th colspan="2">Nomor Mixer</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT COUNT(mixer_id) as jml FROM mixers a WHERE a.mixer_date ='$mixer_date'";
        $mixer = $this->g_mod->select_manual($sql);
        $no = 1;
        for ($i=0; $i < $mixer['jml'];) { ?>
          
          <tr>
            <td><?=$no?></td>
            <?php 
            $sql2 = "SELECT a.* FROM mixers a WHERE a.mixer_date ='$mixer_date' LIMIT $i,2";
            $row = $this->g_mod->select_manual_for($sql2);
            foreach ($row->result() as $val2) { ?>
            <td style="font-size: 19px;"><b><?=$val2->mixer_code?></b></td>
            <?
            $i++;
            }
            ?>
            <?
              if ($i%2==1) {?>
               <td>&nbsp;</td>
              <?}?>
          </tr>

        <?
       $no++;
        }
        ?>
      </tbody>
    </table>
    
  </div>
</body>
</html>