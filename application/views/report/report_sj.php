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
          <td colspan="8" style="font-size: 20px;text-align: center;"><b><?php echo $title; ?></b></td>
        </tr>
        <tr>
          <td  colspan="3" width="20%"><b>PT.GUNUNG AGUNG SENTOSA</b></td>
          <td width="20%"></td>
          <td  width="30%"></td>
          <td width="20%"></td>
          <td width="20%">Tanggal :</td>
          <td width="25%"> <?= $nota_date ?></td>
        </tr>
        <tr>
          <td colspan="3" width="30%"><b>GRESIK</b></td>
          <td width="20%">&nbsp;</td>
          <td width="30%">&nbsp;</td>
          <td width="30%">&nbsp;</td>
          <td width="22%">Kepada Yth. :</td>
          <td width="10%"> <?= $customer_name ?></td>
        </tr>
        <tr>
          <td width="20%">No.nota :</td>
          <td width="20%"><?=$nota_code?></td>
          <td width="18%">&nbsp;</td>
          <td>Salesman :</td>
          <td><?=$sales_name?></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
      </thead>
    </table>
    <table class="table table-striped" border="1" width="100%" cellspacing="0" style="padding-top: 10px">
      <thead>
        <tr>
          <th>No</th>
          <th>Banyaknya</th>
          <th>Satuan </th>
          <th>Jumlah Satuan</th>
          <th>Nama Barang</th> 
          <th>GD</th> 
          <th>KETERANGAN</th> 
        </tr>
      </thead>
      <tbody>
      <?php
        $sql = "SELECT a.*,b.item_name,b.item_qty_per_dos,b.item_netto 
                FROM nota_details a 
                JOIN items b on b.item_id = a.item_id 
                WHERE nota_id = $nota_id";
        $row = $this->g_mod->select_manual_for($sql);
        $no = 1;
        $total_coli = 0;
        foreach ($row->result() as $val2) {
          $jum_Sat = $val2->nota_detail_qty * $val2->item_qty_per_dos;
          $coli = $val2->nota_detail_qty;
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->nota_detail_qty?>&nbsp;DOS</td>
            <td><?=$val2->item_qty_per_dos?></td>
            <td><?=$jum_Sat?></td>
            <td><?=$val2->item_name?></td>
            <td width="2%">0</td>
            <td></td>
          </tr>
        <? 
        $no++;
        $total_coli += $coli;

        }?>
        <tr  border="0">
                  <td colspan="7"><table width="100%" border="0">
                    <tr>
                      <td colspan="4">Banyaknya : <?=$total_coli?>&nbsp;(<?= ucwords(Terbilang($total_coli))?>)&nbsp;DOLI</td>
                      <th width="16%" style="text-align:right"></th>
                      <th width="10%" style="text-align:right"> </th>
                      <th width="15%" style="text-align:right"> </th>
                      <th width="10%" style="text-align:right"> </th>
                    </tr>
                    <tr>
                      <td colspan="4"></td>
                      <th style="text-align:left">Selesai Bongkar :</th>
                      <th width="10%" style="text-align:left"> </th>
                      <th width="15%" style="text-align:left">Jam Berangkat :</th>
                      <th width="10%" style="text-align:left"> </th>
                    </tr>
                    

                  </table></td>
                </tr>
                  <td colspan="7"><table width="100%" border="0">
                    <tr>
                      <td width="20%" align="center">Diterima,</td>
                      <td width="20%" align="center">Dimuat,</td>
                      <td width="20%" align="center">Diserahkan,</td>
                      <td width="20%" align="center">Diperiksa,</td>
                      <td width="20%" align="center">Hormat Kami,</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="20%" align="center">(.....................................)</td>
                      <td width="20%" align="center">(.....................................)</td>
                      <td width="20%" align="center">(.....................................)</td>
                      <td width="20%" align="center">(.....................................)</td>
                      <td width="20%" align="center">(.....................................)</td>
                    </tr>
                  </table></td>
      </tbody>
      
               
</table>



<p>&nbsp;</p>
</body>
</html>

<?php
function Terbilang($x)
{
  $abil = array("nol ", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}

?>