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
                            <div class="box-footer text-right"><a href="#myModal2" onclick="" class="btn btn-warning btn-md" data-toggle="modal" ><i class="glyphicon glyphicon-print"></i></a></div>
                            <tr>
                                <th>Kode Mixer</th>
                                <th>Mesin</th>
                                <th>Barang</th>
                                <th>Warna</th>
                                <th>Qty</th>
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
                          <input type="hidden" name="i_lock" id="i_lock" value="">
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="" >
                            <label>Pilih Mixer :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_mixer(1)" name="i_type" id="inlineRadio2" value="option2"> Barang Jadi
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_mixer(2)" name="i_type" id="inlineRadio3" value="option3"> Barang Setengah jadi
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_mixer(3)" name="i_type" id="inlineRadio4" value="option3"> Order
                            </label>
                          </div>
                          <div id="order" style="display: none;">
                            <div class="form-group" >
                              <label>Kode Order Produksi</label>
                              <select class="form-control select2" name="i_order" id="i_order" style="width: 100%;" onchange="get_order(this.value)">
                              </select>
                            </div>
                          </div>
                          <div id="item" style="display: none;">
                            <div class="form-group" >
                              <label>Barang Jadi</label>
                              <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                              </select>
                            </div>
                          </div>
                          <div id="item_half" style="display: none;">
                            <div class="form-group" >
                              <label>Barang Setengah Jadi</label>
                              <select class="form-control select2" name="i_item_half" id="i_item_half" style="width: 100%;" onchange="get_item(this.value)">
                              </select>
                            </div>
                          </div>
                          <div class="form-group" >
                              <label>Warna</label>
                              <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;">
                              </select>
                            </div>
                          <div class="form-group">
                            <label>Total Berat Bahan</label>
                            <input type="text" class="form-control" name="i_total" id="i_total" readonly="" value="">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Mesin</label>
                            <select class="form-control select2" name="i_machine" id="i_machine" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Mixer</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Mixer" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" name="i_qty" id="i_qty" placeholder="Masukkan Jumlah" required="required" value="">
                          </div>
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Onderdil</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr id="det">
                                      <td><input type="text" class="form-control" name="i_detail_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_material" id="i_material" style="width: 100%;">
                                        </select>
                                      </td>
                                      <td></td>
                                      <td></td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_detail" placeholder="Masukkan Qty Pemakaian" >
                                      </td>
                                      <td width="10%"><div id="save_detail"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></div></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Material</th>
                                      <th>Rumus</th>
                                      <th>Diperlukan</th>
                                      <th>Diproduksi</th>
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
                      <div id="lock" class="box-footer text-right">
                        <button type="button" id="lock_button" style="float: left;" onclick="action_lock()" class="btn btn-info">Lock</button>
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>
                      <div id="request" class="box-footer text-right">
                      <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="button" onclick="action_request()" class="btn btn-primary">Request</button>
                      </div>
                      <div id="approve" class="box-footer text-right">
                        <a href="#myModal3" class="btn btn-info" data-toggle="modal">Approve</a>
                        <button type="button" class="btn btn-warning" >Denied</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>
        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 70%;">
          <form id="formalls" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4>Add Detail</h4><input type="hidden" class="form-control" name="i_id_new" id="i_id_new" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                        <div class="box-content">
                          <div class="row">
                            <div class="col-md-6">
                                 <input type="hidden" class="form-control" name="i_detail_id_new" placeholder="Auto" readonly="">
                                <div class="form-group">
                                  <label>Nama Material</label>
                                  <select class="form-control select2" name="i_material2" id="i_material2" style="width: 100%;" onkeydown="if (event.keyCode == 13) { save_detail(); }"></select>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label>Diproduksi</label>
                                 <input type="number" class="form-control" name="i_qty_material" placeholder="Masukkan Qty Pemakaian" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button"  onclick="save_material()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
          </form>
          </div>
      </div>

      <div style="padding-top: 50px;" class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 40%;">
          <form id="formalls" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4>Print</h4><input type="hidden" class="form-control" name="i_id_new" id="i_id_new" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                        <div class="box-content">
                          <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                            <label>Tanggal Mixer</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_print" placeholder="Tanggal Mixer" value="" required="required">
                            </div>
                          </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button"  onclick="print_pdf()" class="btn btn-primary">Print</button>
                </div>
            </div>
          </form>
          </div>
      </div>

      <div style="padding-top: 50px;" class="modal fade" id="myModal3" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 30%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-body">
                      <input type="password" class="form-control" name="i_password" id="i_password" placeholder="Masukkan Password" onkeydown="if (event.keyCode == 13) { cek_password(this.value,48); }">
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
        select_list_machine();
        //search_data_detail(0);
        select_list_item();
        select_list_item_half();
        select_list_order();
        select_list_material();
        select_list_material2();

        document.getElementById("lock_button").style.display='none';
        document.getElementById("request").style.display='none';
        document.getElementById("approve").style.display='none';
    });

    function type_mixer(id){

      if (id == 1) {
        document.getElementById('item').style.display = 'block';
        document.getElementById('item_half').style.display = 'none';
        document.getElementById('order').style.display = 'none';
      }else if(id == 2){
        document.getElementById('item').style.display = 'none';
        document.getElementById('item_half').style.display = 'block';
        document.getElementById('order').style.display = 'none';
      }else{
        document.getElementById('item').style.display = 'none';
        document.getElementById('item_half').style.display = 'none';
        document.getElementById('order').style.display = 'block';
      }
      
    }


    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Mixer/load_data/'
            },
            "columns": [
              {"name": "mixer_code"},
              {"name": "machine_name"},
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "mixer_qty"},
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
              url: '<?php echo base_url();?>Mixer/load_data_detail/'+id
            },
            "columns": [
              {"name": "mixer_detail_id"},
              {"name": "material_name"},
              {"name": "item_formula_qty"},
              {"name": "mixer_detail_qty"},
              {"name": "mixer_detail_production"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
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
          url  : '<?php echo base_url();?>Mixer/action_data/',
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
                url: '<?php echo base_url();?>mixer/delete_data',
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
          url  : '<?php echo base_url();?>mixer/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value            = data.val[i].mixer_id;
              document.getElementById("i_total").value         = data.val[i].mixer_total;
              document.getElementById("datepicker").value      = data.val[i].mixer_date;
              document.getElementById("i_qty").value           = data.val[i].mixer_qty;
              document.getElementById("i_lock").value           = data.val[i].mixer_lock;
              $("#i_machine").append('<option value="'+data.val[i].machine_id+'" selected>'+data.val[i].machine_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');
              
              if (data.val[i].item_status == 1) {
                $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'block';
                document.getElementById('item_half').style.display = 'none';
                document.getElementById("inlineRadio2").checked = true;
              }

              if (data.val[i].item_status == 2) {
                $("#i_item_half").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'none';
                document.getElementById('item_half').style.display = 'block';
                document.getElementById("inlineRadio3").checked = true;
              }

              if (data.val[i].order_production_id != 0) {
                $("#i_order").append('<option value="'+data.val[i].order_production_id+'" selected>'+data.val[i].order_production_code+'</option>');
                document.getElementById('order').style.display = 'block';
                document.getElementById("inlineRadio4").checked = true;
              }
              
              search_data_detail(data.val[i].mixer_id);
              document.getElementById('detail_data').style.display = 'block';

              if (data.val[i].mixer_request == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("approve").style.display='block';
                document.getElementById("save_detail").style.display='none';
              }else if(data.val[i].mixer_lock == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='block';
                document.getElementById("save_detail").style.display='none';
              }else if(data.val[i].mixer_lock == 0){
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

    function request_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>mixer/load_data_where_request/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value            = data.val[i].mixer_id;
              document.getElementById("i_total").value         = data.val[i].mixer_total;
              document.getElementById("datepicker").value      = data.val[i].mixer_date;
              document.getElementById("i_qty").value           = data.val[i].mixer_qty;
              document.getElementById("approve").value           = data.val[i].mixer_id;
              document.getElementById("i_lock").value           = data.val[i].mixer_lock;
              $("#i_machine").append('<option value="'+data.val[i].machine_id+'" selected>'+data.val[i].machine_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');
              document.getElementById('lock').style.display = 'none';
              document.getElementById('show').style.display = 'none';
              document.getElementById('add').style.display = 'none';
              document.getElementById('request').style.display = 'block';

              if (data.val[i].item_status == 1) {
                $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'block';
                document.getElementById('item_half').style.display = 'none';
                document.getElementById("inlineRadio2").checked = true;
              }

              if (data.val[i].item_status == 2) {
                $("#i_item_half").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'none';
                document.getElementById('item_half').style.display = 'block';
                document.getElementById("inlineRadio3").checked = true;
              }

              if (data.val[i].order_production_id != 0) {
                $("#i_order").append('<option value="'+data.val[i].order_production_id+'" selected>'+data.val[i].order_production_code+'</option>');
                document.getElementById('order').style.display = 'block';
                document.getElementById("inlineRadio4").checked = true;
              }
              
              search_data_detail(data.val[i].mixer_id);

              document.getElementById('detail_data').style.display = 'block';
               
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

      function reset2(){
        document.getElementById("inlineRadio4").checked = false;
        document.getElementById("inlineRadio3").checked = false;
        document.getElementById("inlineRadio2").checked = false;
        $('#i_machine option').remove();
        $('#i_item option').remove();
        $('#i_item_half option').remove();
        $('#i_item_detail option').remove();
        $('#i_order option').remove();
        $('input[name="i_qty"]').val("");
        $('input[name="i_total"]').val("");
        $('input[name="i_date"]').val("");
        $('input[name="i_id"]').val("");
        $('input[name="i_lock"]').val("");

        search_data_detail(0);
      }
     
      function save_detail(){
        var lock = document.getElementById("i_lock").value;
      if (lock == 0) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>mixer/action_data_detail/',
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

      function save_material(){
        
        var id = document.getElementById("i_id_new").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>mixer/action_data_material/',
          data : $( "#formalls" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_detail(id_new);
              $('#myModal').modal('hide');
            } 
          }
        });
        
      }

      function reset3(){
        $('#i_material option').remove();
        $('input[name="i_qty_detail"]').val("");
        $('input[name="i_detail_id"]').val("");
      }
      function reset4(){
        $('#i_material2 option').remove();
        $('input[name="i_qty_material"]').val("");
        $('input[name="i_detail_id_new"]').val("");
      }

      function edit_data_detail(id){
        var lock = document.getElementById("i_lock").value;
      if (lock == 0) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>mixer/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $("#i_material").append('<option value="'+data.val[i].material_id+'" selected>'+data.val[i].material_name+'</option>');
              $('input[name="i_qty_detail"]').val(data.val[i].mixer_detail_production);
              $('input[name="i_detail_id"]').val(data.val[i].mixer_detail_id);

            }
          }
        });
        }else{
        alert("Maaf data sudah di lock!");
      }
      }

      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        var lock = document.getElementById("i_lock").value;
      if (lock == 0) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>mixer/delete_data_detail',
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
        }else{
        alert("Maaf data sudah di lock!");
      }
        
    }

      function select_list_machine() {
        $('#i_machine').select2({
          placeholder: 'Pilih Mesin',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Machine/load_data_select_machine/',
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

      function select_list_item_half() {
        $('#i_item_half').select2({
          placeholder: 'Pilih Barang Setengah Jadi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item_half/load_data_select_item_half/',
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

      function select_list_material() {
        $('#i_material').select2({
          placeholder: 'Pilih Material',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Material/load_data_select_material/',
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

      function select_list_material2(){
        $('#i_material2').select2({
          placeholder: 'Pilih Material',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Material/load_data_select_material/',
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

      function select_list_order() {
        $('#i_order').select2({
          placeholder: 'Pilih Kode Order',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>order_production/load_data_select_order_production/',
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

      function get_order(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>mixer/get_order/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');

              if (data.val[i].item_status == 1) {
                $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'block';
                document.getElementById('item_half').style.display = 'none';
              }

              if (data.val[i].item_status == 2) {
                $("#i_item_half").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'none';
                document.getElementById('item_half').style.display = 'block';
              }

              document.getElementById("i_qty").value           = data.val[i].order_production_qty;

            }
          }
        });
      }

      /*function lock_form(){
        var material_id = $('input[name="i_id"]').val();
        $('#inlineRadio2').prop('disabled', true);
        $('#inlineRadio3').prop('disabled', true);
        $('#inlineRadio4').prop('disabled', true);
        $('#i_order').prop('disabled', true);
        $('#i_machine').prop('disabled', true);
        $('#i_item').prop('disabled', true);
        $('#i_item_half').prop('disabled', true);
        $('#i_item_detail').prop('disabled', true);
        $('#i_sperpart').prop('disabled', true);
        $('input[name="i_date"]').prop('readonly', true);
        $('input[name="i_qty"]').prop('readonly', true);
        $('#edit').prop('disabled', true);
        $('#hapus').prop('disabled', true);
        $("#det").hide();
        document.getElementById('show').style.display = 'none';
        document.getElementById('lock').style.display = 'none';
        document.getElementById('add').style.display = 'block';
        search_data_detail(material_id);
      }*/

      function action_lock(){
        var id = document.getElementById("i_id").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Mixer/action_data_lock/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              //alert("berhasil");
              /*reset2();
              $('[href="#list"]').tab('show');

              document.getElementById("lock_button").style.display='none';*/
              edit_data(id);
            } 
          }
        });
      }
      function cek_data(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>mixer/cek_data_mixer/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_lock"]').val(data.val[i].mixer_lock);

            }
          }
        });
      }

      function cek () {
        var material_id = $('input[name="i_id"]').val();
        $('input[name="i_id_new"]').val(material_id);
      }

      function action_request(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Mixer/action_data_request/',
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

      function approve_data(id){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>mixer/action_data_approve/'+id,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data();
             
            } 
          }
        });
      }

      function print_pdf(){
        var id = document.getElementById("datepicker2").value;
        $('#myModal2').modal('hide');
        $('input[name="i_date_print"]').val("");
        window.open('<?php echo base_url();?>Mixer/print_mixer_pdf?id='+id);
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
                    $('#myModal3').modal('hide');
                  }else{
                    alert("Password Salah!")
                  }
                }
            });
      }

</script>
</body>
</html>