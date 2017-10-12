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
                                <th>Nama Karyawan</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

        </div>
        <div class="tab-pane" id="form">
            <div class="box-inner">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Id employee (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Nama Karyawan</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Karyawan" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>No KTP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No KTP" required="required" name="i_ktp" id="i_ktp" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat Karyawan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Karyawan" required="required" name="i_addres" id="i_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Lahir" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>No HP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Handphone" required="required" name="i_hp" id="i_hp" value="">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No Rek</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Rekening"  name="i_rek" id="i_rek" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama Bank</label>
                            <input type="text" class="form-control" placeholder="Masukkan nama Bank"  name="i_bank" id="i_bank" value="">
                          </div>
                          <div class="form-group">
                            <label>No NPWP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No NPWP"  name="i_no_npwp" id="i_no_npwp" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama NPWP</label>
                            <input type="text" class="form-control" placeholder="Masukkan Nama NPWP"  name="i_name_npwp" id="i_name_npwp" value="">
                          </div>
                          <div class="form-group">
                            <label>Divisi</label>
                            <select class="form-control select2" name="i_division" id="i_division" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_begin" placeholder="Tanggal Masuk" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Status :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_status" id="status1" value="Aktif" >
                              </label>
                              <label for="status1">
                                Aktif &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_status" id="status2" value="Tidak Aktif" >
                              </label >
                              <label for="status2">
                                Tidak Aktif
                              </label>
                          </div>
                          
                        </div>
                        
                      </div>
                      <div class="box-footer text-right">
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
        select_list_division();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>employee/load_data/'
            },
            "columns": [
              {"name": "employee_name"},
              {"name": "employee_telp"},
              {"name": "employee_address"},
              {"name": "division_name"},
              {"name": "employee_status"},
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
          url  : '<?php echo base_url();?>Employee/action_data/',
          data : new FormData($('#formall')[0]),//$( "#formall" ).serialize(),
          dataType : "json",
          contentType: false,       
          cache: false,             
          processData:false,
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
                url: '<?php echo base_url();?>Employee/delete_data',
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
          url  : '<?php echo base_url();?>Employee/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value               = data.val[i].employee_id;
              document.getElementById("i_name").value             = data.val[i].employee_name;
              document.getElementById("i_ktp").value              = data.val[i].employee_ktp;
              document.getElementById("i_addres").value           = data.val[i].employee_address;
              document.getElementById("datepicker").value         = data.val[i].employee_birth_date;
              document.getElementById("i_hp").value               = data.val[i].employee_hp;
              document.getElementById("i_rek").value              = data.val[i].employee_rek;
              document.getElementById("i_bank").value             = data.val[i].employee_bank;
              document.getElementById("i_no_npwp").value          = data.val[i].employee_npwp;
              document.getElementById("i_name_npwp").value        = data.val[i].employee_name_npwp;
              document.getElementById("datepicker2").value        = data.val[i].employee_begin;
              $("#i_division").append('<option value="'+data.val[i].division_id+'" selected>'+data.val[i].division_name+'</option>');
              if (data.val[i].employee_status == 'Aktif') {
                document.getElementById("status1").checked = true;
              } else if (data.val[i].employee_status == 'Tidak Aktif') {
                document.getElementById("status2").checked = true;
              }

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_division() {
        $('#i_division').select2({
          placeholder: 'Pilih Divisi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Division/load_data_select_division/',
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
        $('#i_division option').remove();
      }
</script>
</body>
</html>