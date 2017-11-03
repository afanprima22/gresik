<style type="text/css">
  .money{
    text-align: right;
  }
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list" data-toggle="tab">List Data</a></li>
        <li><a href="#form" data-toggle="tab">Form Data</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="list">
            <div class="box-inner">
                <div class="box-content">
                    <div id="create" class="alert alert-success" style="display: none;"><h4><i class="glyphicon glyphicon-check"></i> Sukses!</h4>Data telah Disimpan.</div>
                    <div id="update" class="alert alert-info" style="display: none;"><h4><i class="glyphicon glyphicon-info-sign"></i> Sukses!</h4>Data telah Direvisi.</div>
                    <div id="delete" class="alert alert-danger" style="display: none;"><h4><i class="glyphicon glyphicon-ban-circle"></i> Sukses!</h4>Data telah Dihapus.</div>
                    <table width="100%" id="table1" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Nama Kongsi</th>
                                <th>Tanggal</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

        </div>
        <div class="tab-pane" id="form">
            <div class="box-inner">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
                    <div class="box-content">
                      <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Kongsi</label>
                            <select class="form-control select2" name="i_kongsi" id="i_kongsi" style="width: 100%;" required="required">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Set</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" >
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Masukkan Tanggal Set Cabang" value="" required="required">
                           </div>
                          </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>

                        <div class="col-md-12" id="detail_data" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Total Order</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

          

                      </div>
                      <div class="form-group"></div>
                      <div class="box-footer text-right">
                        <!--<a href="#myModal" class="btn btn-info" data-toggle="modal">Click for dialog</a>-->
                        
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>

                        
                      </div>

                    </div>
                </form>

            </div>
        </div>

        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Cabang</h4>
                      <input type="hidden" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                      <input type="hidden" class="form-control" name="detail_id" id="detail_id" placeholder="Auto" readonly="">
                      <input type="hidden" class="form-control" name="detail" id="detail" placeholder="Auto" readonly="">
                      <input type="hidden" class="form-control" name="set_branch_id" id="set_branch_id" placeholder="Auto" readonly="">

                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="form-group">
                              <div class="col-md-6">
                                
                              </div>
                              <div class="col-md-6">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Qty Total</label>
                                  <input type="text" style="width: 50%;" class="form-control" name="i_total" id="i_total" placeholder="Qty total" readonly="">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label>Qty Sisa</label>
                                  <input type="text" style="width: 50%;" class="form-control" name="i_stock" id="i_stock" placeholder="Qty sisa" readonly="">
                                </div>
                              </div>
                              </div>
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">

                                  <thead>
                                    <tr>
                                      <th>Cabang</th>
                                      <th>Qty Stok</th>
                                      <th>Qty Dibagi</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button"  onclick="action_data_bagi()" class="btn btn-primary">Simpan</button>
                  </div>
              </div>
          </form>
          </div>
      </div>

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_kongsi();
        
        //search_data_detail(0);
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Set_branch_kongsi/load_data/'
            },
            "columns": [
              {"name": "kongsi_name"},
              {"name": "set_branch_date"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Set_branch_kongsi/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "order_kongsi_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    /*function search_data_order_kongsi(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Set_branch_kongsi/load_data_order_kongsi/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "order_kongsi_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }*/

    function search_data_stock(id,id2,id3,id4) {
        total(id,id2,id3,id4);
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Set_branch_kongsi/load_data_stock/'+id+'/'+id2
            },
            "columns": [
              {"name": "kongsi_branch_name"},
              {"name": "set_detail_branch_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

    }

    /*function active_tab(id){
        if (id == 1) {
          $('[href="#tabs-2"]').tab('show');
        }else{
          $('[href="#tabs-1"]').tab('show');
        }
        
    }*/

    $("#formall").submit(function(event){
        if ($("#formall").valid()==true) {
          action_data();
        }
        return false;
      });

    function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Set_branch_kongsi/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              search_data_detail(0);
              if (data.alert=='1') {
                document.getElementById('create').style.display = 'block';
                document.getElementById('update').style.display = 'none';
                document.getElementById('delete').style.display = 'none';
                edit_data(data.id2);
              }else if(data.alert=='2'){
                document.getElementById('create').style.display = 'none';
                document.getElementById('update').style.display = 'block';
                document.getElementById('delete').style.display = 'none';
                $('[href="#list"]').tab('show');
              }
            } 
          }
        });
    }

    function action_data_bagi(){
      var id = document.getElementById("i_detail_id").value;
      var id2 = document.getElementById("detail").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Set_branch_kongsi/action_data_bagi/'+id+'/'+id2,
          data : $( "#form_modal" ).serialize(),
          dataType : "json",
          success:function(data){
            $('#myModal').modal('hide');
          }
        });
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Set_branch_kongsi/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset2();
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].set_branch_id;
              document.getElementById("datepicker").value           = data.val[i].set_branch_date;

              $("#i_kongsi").append('<option value="'+data.val[i].kongsi_id+'" selected>'+data.val[i].kongsi_name+'</option>');
              
              document.getElementById('detail_data').style.display = 'block';
              search_data_detail(data.val[i].set_branch_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function total(id,id2,id3,id4) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Set_branch_kongsi/total/'+id2+'/'+id3,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_detail_id").value             = id;
              document.getElementById("detail").value             = id2;
              document.getElementById("detail_id").value             = id3;
              document.getElementById("set_branch_id").value             = id4;
              document.getElementById("i_total").value           = data.val[i].order_kongsi_detail_qty;
              document.getElementById("i_stock").value           = data.val[i].order_kongsi_detail_qty - data.val[i].qty;
              
            }
          }
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Set_branch_kongsi/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
                    reset2();
                    search_data();

                    document.getElementById('create').style.display = 'none';
                    document.getElementById('update').style.display = 'none';
                    document.getElementById('delete').style.display = 'block';
                  }
                }
            });
        }
        
    }

      function reset2(){
        $('input[name="i_date"]').val("");
        $('#i_kongsi option').remove();
        document.getElementById('detail_data').style.display = 'none';     
      }

  function select_list_kongsi() {
        $('#i_kongsi').select2({
          placeholder: 'Pilih kongsi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>kongsi/load_data_select_kongsi/',
            dataType: 'json',
            delay: 100,
            cache: true,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, params) {
              params.page = params.page || 1;

              return {
                results: data.items,
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            }
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 1,
          templateResult: FormatResult,
          templateSelection: FormatSelection,
        });
      }
      
      
      
</script>
</body>
</html>