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
                                <th>Mesin/Kendaraan</th>
                                <th>Tanggal Servis</th>
                                <th>Ongkos</th>
                                <th>Keterangan</th>
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
                          <!--<div class="form-group">
                            <label>Pilih Servis :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_service(1)" name="i_type" id="inlineRadio2" value="option2"> Mesin
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_service(2)" name="i_type" id="inlineRadio3" value="option3"> Kendaraan
                            </label>
                          </div>-->
                          <div class="form-group" id="machine">
                            <label>Mesin</label>
                            <select class="form-control select2" name="i_machine" id="i_machine" style="width: 100%;" >
                            </select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group" id="vehicle"  style="display: none;">
                            <label>Kendaraan</label>
                            <select class="form-control select2" name="i_vehicle" id="i_vehicle" style="width: 100%;" >
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Servis</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Servis" value="" required="required">
                            </div>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Ongkos</label>
                            <input type="text" class="form-control money" name="i_nominal" id="i_nominal" placeholder="Masukkan Ongkos" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Keterangan" name="i_desc" id="i_desc"></textarea>
                          </div>
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Onderdil</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_detail_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_sperpart" id="i_sperpart" style="width: 100%;" >
                                        </select>
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_detail" placeholder="Masukkan Qty Pemakaian" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Warna</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Sperpart</th>
                                      <th>Qty Pemakaian</th>
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
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
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
        select_list_machine();
        search_data_detail(0);
        select_list_vehicle();
        select_list_sperpart();
    });

    function type_service(id){

    if (id == 1) {
      document.getElementById('machine').style.display = 'block';
      document.getElementById('vehicle').style.display = 'none';
    }else{
      document.getElementById('machine').style.display = 'none';
      document.getElementById('vehicle').style.display = 'block';
    }
    
    $('select[name="i_machine"]').val(0);
    $('select[name="i_vehicle"]').val(0);

  }

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Service_macine/load_data/'
            },
            "columns": [
              {"name": "service_nominal"},
              {"name": "service_date"},
              {"name": "service_nominal"},
              {"name": "service_desc"},
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
              url: '<?php echo base_url();?>Service_macine/load_data_detail/'+id
            },
            "columns": [
              {"name": "service_detail_id"},
              {"name": "sperpart_name"},
              {"name": "service_detail_qty"},
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
          url  : '<?php echo base_url();?>Service_macine/action_data/',
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
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Service_macine/delete_data',
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
          url  : '<?php echo base_url();?>Service_macine/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].service_id;
              document.getElementById("i_nominal").value        = data.val[i].service_nominal;
              document.getElementById("datepicker").value       = data.val[i].service_date;
              document.getElementById("i_desc").value           = data.val[i].service_desc;

              if (data.val[i].vehicle_id) {
                $("#i_vehicle").append('<option value="'+data.val[i].vehicle_id+'" selected>'+data.val[i].vehicle_name+'</option>');
                document.getElementById('machine').style.display = 'none';
                document.getElementById('vehicle').style.display = 'block';
                document.getElementById("inlineRadio3").checked = true;
              }

              if (data.val[i].machine_id) {
                $("#i_machine").append('<option value="'+data.val[i].machine_id+'" selected>'+data.val[i].machine_name+'</option>');
                document.getElementById('machine').style.display = 'block';
                document.getElementById('vehicle').style.display = 'none';
                document.getElementById("inlineRadio2").checked = true;
              }
              
              search_data_detail(data.val[i].service_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

      function reset2(){
        $('#i_machine option').remove();
        $('#i_vehicle option').remove();
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
          url  : '<?php echo base_url();?>Service_macine/action_data_detail/',
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
        $('#i_sperpart option').remove();
        $('input[name="i_qty_detail"]').val("");
        $('input[name="i_detail_id"]').val("");
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Service_macine/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $("#i_sperpart").append('<option value="'+data.val[i].sperpart_id+'" selected>'+data.val[i].sperpart_name+'</option>');
              $('input[name="i_qty_detail"]').val(data.val[i].service_detail_qty);
              $('input[name="i_detail_id"]').val(data.val[i].service_detail_id);

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
                url: '<?php echo base_url();?>Service_macine/delete_data_detail',
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

    function select_list_vehicle() {
        $('#i_vehicle').select2({
          placeholder: 'Pilih Kendaraan',
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

      function select_list_sperpart() {
        $('#i_sperpart').select2({
          placeholder: 'Pilih Onderdil',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Sperpart/load_data_select_sperpart/',
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