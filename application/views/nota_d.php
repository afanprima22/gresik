<? 
if ($query<>false) {
  foreach($query->result() as $val){?>
    <tr>
        <th colspan="3">Diskon <?=$val->discount_name?></th>
        <th colspan="2"><?= number_format($val->discount_detail_value)?></th>
    </tr>
<? 
  }
}
?>