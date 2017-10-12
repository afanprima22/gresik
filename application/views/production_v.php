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
                                <th>Tanggal Produksi</th>
                                <th>Mesin</th>
                                <th>Kode Produksi</th>
                                <th>Kode Mixer</th>
                                <th>Barang</th>
                                <th>Warna</th>
                                <th>Operator</th>
                                <th>Shift</th>
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
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="" >
                            <input type="hidden" name="i_lock" id="i_lock">
                            <label>Pilih production :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_production(1)" name="i_type" id="inlineRadio2" value="option2"> Barang Jadi
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_production(2)" name="i_type" id="inlineRadio3" value="option3"> Barang Setengah jadi
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
                              <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;" onchange="get_mixer()">
                              </select>
                            </div>
                          <div class="form-group">
                            <label>Operator</label>
                            <select class="form-control select2" name="i_operator" id="i_operator" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Mixer</label>
                            <select id="selectmixer" class="form-control select2" style="width: 100%;" name="i_mixer[]">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Mesin</label>
                            <select class="form-control select2" name="i_machine" id="i_machine" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Berat Rata-Rata</label>
                            <input type="number" class="form-control" name="i_weight" id="i_weight" placeholder="Masukkan Berat Rata-Rata" required="required" value="">
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Produksi</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Produksi" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Cycle Time</label>
                            <input type="number" class="form-control" name="i_cycle" id="i_cycle" placeholder="Masukkan Cycle Time" required="required" value="" onchange="generate_cycle(this.value)">
                          </div>
                          <div class="form-group">
                            <label>Target / Jam</label>
                            <input readonly="" type="text" class="form-control" name="i_hour" id="i_hour" placeholder="Masukkan Target / Jam"  value="">
                          </div>
                          <div class="form-group">
                            <label>Target / Shift</label>
                            <input readonly="" type="text" class="form-control" name="i_sift" id="i_sift" placeholder="Masukkan Target / SHift"  value="">
                          </div>
                          <div class="form-group">
                            <label>Shift</label>
                            <select id="i_sift_id" class="form-control select2" style="width: 100%;" name="i_sift_id" required></select>
                          </div>

                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Hasil</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty" placeholder="Masukkan Qty">
                                        <input type="hidden" class="form-control" name="i_detail_id">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_bs" placeholder="Masukkan BS">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_gr" placeholder="Masukkan GR">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_gs" placeholder="Masukkan GS">
                                      </td>
                                      <td>
                                        <div class="bootstrap-timepicker">
                                          <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="i_time1">
                                            <div class="input-group-addon">
                                              <i class="glyphicon glyphicon-time"></i>
                                            </div>
                                          </div>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="bootstrap-timepicker">
                                          <div class="input-group">
                                            <input type="text" class="form-control timepicker" name="i_time2">
                                            <div class="input-group-addon">
                                              <i class="glyphicon glyphicon-time"></i>
                                            </div>
                                          </div>
                                        </div>
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_detail_desc" placeholder="Masukkan Keterangan" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td width="8%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan</button></td>
                                    </tr>
                                    <tr>
                                      <th>Hasil</th>
                                      <th>BS</th>
                                      <th>GR</th>
                                      <th>GS</th>
                                      <th>Jam Mulai</th>
                                      <th>Jam Selesai</th>
                                      <th>Keterangan</th>
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
                              <h2>List Stiker</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td>
                                        <select id="selectsticker" class="form-control select2" style="width: 100%;" name="i_stiker">
                                      </td>
                                      <td>
                                        <input type="hidden" class="form-control" name="i_detail_id_detail">
                                        <input type="text" class="form-control" name="i_amount" placeholder="Jumlah Stiker" >
                                      </td>
                                      <td width="8%"><div id="save_detail"><button type="button" onclick="save_detail_stiker()" class="btn btn-primary">Simpan</button></div></td>
                                    </tr>
                                    <tr>
                                      <th>Stiker</th>
                                      <th>Jumlah</th>
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
                      <input type="password" class="form-control" name="i_password" id="i_password" placeholder="Masukkan Password" onkeydown="if (event.keyCode == 13) { cek_password(this.value,49); }">
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
        search_data_detail(0);
        search_data_detail_stiker(0);
        select_list_item();
        select_list_item_half();
        select_list_employee();
        select_list_sift();
        get_item();
        get_mixer();
        get_stiker();

        document.getElementById("lock_button").style.display='none';
        document.getElementById("request").style.display='none';
        document.getElementById("approve").style.display='none';
    });

    function type_production(id){

      if (id == 1) {
        document.getElementById('item').style.display = 'block';
        document.getElementById('item_half').style.display = 'none';
      }else{
        document.getElementById('item').style.display = 'none';
        document.getElementById('item_half').style.display = 'block';
      }
      
    }


    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Production/load_data/'
            },
            "columns": [
              {"name": "production_date"},
              {"name": "machine_code"},
              {"name": "production_code"},
              {"name": "mixer_codes"},
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "employee_name"},
              {"name": "production_sift_name"},
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
              url: '<?php echo base_url();?>Production/load_data_detail/'+id
            },
            "columns": [
              {"name": "production_detail_qty"},
              {"name": "production_detail_bs"},
              {"name": "production_detail_gr"},
              {"name": "production_detail_gs"},
              {"name": "production_detail_time1"},
              {"name": "production_detail_time2"},
              {"name": "production_detail_desc"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail_stiker(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Production/load_data_detail_stiker/'+id
            },
            "columns": [
              {"name": "package_name"},
              {"name": "production_detail_stiker_amount"},
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
          url  : '<?php echo base_url();?>production/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
            /*reset2();
              var opt = $('option[value='+data.val[i].production_sift_id +']'),
              html = $("<div>").append(opt.clone()).html();
              html = html.replace(/\>/, ' selected="selected">');
              opt.replaceWith(html);
*/
              document.getElementById("i_id").value            = data.val[i].production_id;
              document.getElementById("i_lock").value            = data.val[i].production_lock;
              document.getElementById("i_cycle").value         = data.val[i].production_cycle;
              document.getElementById("i_weight").value         = data.val[i].production_weight;
              document.getElementById("datepicker").value      = data.val[i].production_date;
              document.getElementById("i_hour").value           = data.val[i].production_target_hour;
              document.getElementById("i_sift").value           = data.val[i].production_target_shift;
              $("#i_machine").append('<option value="'+data.val[i].machine_id+'" selected>'+data.val[i].machine_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');
              $("#i_operator").append('<option value="'+data.val[i].employee_id+'" selected>'+data.val[i].employee_name+'</option>');              
              $("#i_sift_id").append('<option value="'+data.val[i].production_sift_id+'" selected>'+data.val[i].production_sift_name+'</option>');              

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

              for(var j=0; j<data.val[i].mixers.val2.length; j++){
                $("#selectmixer").append('<option value="'+data.val[i].mixers.val2[j].id+'" selected>'+data.val[i].mixers.val2[j].text+'</option>');
              }

              if (data.val[i].production_request == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("approve").style.display='block';
                document.getElementById("save_detail").style.display='none';
              }else if(data.val[i].production_lock == 1) {
                document.getElementById("lock").style.display='none';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='block';
                document.getElementById("save_detail").style.display='none';
              }else if(data.val[i].production_lock == 0){
                document.getElementById("lock").style.display='block';
                document.getElementById("lock_button").style.display='block';
                document.getElementById("approve").style.display='none';
                document.getElementById("request").style.display='none';
                document.getElementById("save_detail").style.display='block';
              }
              
              search_data_detail(data.val[i].production_id);
              search_data_detail_stiker(data.val[i].production_id);

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
          url  : '<?php echo base_url();?>production/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].production_detail_id);
              $('input[name="i_detail_qty"]').val(data.val[i].production_detail_qty);
              $('input[name="i_detail_bs"]').val(data.val[i].production_detail_bs);
              $('input[name="i_detail_gr"]').val(data.val[i].production_detail_gr);
              $('input[name="i_detail_gs"]').val(data.val[i].production_detail_gs);
              $('input[name="i_time1"]').val(data.val[i].production_detail_time1);
              $('input[name="i_time2"]').val(data.val[i].production_detail_time2);
              $('input[name="i_detail_desc"]').val(data.val[i].production_detail_desc);
            }
          }
        });
        }else{
        alert("Maaf data sudah di lock!");
      }
      }

      function edit_data_detail_stiker(id){
        var lock = document.getElementById("i_lock").value;
      if (lock == 0) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>production/load_data_where_detail_stiker/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id_detail"]').val(data.val[i].production_detail_stiker_id);
              $('input[name="i_amount"]').val(data.val[i].production_detail_stiker_amount);
                $("#selectsticker").append('<option value="'+data.val[i].stiker_id+'" selected>'+data.val[i].package_name+'</option>');
              
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
          url  : '<?php echo base_url();?>Production/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              search_data_detail(0);
              search_data_detail_stiker(0);
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
            url  : '<?php echo base_url();?>Production/action_data_detail/',
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

      function save_detail_stiker(){
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
            url  : '<?php echo base_url();?>Production/action_data_detail_stiker/',
            data : $( "#formall" ).serialize(),
            dataType : "json",
            success:function(data){
              if(data.status=='200'){
                reset4();
                search_data_detail_stiker(id_new);
              } 
            }
          });
        }else{
          alert("Maaf data sudah di lock!");
        }
        
      }

      function action_lock(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Production/action_data_lock/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              //alert("berhasil");
              reset2();
              $('[href="#list"]').tab('show');
              document.getElementById("lock_button").style.display='none';
            } 
          }
        });
      }

      function action_request(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Production/action_data_request/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              $('[name="i_lock"]').val("");
              document.getElementById("lock").style.display='block';
              document.getElementById("lock_button").style.display='block';
              document.getElementById("request").style.display='none';
            } 
          }
        });
      }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>production/delete_data',
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

    function delete_data_detail(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var color_id = document.getElementById("i_item_detail").value;

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>production/delete_data_detail',
                data: {id:id_detail,detail_id:color_id},
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

    function delete_data_detail_stiker(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }


        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>production/delete_data_detail_stiker',
                data: {id:id_detail},
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail_stiker(id_new);
                  }
                }
            });
        }
        
    }

      function reset2(){
        $('#i_machine option').remove();
        $('#i_item option').remove();
        $('#i_item_half option').remove();
        $('#i_operator option').remove();
        $('#i_item_detail option').remove();
        $('#selectmixer option').remove();
        $('#i_sift').val("");
        $('#i_sift_id option').remove();
        $('#i_weight').val("");
        $('#i_id').val("");
        search_data_detail(0);
        search_data_detail_stiker(0);
        document.getElementById("i_lock").value = '';
        //document.getElementById("i_sift_id").value = 0;
      }

      

      function reset4(){
        $('input[name="i_detail_id_detail"]').val("");
        $('input[name="i_amount"]').val("");
        $('#selectsticker option').remove();
      }

      function reset3(){
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_detail_id"]').val("");
        $('input[name="i_detail_bs"]').val("");
        $('input[name="i_detail_gr"]').val("");
        $('input[name="i_detail_gs"]').val("");
        $('input[name="i_time1"]').val("");
        $('input[name="i_time2"]').val("");
        $('input[name="i_detail_desc"]').val("");
        $('#selectsticker option').remove();
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

      function select_list_sift() {
        $('#i_sift_id').select2({
          placeholder: 'Pilih sift',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Production/load_data_select_sift/',
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

      function select_list_employee() {
        $('#i_operator').select2({
          placeholder: 'Pilih Operator',
          multiple: false,
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

      function get_mixer() {
        var id = document.getElementById("i_item_detail").value;

        $('#selectmixer').select2({
          placeholder: 'Pilih Mixer',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Mixer/load_data_select_mixer/'+id,
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
      function get_stiker() {
        $('#selectsticker').select2({
          placeholder: 'Pilih Stiker',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Production/load_data_select_stiker/',
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



      function generate_cycle(value){
        var second = 3600;
        var hour = second / value;
        var sift = hour * 8;

        document.getElementById("i_hour").value           = hour;
        document.getElementById("i_sift").value           = sift;
      }

      function action_lock(){
      var id = document.getElementById("i_id").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Production/action_data_lock/',
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
          url  : '<?php echo base_url();?>Production/action_data_request/',
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