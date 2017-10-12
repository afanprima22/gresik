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
                                <th>Kode Packaging</th>
                                <th>Pegawai</th>
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
                            <label>Pegawai</label>
                            <select class="form-control select2" name="i_employee[]" id="i_employee" style="width: 100%;" required="required">
                            </select>
                            <input type="hidden" name="i_lock" id="i_lock" value="">
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <!--<div class="form-group">
                            <label>Pilih packaging :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_packaging(1)" name="i_type" id="inlineRadio2" value="option2"> Barang Jadi
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_packaging(2)" name="i_type" id="inlineRadio3" value="option3"> Barang Setengah jadi
                            </label>
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
                            <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;" onchange="get_stock(this.value)">
                              </select>
                          </div>
                          <div class="form-group">
                            <label>Stock Gudang Produksi</label>
                            <input type="text" class="form-control" name="i_stock" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Jumlah Isi per Dos</label>
                            <input type="number" class="form-control" name="i_dos" id="i_dos" value="" placeholder="Masukkan Isi per Dos">
                          </div>-->
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Packaging</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Packaging" value="" required="required">
                            </div>
                          </div>
                          <!--<div class="form-group">
                            <label>Jumlah Dos Masuk Gudang</label>
                            <input type="number" class="form-control" name="i_dos_qty" id="i_dos_qty" value="" placeholder="Masukkan Jumlah Dos">
                          </div>
                          <div class="form-group">
                            <label>Jumlah Eceran Masuk Gudang</label>
                            <input type="number" class="form-control" name="i_retail" id="i_retail" value="" placeholder="Masukkan Jumlah Eceran">
                          </div>-->
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data_item">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td colspan="6">
                                        <div class="form-group">
                                          <label>Pilih Packaging :</label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_packaging(1)" name="i_type" id="inlineRadio1" value="1"> Barang jadi
                                          </label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_packaging(2)" name="i_type" id="inlineRadio2" value="2"> Barang Set jadi
                                          </label>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="10%"><input type="text" class="form-control" name="i_detail_item_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <div class="col-md-6">
                                          <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                                          </select>
                                        </div>
                                        <div class="col-md-6">
                                          <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;" onchange="get_stock(this.value)">
                                          </select>
                                        </div>
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_per_dos" placeholder="Qty Yang Dipakai" >
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_dos" placeholder="Qty Dos" >
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_retail" placeholder="Qty Eceran" >
                                      </td>
                                      <td width="10%"><div id="save_detail"><button type="button" onclick="save_detail_item()" class="btn btn-primary">Simpan Detail</button></div></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Barang - Warna</th>
                                      <th>Qty Yang dipakai</th>
                                      <th>Dos</th>
                                      <th>Eceran</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Paket</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_detail_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_package" id="i_package" style="width: 100%;">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_detail" placeholder="Masukkan Qty Pemakaian" >
                                      </td>
                                      <td width="10%"><div id="save_detail2"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Paket</button></div></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Paket</th>
                                      <th>Qty</th>
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
                      <input type="password" class="form-control" name="i_password" id="i_password" placeholder="Masukkan Password" onkeydown="if (event.keyCode == 13) { cek_password(this.value,51); }">
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
        select_list_employee();
        search_data_detail(0);
        search_data_detail_item(0);
       // select_list_item();
        //select_list_item_half();
        select_list_package();

        document.getElementById("lock_button").style.display='none';
        document.getElementById("request").style.display='none';
        document.getElementById("approve").style.display='none';
    });

    function type_packaging(id){

     select_list_item_type(id);
      
    }


    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Packaging/load_data/'
            },
            "columns": [
              {"name": "packaging_code"},
              {"name": "employee_names"},
              {"name": "packaging_date"},
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
              url: '<?php echo base_url();?>Packaging/load_data_detail/'+id
            },
            "columns": [
              {"name": "packaging_detail_id"},
              {"name": "package_name"},
              {"name": "packaging_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail_item(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Packaging/load_data_detail_item/'+id
            },
            "columns": [
              {"name": "packaging_detail_item_id"},
              {"name": "item_name"},
              {"name": "packaging_box"},
              {"name": "packaging_box_qty"},
              {"name": "packaging_retail"},
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
      var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
      if (lock == 0) {
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Packaging/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              search_data_detail(0);
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

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>packaging/delete_data',
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
          url  : '<?php echo base_url();?>packaging/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value            = data.val[i].packaging_id;
              document.getElementById("datepicker").value      = data.val[i].packaging_date;
              document.getElementById("i_lock").value          = data.val[i].packaging_lock;

              for(var j=0; j<data.val[i].employees.val2.length; j++){
                $("#i_employee").append('<option value="'+data.val[i].employees.val2[j].id+'" selected>'+data.val[i].employees.val2[j].text+'</option>');
              }
              /*document.getElementById("i_dos").value           = data.val[i].packaging_box;
              document.getElementById("i_dos_qty").value       = data.val[i].packaging_box_qty;
              document.getElementById("i_retail").value        = data.val[i].packaging_retail;*/
              //$("#i_employee").append('<option value="'+data.val[i].employee_id+'" selected>'+data.val[i].employee_name+'</option>');
              /*$("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');

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
              }*/
              
              search_data_detail(data.val[i].packaging_id);
              search_data_detail_item(data.val[i].packaging_id);

              if (data.val[i].packaging_request == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("approve").style.display='block';
                document.getElementById("save_detail").style.display='none';
                document.getElementById("save_detail2").style.display='none';
              }else if(data.val[i].packaging_lock == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='block';
                document.getElementById("save_detail").style.display='none';
                document.getElementById("save_detail2").style.display='none';
              }else if(data.val[i].packaging_lock == 0){
                document.getElementById("lock").style.display='block';
                document.getElementById("lock_button").style.display='block';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("save_detail").style.display='block';
                document.getElementById("save_detail2").style.display='block';
              }
            }
            
          }
        });

        $('[href="#form"]').tab('show');
    }

    

    /*function show_data(){
        $('#inlineRadio1').prop('disabled', false);
        $('#inlineRadio2').prop('disabled', false);
        $('#i_item').prop('disabled', false);
        $('#i_item_detail').prop('disabled', false);
        $('input[name="i_qty_per_dos"]').prop('readonly', false);
        $('input[name="i_qty_dos"]').prop('readonly', false);
        $('input[name="i_qty_retail"]').prop('readonly', false);

        $('#i_package').prop('disabled', false);
        $('input[name="i_qty_detail"]').prop('readonly', false);
        document.getElementById('show').style.display = 'block';
        document.getElementById('approved').style.display = 'none';
    }*/

      function reset2(){
        $('#i_package option').remove();
        $('#i_employee option').remove();
        $('input[name="i_lock"]').val("");
        $('#i_item option').remove();
        $('#i_item_half option').remove();
        $('#i_item_detail option').remove();
        search_data_detail(0);
        search_data_detail_item(0);
        document.getElementById("lock").style.display='block';
            document.getElementById("request").style.display='none';
      }

      function save_detail(){
        var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
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
          url  : '<?php echo base_url();?>packaging/action_data_detail/',
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

      function reset3(){
        $('#i_package option').remove();
        $('input[name="i_qty_detail"]').val("");
        $('input[name="i_detail_id"]').val("");
      }

      function edit_data_detail(id){
        var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
      if (lock == 0) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>packaging/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $("#i_package").append('<option value="'+data.val[i].package_id+'" selected>'+data.val[i].package_name+'</option>');
              $('input[name="i_qty_detail"]').val(data.val[i].packaging_detail_qty);
              $('input[name="i_detail_id"]').val(data.val[i].packaging_detail_id);

            }
          }
        });
        }else{
        alert("Maaf data sudah di lock!");
      }
      }

      function delete_data_detail(id_detail) {
        var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
      if (lock == 0) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>packaging/delete_data_detail',
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

      function save_detail_item(){
        var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
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
          url  : '<?php echo base_url();?>Packaging/action_data_detail_item/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_detail_item(id_new);
            } 
          }
        });
        }else{
        alert("Maaf data sudah di lock!");
      }
      }

      function reset4(){
        $('#i_item option').remove();
        $('#i_item_detail option').remove();
        $('input[name="i_qty_per_dos"]').val("");
        $('input[name="i_qty_dos"]').val("");
        $('input[name="i_qty_retail"]').val("");
        $('input[name="i_detail_item_id"]').val("");
      }

      function reset5(){
        $('input[name="i_lock"]').val("");
        document.getElementById("lock").style.display='block';
        document.getElementById("request").style.display='none';
      }

      function edit_data_detail_item(id){
        var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
      if (lock == 0) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Packaging/load_data_where_detail_item/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');
              $('input[name="i_qty_per_dos"]').val(data.val[i].packaging_box);
              $('input[name="i_qty_dos"]').val(data.val[i].packaging_box_qty);
              $('input[name="i_qty_retail"]').val(data.val[i].packaging_retail);
              $('input[name="i_detail_item_id"]').val(data.val[i].packaging_detail_item_id);

            }
          }
        });
        }else{
        alert("Maaf data sudah di lock!");
      }
      }

      function delete_data_detail_item(id_detail) {
        var lock = document.getElementById("i_lock").value;
      if (!lock) {
        var lock=0;
      };
      if (lock == 0) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Packaging/delete_data_detail_item',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail_item(id_new);
                  }
                }
            });
        }
        }else{
        alert("Maaf data sudah di lock!");
      }
        
      }

      function select_list_employee() {
        $('#i_employee').select2({
          placeholder: 'Pilih Pegawai',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Employee/load_data_select_employee/',
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

      function select_list_item_type(id) {
        $('#i_item').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item_type/'+id,
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

      function select_list_package() {
        $('#i_package').select2({
          placeholder: 'Pilih Paket',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Package/load_data_select_package/',
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

      function get_stock(id){
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url();?>Packaging/read_stock/',
          data: {id:id},
          dataType: 'json',
          success: function(data){
            $('input[name="i_stock"]').val(data.stock);
          } 
        });
      }

      function action_lock(){
      var id = document.getElementById("i_id").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Packaging/action_data_lock/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
                edit_data(id);
            } 
          }
        });
      }

      function action_request(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Packaging/action_data_request/',
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