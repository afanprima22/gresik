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
          <td width="30%"></td>
          <td  width="30%"></td>
          <td width="30%"></td>
          <td width="20%">Tanggal :</td>
          <td width="20%"> <?= $nota_date ?></td>
        </tr>
        <tr>
          <td colspan="3" width="30%"><b>GRESIK</b></td>
          <td width="20%">&nbsp;</td>
          <td width="30%">&nbsp;</td>
          <td width="30%">&nbsp;</td>
          <td width="20%">Kepada Yth. :</td>
          <td width="10%"> <?= $customer_name ?></td>
        </tr>
        <tr>
          <td width="20%">No.Nota :</td>
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
          <th>Harga Satuan</th> 
          <th>Discount</th> 
          <th>Jumlah</th> 
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
        $total_row = 0;
        $total_diskon = 0;
        $total_coli = 0;
        foreach ($row->result() as $val2) {
          $diskon = $val2->nota_detail_discount / 100 * $val2->nota_detail_price;
          $satuan = $val2->nota_detail_qty * $val2->item_qty_per_dos;
          $total = $satuan * $val2->nota_detail_price;
          $coli = $val2->nota_detail_qty;
          ?>
          <tr>
            <td><?=$no?></td>
            <td><?=$val2->nota_detail_qty?>&nbsp;DOS</td>
            <td><?=$val2->item_qty_per_dos?></td>
            <td><?=$satuan?></td>
            <td><?=$val2->item_name?></td>
            <td><?=$val2->nota_detail_price?></td>
            <td><?=$val2->nota_detail_discount?></td>
            <td><?=$total?></td>
          </tr>
        <? 
        $no++;
        $total_row += $total;
        $total_diskon += $diskon;
        $total_coli += $coli;

        }?>
        <tr  border="0">
                  <td colspan="8"><table width="100%" border="0">
                  <?php
                    $grand_total = $total_row - $total_diskon;
                  ?>
                    <tr>
                      <td colspan="6" rowspan="2">Terbilang : <?= ucwords(Terbilang($grand_total))?></td>
                      <th width="18%" style="text-align:right">Jumlah : Rp.</th>
                      <th width="10%" style="text-align:right"> <?=$total_row?></th>
                    </tr>
                    <tr>
                      <th style="text-align:right">Diskon : Rp.</th>
                      <th width="10%" style="text-align:right"><?=$total_diskon?></th>
                    </tr>
                    <tr>
                      <td colspan="6" rowspan="3">Keterangan :</td>
                      <th style="text-align:right">Pot. Isi : Rp.</th>
                      <th width="10%" style="text-align:right"> 0</th>
                    </tr>
                    <tr>
                      <th style="text-align:right">Ongkos : Rp.</th>
                      <th width="10%" style="text-align:right"> 0</th>
                    </tr>
                    <tr>
                      <th style="text-align:right">Total : Rp.</th>
                      <th width="10%" style="text-align:right"> <?=$grand_total?></th>
                    </tr>

                  </table></td>
                </tr>
                  <td colspan="8"><table width="100%" border="0">
                  <?
                    $time = $nota_date;
                    $final = date("Y-m-d", strtotime("+1 month", strtotime($time)));
                  ?>
                    <tr>
                      <td width="14%">Jatuh Tempo :</td>
                      <td width="20%"> <?= $final ?></td>
                      <td width="12%">Banyaknya :</td>
                      <td width="17%"><?=$total_coli?></td>
                      <td width="20%" align="center">Hormat Kami,</td>
                      <td ></td>
                    </tr>
                    <tr>
                      <td width="14%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="12%">&nbsp;</td>
                      <td width="17%">&nbsp;</td>
                      <td width="20%" align="center">&nbsp;</td>
                      <td ></td>
                    </tr>
                    <tr>
                      <td width="14%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="12%">&nbsp;</td>
                      <td width="17%">&nbsp;</td>
                      <td width="20%" align="center">&nbsp;</td>
                      <td ></td>
                    </tr>
                    <tr>
                      <td width="14%">&nbsp;</td>
                      <td width="20%">&nbsp;</td>
                      <td width="12%">&nbsp;</td>
                      <td width="17%">&nbsp;</td>
                      <td width="20%" align="center">(.....................................)</td>
                      <td ></td>
                    </tr>
                  </table></td>
      </tbody>
      
               
</table>
<br>
<br>
<table width="100%" border="0">



<p>&nbsp;</p>
</body>
</html>
<?php
function Terbilang($x)
{
  $abil = array(" ", "satu ", "dua ", "tiga ", "empat ", "lima ", "enam ", "tujuh ", "delapan ", "sembilan ", "sepuluh ", "sebelas ");
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
