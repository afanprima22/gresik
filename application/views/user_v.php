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
                                <th>KTP</th>
                                <th>Nama User</th>
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
                            <label>Id User (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>User Type</label>
                            <select class="form-control select2" name="i_type" id="i_type" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>KTP</label>
                            <input type="text" class="form-control" name="i_ktp" id="i_ktp" placeholder="Masukkan KTP" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat" required="required" name="i_addres" id="i_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" name="i_username" id="i_username" placeholder="Masukkan Username" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="i_password" id="i_password" placeholder="Masukkan Password" value="" required="required">
                          </div>
                          <div class="form-group">
                          
                              <label>
                                <input type="radio" name="i_status" id="status1" value="1" >
                              </label>
                              <label for="status1">
                                Aktif &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_status" id="status2" value="0" >
                              </label >
                              <label for="status2">
                                Tidak Aktif
                              </label>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputFile">Foto Toko</label>
                              <br />
                              <img id="img_user" src="" style="width:100%;"/>
                              <br />
                            <input type="file" name="i_img" id="i_img" >
                            
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
        select_list_user_type();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>User/load_data/'
            },
            "columns": [
              {"name": "user_ktp"},
              {"name": "user_name"},
              {"name": "user_active_status"},
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
          url  : '<?php echo base_url();?>User/action_data/',
          data : new FormData($('#formall')[0]),//$( "#formall" ).serialize(),
          dataType : "json",
          contentType: false,       
          cache: false,             
          processData:false,
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2()
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
                url: '<?php echo base_url();?>User/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
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
          url  : '<?php echo base_url();?>User/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].user_id;
              document.getElementById("i_name").value = data.val[i].user_name;
              document.getElementById("i_addres").value = data.val[i].user_addres;
              document.getElementById("i_ktp").value = data.val[i].user_ktp;
              document.getElementById("i_username").value = data.val[i].user_username;
              document.getElementById("i_password").value = data.val[i].user_password;

              $("#i_type").append('<option value="'+data.val[i].user_type_id+'" selected>'+data.val[i].user_type_name+'</option>');
              $("#img_user").attr("src", data.val[i].user_img);

              if (data.val[i].user_active_status == 1) {
                document.getElementById("status1").checked = true;
              } else{
                document.getElementById("status2").checked = true;
              }

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_user_type() {
        $('#i_type').select2({
          placeholder: 'Pilih Group',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>User_type/load_data_select_user_type/',
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
        $('#i_type option').remove();
        $('#img_user').attr('src', '');
      }


</script>
</body>
</html>