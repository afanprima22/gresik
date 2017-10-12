                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th width="5%">Check</th>
                                      <th>Kode Nota</th>
                                      <th>Customer</th>
                                      <th>Sales</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <? 
                                  if ($query_nota<>false) {
                                    foreach($query_nota->result() as $val){?>
                                    <tr>
                                      <td width="5%" align="center"><input <? if($id){?> disabled="" checked="" <? }?> type="checkbox" id="check_nota<?=$val->nota_id?>" onclick="check_nota(<?=$val->nota_id?>)"></td>
                                      <td><?=$val->nota_code?></td>
                                      <td><?=$val->customer_name?></td>
                                      <td><?=$val->sales_name?></td>
                                    </tr>
                                  <? 
                                    }
                                  }
                                  ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
<script type="text/javascript">
    $('.datatable').dataTable({
        "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-12'i><'col-md-12 center-block'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page"
        }
    });

    function check_nota(detail_id)
    {
      var id = document.getElementById("i_id").value;

        var chkBox = document.getElementById('check_nota'+detail_id);
        if (chkBox.checked)
        {
          //alert("check");
          $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>Delivery/action_data_detail/'+1,
            data : {id:id,detail_id:detail_id},
            dataType : "json",
            success:function(data){
              
            }
          });
        }else{
          //alert("no check");
          $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>Delivery/action_data_detail/'+2,
            data : {id:id,detail_id:detail_id},
            dataType : "json",
            success:function(data){
              
            }
          });
        }
    }
</script>