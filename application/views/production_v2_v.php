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
                                <th>Kode Produksi</th>
                                <th>Shift</th>
                                <th>Tanggal Produksi</th>
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
                            <label>Shift</label>
                            <select class="form-control select2" name="i_sift" id="i_sift" style="width: 100%;" required="required" >
                            </select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id"  value="" >
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
                                      <td colspan="7">
                                        <div class="form-group">
                                          <label>Pilih Produksi :</label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_detail(1)" name="i_type" id="inlineRadio1" value="1"> Barang jadi
                                          </label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_detail(2)" name="i_type" id="inlineRadio2" value="2"> Barang Set jadi
                                          </label>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_detail_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_operator" id="i_operator" style="width: 100%;" >
                                        </select>
                                      </td>
                                      <td>
                                        <div id="item">
                                          <div class="col-md-6">
                                            <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                                            </select>
                                          </div>
                                          <div class="col-md-6" >
                                            <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;">
                                            </select>
                                          </div>
                                        </div>
                                      </td>
                                      <td><input type="number" class="form-control" name="i_detail_cycle" placeholder="Masukkan Cycle Time" onkeydown="if (event.keyCode == 13) { save_detail(); }" onchange="generate_cycle(this.value)"></td>
                                      <td><input readonly="" type="text" class="form-control" name="i_detail_hour" id="i_detail_hour" placeholder="Masukkan Target/Jam"></td>
                                      <td>
                                        <input readonly="" type="text" class="form-control" name="i_detail_sift" id="i_detail_sift" placeholder="Masukkan Target/Shift" >
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Operator</th>
                                      <th>Barang - Warna</th>
                                      <th>Cycle Time</th>
                                      <th>Target/Jam</th>
                                      <th>Target/Shift</th>
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
                        <button type="button" onclick="reset(),reset2(),reset3()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>

        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 80%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Detail Rak</h4>
                      <input type="hidden" class="form-control" name="i_detail_id" id="i_detail_id">
                      <input type="hidden" class="form-control" name="i_color_id" id="i_color_id">
                  </div>
                  <div class="modal-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Mesin</label>
                            <select class="form-control select2" name="i_machine" id="i_machine" style="width: 100%;" required="">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Mixer</label>
                            <select id="selectmixer" class="form-control select2" style="width: 100%;" name="i_mixer[]" required="">
                            </select>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group"></div>
                        <div class="box-inner">
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td>
                                        <input type="number" class="form-control" name="i_result_qty" placeholder="Masukkan Qty">
                                        <input type="hidden" class="form-control" name="i_result_id">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_result_bs" placeholder="Masukkan BS">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_result_gs" placeholder="Masukkan GS">
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
                                        <input type="text" class="form-control" name="i_result_desc" placeholder="Masukkan Keterangan" onkeydown="if (event.keyCode == 13) { save_result(); }">
                                      </td>
                                      <td width="8%"><button type="button" onclick="save_result()" class="btn btn-primary">Simpan</button></td>
                                    </tr>
                                    <tr>
                                      <th>Hasil</th>
                                      <th>BS</th>
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
                  <div class="modal-footer">
                      
                      <button type="submit" class="btn btn-warning">Selesai</button>
                      <!--<a href="#" class="btn btn-warning" data-dismiss="modal">Selesai</a>
                      <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Save changes</a>-->
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
      //alert("test");
        search_data();
        search_data_detail(0);
        select_list_sift();
        select_list_employee();
        select_list_machine();
        get_mixer(0);
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function type_detail(id){
        
      select_list_item_type(id);
      $('select[name="i_item"]').val(0);
      $('select[name="i_item_detail"]').val(0);

  }

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>production_v2/load_data/'
            },
            "columns": [
              {"name": "production_new_code"},
              {"name": "production_sift_name"},
              {"name": "production_new_date"},
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
              url: '<?php echo base_url();?>production_v2/load_data_detail/'+id
            },
            "columns": [
              {"name": "production_id"},
              {"name": "employee_name"},
              {"name": "item_name"},
              {"name": "production_cycle"},
              {"name": "production_target_hour"},
              {"name": "production_target_shift"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_result(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>production_v2/load_data_result/'+id
            },
            "columns": [
              {"name": "production_detail_qty"},
              {"name": "production_detail_bs"},
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

        document.getElementById("i_detail_id").value             = id;
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>production_v2/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset2();
            for(var i=0; i<data.val.length;i++){
              
              document.getElementById("i_color_id").value             = data.val[i].item_detail_id;

              if (data.val[i].machine_id) {
                $("#i_machine").append('<option value="'+data.val[i].machine_id+'" selected>'+data.val[i].machine_name+'</option>');
              }

              if (data.val[i].mixers.val2.length == 0) {
                for(var j=0; j<data.val[i].mixers.val2.length; j++){
                  $("#selectmixer").append('<option value="'+data.val[i].mixers.val2[j].id+'" selected>'+data.val[i].mixers.val2[j].text+'</option>');
                }
              }else{
                get_mixer(data.val[i].item_detail_id);
              }
              

            }
          }
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
          url  : '<?php echo base_url();?>production_v2/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              reset3();
              search_data();
              search_data_detail(0);
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
                url: '<?php echo base_url();?>production_v2/delete_data',
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
          url  : '<?php echo base_url();?>production_v2/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].production_new_id;
              document.getElementById("datepicker").value           = data.val[i].production_new_date;
              $("#i_sift").append('<option value="'+data.val[i].production_sift_id+'" selected>'+data.val[i].production_sift_name+'</option>');
              search_data_detail(data.val[i].production_new_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }      

      function select_list_item_type(id) {
        $('#i_item').select2({
          placeholder: 'Pilih Barang Jadi',
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

      function select_list_sift() {
        $('#i_sift').select2({
          placeholder: 'Pilih Sift',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>production_v2/load_data_select_sift',
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

      function get_mixer(id) {
        //var id = document.getElementById("i_item_detail").value;

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


      function reset2(){
        $('#i_partner option').remove();
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
          url  : '<?php echo base_url();?>production_v2/action_data_detail/',
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
        $('#i_operator option').remove();
        $('input[name="i_detail_cycle"]').val("");
        $('input[name="i_detail_hour"]').val("");
        $('input[name="i_detail_sift"]').val("");

        search_data_detail(0);
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>production_v2/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            //reset3();
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].production_id);
              $('input[name="i_detail_cycle"]').val(data.val[i].production_cycle);
              $('input[name="i_detail_hour"]').val(data.val[i].production_target_hour);
              $('input[name="i_detail_sift"]').val(data.val[i].production_target_shift);
              
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');
              $("#i_operator").append('<option value="'+data.val[i].employee_id+'" selected>'+data.val[i].employee_name+'</option>');

              if (data.val[i].item_status == 1) {
                document.getElementById("inlineRadio1").checked = true;
              }else if (data.val[i].item_status == 2) {
                document.getElementById("inlineRadio2").checked = true;
              }


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
                url: '<?php echo base_url();?>production_v2/delete_data_detail',
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

    function save_result(){
        var id = document.getElementById("i_detail_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);
        /*var lock = document.getElementById("i_lock").value;
        if (lock == 0) {*/
          $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>Production_v2/action_data_result/',
            data : $( "#form_modal" ).serialize(),
            dataType : "json",
            success:function(data){
              if(data.status=='200'){
                reset4();
                search_data_result(id_new);
              } 
            }
          });
        /*}else{
          alert("Maaf data sudah di lock!");
        }*/
        
      }

      function reset4(){
        $('input[name="i_result_qty"]').val("");
        $('input[name="i_result_id"]').val("");
        $('input[name="i_result_bs"]').val("");
        $('input[name="i_result_gs"]').val("");
        $('input[name="i_time1"]').val("");
        $('input[name="i_time2"]').val("");
        $('input[name="i_result_desc"]').val("");
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Production_v2/load_data_where_result/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_result_id"]').val(data.val[i].production_detail_id);
              $('input[name="i_result_qty"]').val(data.val[i].production_detail_qty);
              $('input[name="i_result_bs"]').val(data.val[i].production_detail_bs);
              $('input[name="i_result_gs"]').val(data.val[i].production_detail_gs);
              $('input[name="i_time1"]').val(data.val[i].production_detail_time1);
              $('input[name="i_time2"]').val(data.val[i].production_detail_time2);
              $('input[name="i_result_desc"]').val(data.val[i].production_detail_desc);

            }
          }
        });
      }

      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_detail_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var color_id = document.getElementById("i_color_id").value;

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Production_v2/delete_data_result',
                data: {id:id_detail,detail_id:color_id},
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_result(id_new);
                  }
                }
            });
        }
        
    }

    $("#form_modal").submit(function(event){
        if ($("#form_modal").valid()==true) {
          action_data_edit();
        }
        return false;
      });

    function action_data_edit(){
          $.ajax({
            type : "POST",
            url  : '<?php echo base_url();?>Production_v2/action_data_edit/',
            data : $( "#form_modal" ).serialize(),
            dataType : "json",
            success:function(data){
              if(data.status=='200'){
                $("#myModal").modal('hide');
              } 
            }
          });
      }

    function generate_cycle(value){
      //alert(value);
        var second = 3600;
        var hour = second / value;
        var sift = hour * 8;

        document.getElementById("i_detail_hour").value           = hour;
        document.getElementById("i_detail_sift").value           = sift;
      }
</script>
</body>
</html>