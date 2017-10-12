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
                                <th>Kode nota_retail</th>
                                <th>Customer</th>
                                <th>Diskon Total</th>
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
                            <label>Id nota_retail (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="" style="width: 20%;">
                          </div>
                          <div class="form-group">
                            <label>Tanggal Nota Eceran</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Nota Eceran" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Total Diskon</label>
                            <input class="form-control pull-right money" name="i_discount_total" id="i_discount_total" placeholder="Total Diskon" value="" readonly="">
                          </div>
                          <!--<div class="form-group">
                            <label>Sales</label>
                            <select class="form-control select2" name="i_sales" id="i_sales" style="width: 100%;" required="required" onchange="get_memo()">
                            </select>
                          </div>-->

                        </div>
                        <div class="col-md-6">
                          <!--<div class="form-group">
                            <label>Memo</label>
                            <select class="form-control select2" name="i_memo[]" id="selectmemo" style="width: 100%;">
                            </select>
                          </div>-->
                          <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control select2" name="i_customer" id="i_customer" style="width: 65%;" required="required" onchange="get_customer(this.value)">
                            </select>
                            <a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>Customer</a>
                          </div>
                          <div class="form-group">
                            <label>No Handphone</label>
                            <input class="form-control pull-right" id="i_phone" placeholder="No Handphone Customer" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3" placeholder="Alamat Customer" id="i_addres" readonly=""></textarea>
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
                                        <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                                        </select>
                                      </td>
                                      <td>
                                        <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;" onchange="get_price()">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_detail_price" placeholder="Auto" readonly="">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty" placeholder="Masukkan Qty" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_discount" placeholder="Masukkan Diskon" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Barang</th>
                                      <th>Warna</th>
                                      <th>Harga</th>
                                      <th>Qty</th>
                                      <th>Discount</th>
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
          <form id="formcustomer" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>Form Input Customer</h4>
                  </div>
                  <div class="modal-body">
                            
                          <div class="form-group">
                            <label>Nama Customer</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Customer" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat Customer</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat" required="required" name="i_addres" id="i_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>Nama Toko</label>
                            <input type="text" class="form-control" name="i_store" id="i_store" placeholder="Masukkan Nama Toko" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>Alamat Toko</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Toko" required="required" name="i_store_addres" id="i_store_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>No Telepon</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Telepon" required="required" name="i_telp" id="i_telp" value="">
                          </div>

                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-warning" data-dismiss="modal">Batal</a>
                      <a href="#" class="btn btn-primary" onclick="save_cistomer()" data-dismiss="modal">Save Customer</a>
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
        //select_list_sales();
        select_list_item();
        search_data_detail(0);
        //get_memo();
        //select_list_material();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>nota_retail/load_data/'
            },
            "columns": [
              {"name": "nota_retail_code"},
              {"name": "customer_name"},
              {"name": "nota_retail_discount"},
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
              url: '<?php echo base_url();?>nota_retail/load_data_detail/'+id
            },
            "columns": [
              {"name": "nota_retail_detail_id"},
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "nota_retail_detail_price"},
              {"name": "nota_retail_detail_qty"},
              {"name": "nota_retail_detail_discount"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        get_total_discount(id);
    }


    function active_tab(id){
        if (id == 1) {
          $('[href="#tabs-2"]').tab('show');
        }else{
          $('[href="#tabs-1"]').tab('show');
        }
        
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
          url  : '<?php echo base_url();?>nota_retail/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              if (data.alert=='1') {
                document.getElementById('create').style.display = 'block';
                document.getElementById('update').style.display = 'none';
                document.getElementById('delete').style.display = 'none';
                edit_data(data.id);
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

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>nota_retail/delete_data',
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

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>nota_retail/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].nota_retail_id;
              document.getElementById("datepicker").value           = data.val[i].nota_retail_date;
              document.getElementById("i_discount_total").value           = data.val[i].nota_retail_discount;
              document.getElementById("i_phone").value           = data.val[i].customer_hp;
              document.getElementById("i_addres").value           = data.val[i].customer_address;
              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
              $("#i_sales").append('<option value="'+data.val[i].sales_id+'" selected>'+data.val[i].sales_name+'</option>');
              /*for(var j=0; j<data.val[i].memos.val2.length; j++){
                $("#selectmemo").append('<option value="'+data.val[i].memos.val2[j].id+'" selected>'+data.val[i].memos.val2[j].text+'</option>');
              }
              document.getElementById('detail_data').style.display = 'block';*/
              search_data_detail(data.val[i].nota_retail_id);
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

      function select_list_sales() {
        $('#i_sales').select2({
          placeholder: 'Pilih Sales',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Sales/load_data_select_sales/',
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

      function select_list_item() {
        $('#i_item').select2({
          placeholder: 'Pilih Barang Jadi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item/',
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

      function get_item(id) {
        $('#i_item_detail').select2({
          placeholder: 'Pilih Warna',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item_detail/'+id,
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

      function get_memo() {

        var sales_id = document.getElementById("i_sales").value;
        var customer_id = document.getElementById("i_customer").value;

        $('#selectmemo').select2({
          placeholder: 'Pilih Memo',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Memo/load_data_select_memo/'+customer_id+'/'+sales_id,
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
        $('#i_sales option').remove();
        $('#i_customer option').remove();
        $('#selectmemo option').remove();
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
          url  : '<?php echo base_url();?>nota_retail/action_data_detail/',
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
        $('#i_item option').remove();
        $('#i_item_detail option').remove();
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_detail_discount"]').val("");
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Nota_retail/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].nota_retail_detail_id);
              $('input[name="i_detail_price"]').val(data.val[i].nota_retail_detail_price);
              $('input[name="i_detail_qty"]').val(data.val[i].nota_retail_detail_qty);
              $('input[name="i_detail_discount"]').val(data.val[i].nota_retail_detail_discount);
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');

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
                url: '<?php echo base_url();?>Nota_retail/delete_data_detail',
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

    function get_customer(id){
        $.ajax({
          type: 'GET',
          url: '<?php echo base_url();?>Customer/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success: function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_phone").value           = data.val[i].customer_hp;
              document.getElementById("i_addres").value          = data.val[i].customer_address;

            }
          } 
        });
      }

    function save_cistomer(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Nota_retail/action_data_customer/',
          data : $( "#formcustomer" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){

            }
          }
        });
        //alert("test");
    }

    function get_price(){

      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Nota/get_price/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            $('input[name="i_detail_price"]').val(data);
          }
        });
    }

    function get_total_discount(id){

      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Nota_retail/get_total_discount/'+id,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            $('input[name="i_discount_total"]').val(data);
          }
        });
    }

</script>
</body>
</html>