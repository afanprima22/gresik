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
                                <th>Kode Retur</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
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
                            <label>Id Retur (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control select2" name="i_customer" id="i_customer" style="width: 100%;" required="required" onchange="select_list_nota(this.value)">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Type :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_type" id="status1" value="1" >
                              </label>
                              <label for="status1">
                                Cash &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_type" id="status2" value="2" >
                              </label >
                              <label for="status2">
                                Balance
                              </label>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nota</label>
                            <select class="form-control select2" name="i_nota" id="i_nota" style="width: 100%;" required="required" onchange="select_list_nota_detail(this.value)">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Retur</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Retur" value="" required="required">
                            </div>
                          </div>

                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_detail_id" placeholder="Auto" readonly=""></td>
                                      
                                      <td>
                                        <select class="form-control select2" name="i_nota_detail" id="i_nota_detail" style="width: 100%;" onchange="get_detail(this.value)">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_detail_order" placeholder="Auto" readonly="">
                                      </td>
                                      <td><input type="text" class="form-control" name="i_detail_price" placeholder="Auto" readonly=""></td>
                                      <td><input type="text" class="form-control" name="i_detail_discount" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control money" name="i_detail_qty" placeholder="Masukkan Qty Retur" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Keterangan</th>
                                      <th>Qty Order</th>
                                      <th>Harga Nota</th>
                                      <th>Discount</th>
                                      <th>Qty Retur</th>
                                      <th >Config</th>
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
                        <button type="button" onclick="reset(),reset2(),reset3()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
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
        select_list_customer();
        select_list_nota(0);
        select_list_nota_detail(0);
        search_data_detail(0);
    });

    function type_detail(id){

    if (id == 1 || id == 2) {
      document.getElementById('item').style.display     = 'block';
      document.getElementById('sperpart').style.display = 'none';
      document.getElementById('material').style.display = 'none';
        
      select_list_item_type(id);
    }else if(id == 3){
      document.getElementById('item').style.display     = 'none';
      document.getElementById('sperpart').style.display = 'block';
      document.getElementById('material').style.display = 'none';
    }else if(id == 4){
      document.getElementById('item').style.display     = 'none';
      document.getElementById('sperpart').style.display = 'none';
      document.getElementById('material').style.display = 'block';
    }
    
    $('select[name="i_item"]').val(0);
    $('select[name="i_item_detail"]').val(0);
    $('select[name="i_sperpart"]').val(0);
    $('select[name="i_material"]').val(0);

  }

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Retur_cus/load_data/'
            },
            "columns": [
              {"name": "retur_code"},
              {"name": "retur_date"},
              {"name": "customer_name"},
              {"name": "total","orderable": false,"searchable": false},
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
              url: '<?php echo base_url();?>Retur_cus/load_data_detail/'+id
            },
            "columns": [
              {"name": "retur_detail_id"},
              {"name": "item_name"},
              {"name": "nota_detail_qty"},
              {"name": "retur_detail_price"},
              {"name": "retur_detail_discount"},
              {"name": "retur_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    $("#formall").submit(function(event){
        if ($("#formall").valid()==true) {
          action_data();
        }
        return false;
      });

    function action_data(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Retur_cus/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              reset3();
              search_data();
              if (data.alert=='1') {
                document.getElementById('create').style.display = 'block';
                document.getElementById('update').style.display = 'none';
                document.getElementById('delete').style.display = 'none';
              }else if(data.alert=='2'){
                document.getElementById('create').style.display = 'none';
                document.getElementById('update').style.display = 'block';
                document.getElementById('delete').style.display = 'none';
                
              }
            }
            $('[href="#list"]').tab('show'); 
          }          
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Retur_cus/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
                    reset2();
                    reset3();
                    search_data();

                    document.getElementById('create').style.display = 'none';
                    document.getElementById('update').style.display = 'none';
                    document.getElementById('delete').style.display = 'block';
                  }
                }
            });
        }
        
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Retur_cus/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].retur_id;
              document.getElementById("datepicker").value           = data.val[i].retur_date;
              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
              $("#i_nota").append('<option value="'+data.val[i].nota_id+'" selected>'+data.val[i].nota_code+'</option>');
              search_data_detail(data.val[i].retur_id);

              if (data.val[i].retur_type == 1) {
                document.getElementById("status1").checked = true;
              } else if (data.val[i].retur_type == 2) {
                document.getElementById("status2").checked = true;
              }
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_customer() {
        $('#i_customer').select2({
          placeholder: 'Pilih Customer',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Customer/load_data_select_customer/',
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

      function select_list_nota(id) {
        $('#i_nota').select2({
          placeholder: 'Pilih Nota',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Nota/load_data_select_nota/'+id,
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

      function select_list_nota_detail(id) {
        $('#i_nota_detail').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Nota/load_data_select_nota_detail/'+id,
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

      function reset2(){
        $('#i_customer option').remove();
        $('#i_nota option').remove();
      }

      function save_detail(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Retur_cus/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_detail(id_new);
            } 
          }
        });
      }

      function reset3(){
        $('input[name="i_detail_id"]').val("");
        $('#i_nota_detail option').remove();
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_detail_order"]').val("");
        $('input[name="i_detail_discount"]').val("");
        $('input[name="i_detail_price"]').val("");

        search_data_detail(0);
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Retur_cus/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            //reset3();
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].retur_detail_id);
              $('input[name="i_detail_qty"]').val(data.val[i].retur_detail_qty);
              $('input[name="i_detail_discount"]').val(data.val[i].retur_detail_discount);
              $('input[name="i_detail_price"]').val(data.val[i].retur_detail_price);
              $('input[name="i_detail_order"]').val(data.val[i].nota_detail_qty);

              $("#i_nota_detail").append('<option value="'+data.val[i].retur_detail_data_id+'" selected>'+data.val[i].retur_detail_item+'</option>');

            }
          }
        });
      }

      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Purchase/delete_data_detail',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail(id_new);
                  }
                }
            });
        }
        
    }

    function get_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>nota/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_order"]').val(data.val[i].nota_detail_qty);
              $('input[name="i_detail_discount"]').val(0);
              $('input[name="i_detail_price"]').val(data.val[i].nota_detail_price);

            }
          }
        });
      }

</script>
</body>
</html>