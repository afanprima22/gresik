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
                                <th>Kode Memo</th>
                                <th>Nama Toko</th>
                                <th>PIC</th>
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
                            <label>Customer</label>
                            <select class="form-control select2" name="i_customer" id="i_customer" style="width: 100%;" required="required">
                            </select>
                            <input type="hidden" name="i_lock" id="i_lock" value="">
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Sales</label>
                            <select class="form-control select2" name="i_sales" id="i_sales" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Sales Order</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Sales Order" value="" required="required">
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
                                        <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                                        </select>
                                      </td>
                                      <td>
                                        <select id="i_item_detail" class="form-control select2" onchange="cek_stock(this.value), cek_nota_qty(this.value)" name="i_item_detail" style="width: 100%;">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" readonly="" class="form-control" name="i_stock" id="i_stock" placeholder="Stock" >
                                      </td>
                                      <td>
                                        <input type="text" readonly="" class="form-control" name="i_nota_qty" id="i_nota_qty" placeholder="Nota Qty" >
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty" placeholder="Masukkan Qty" >
                                      </td>
                                      <td width="10%"><div id="save_detail"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></div></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Barang</th>
                                      <th>Warna</th>
                                      <th>Stock</th>
                                      <th>Nota Qty</th>
                                      <th>Qty</th>
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
                      <div class="box-footer text-right" id="lock">
                        <!--<a href="#myModal" class="btn btn-info" data-toggle="modal">Click for dialog</a>-->
                        <button type="button" class="btn btn-info" id="lock_button" style="float: left;" onclick="action_lock()">Lock</button>
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                      <div class="box-footer text-right" id="request">
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="action_request()">Request</button>
                      </div>
                      <div class="box-footer text-right" id="approve">
                        <a href="#myModal" class="btn btn-info" data-toggle="modal">Approve</a>
                        <button type="button" class="btn btn-warning" >Denied</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>


        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 30%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-body">
                      <input type="password" class="form-control" name="i_password" id="i_password" placeholder="Masukkan Password" onkeydown="if (event.keyCode == 13) { cek_password(this.value,50); }">
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
        select_list_sales();
        select_list_item();
        search_data_detail(0);
        //select_list_material();
        document.getElementById("lock_button").style.display='none';
        document.getElementById("request").style.display='none';
        document.getElementById("approve").style.display='none';
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Memo/load_data/'
            },
            "columns": [
              {"name": "memo_code"},
              {"name": "customer_name"},
              {"name": "customer_purchase_pic"},
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
              url: '<?php echo base_url();?>Memo/load_data_detail/'+id
            },
            "columns": [
              {"name": "memo_detail_id"},
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "stock_qty"},
              {"name": "memo_detail_nota_qty"},
              {"name": "memo_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>memo/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].memo_id;
              document.getElementById("datepicker").value       = data.val[i].memo_date;
              document.getElementById("i_lock").value       = data.val[i].memo_lock;

              $("#i_sales").append('<option value="'+data.val[i].sales_id+'" selected>'+data.val[i].sales_name+'</option>');
              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');

              search_data_detail(data.val[i].memo_id);

              
              if (data.val[i].memo_request == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("approve").style.display='block';
                document.getElementById("save_detail").style.display='none';
              }else if(data.val[i].memo_lock == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='block';
                document.getElementById("save_detail").style.display='none';
              }else if(data.val[i].memo_lock == 0){
                document.getElementById("lock").style.display='block';
                document.getElementById("lock_button").style.display='block';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("save_detail").style.display='block';
              }

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function edit_data_detail(id){
      var lock = document.getElementById("i_lock").value;
        if (lock == 0) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>memo/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].memo_detail_id);
              $('input[name="i_detail_qty"]').val(data.val[i].memo_detail_qty);
              $('input[name="i_stock"]').val(data.val[i].stock_qty);
              $('input[name="i_nota_qty"]').val(data.val[i].memo_detail_qty_nota);
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');

            }
          }
        });
     }else{
          alert("Maaf data sudah di lock!");
        }
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
      var lock = document.getElementById("i_lock").value;
      if (lock == 0) {
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>memo/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              $('[href="#list"]').tab('show');
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
          }
        });
        }else{
        alert("Maaf data sudah di lock!");
      }
    }

    function save_detail(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);
        var lock = document.getElementById("i_lock").value;
        if (lock == 0) {
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Memo/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_detail(id_new);
            } 
          }
        });
        }else{
          alert("Maaf data sudah di lock!");
        }
      }

    function action_lock(){
      var id = document.getElementById("i_id").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Memo/action_data_lock/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              //alert("berhasil");
              /*reset2();
              $('[href="#list"]').tab('show');*/
              /*document.getElementById("lock").style.display='none';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='block';*/
                edit_data(id);
            } 
          }
        });
      }

      function action_request(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Memo/action_data_request/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              //alert("berhasil");
              search_data();
              search_data_detail(0);
            } 
          }
        });
              $('[href="#list"]').tab('show');
      }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>memo/delete_data',
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

    function delete_data_color(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>memo/delete_data_color',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_color(id_new);
                  }
                }
            });
        }
        
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
                url: '<?php echo base_url();?>memo/delete_data_detail',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_color(id_new);
                  }
                }
            });
        }
        
    }

    function cek_stock(id) {
      var item = document.getElementById("i_item").value;
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>memo/load_data_where_stock/'+id+'/'+item,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_stock").value             = data.val[i].stock_qty;

              
            }
          }
        });
    }

    function cek_nota_qty(id) {
      var item = document.getElementById("i_item").value;
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>memo/load_data_where_nota_qty/'+id+'/'+item,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_nota_qty").value             = data.val[i].total;

              
            }
          }
        });
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

      function reset2(){
        $('input[name="i_id"]').val("");
        $('input[name="i_lock"]').val("");
        $('input[name="i_date"]').val("");
        $('#i_sales option').remove();
        $('#i_customer option').remove();
        search_data_detail(0);
        document.getElementById("lock").style.display='block';
        document.getElementById("lock_button").style.display='none';
        document.getElementById("approve").style.display='none';
        document.getElementById("request").style.display='none';
      }

      

      function reset3(){
        $('input[name="i_detail_id"]').val("");
        $('#i_item option').remove();
        $('#i_item_detail option').remove();
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_stock"]').val("");
        $('input[name="i_nota_qty"]').val("");
      }

      function cek_password(value,menu_id){
        var id = document.getElementById("i_id").value;
        $.ajax({
                url: '<?php echo base_url();?>keyword/cek_password',
                data: {value:value,menu_id:menu_id,id:id},
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    alert("Password Benar!");
                    edit_data(id);
                    $('#myModal').modal('hide');
                  }else{
                    alert("Password Salah!")
                  }
                }
            });
      }
</script>
</body>
</html>