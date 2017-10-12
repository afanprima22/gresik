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
                                <th>Nama Partner</th>
                                <th>No Telepon</th>
                                <th>Kategori</th>
                                <th>Sales Partner</th>
                                <th>Alamat</th>
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
                            <label>Id partner (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Nama Partner</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Partner" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control select2" name="i_category" id="i_category" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Nama Sales Partner</label>
                            <input type="text" class="form-control" name="i_sales_partner" id="i_sales_partner" placeholder="Masukkan Nama Sales Partner" value="" >
                          </div>
                          <div class="form-group">
                            <label>Nama Owner</label>
                            <input type="text" class="form-control" name="i_owner" id="i_owner" placeholder="Masukkan Nama Owner" value="" >
                          </div>
                          <div class="form-group">
                            <label>No Telepon</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Telepon" name="i_telp" id="i_telp" value="">
                          </div>
                          <div class="form-group">
                            <label>No HP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Handphone" required="required" name="i_hp" id="i_hp" value="">
                          </div>
                          <div class="form-group">
                            <label>No Rekening</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Rekening"  name="i_rek" id="i_rek" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama Bank</label>
                            <input type="text" class="form-control" name="i_bank" id="i_bank" placeholder="Masukkan Nama Bank" value="" >
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Email</label>
                            <input type="mail" class="form-control" placeholder="Masukkan Mail"  name="i_mail" id="i_mail" value="">
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
                            <label>No Rekening NPWP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Rekening NPWP" name="i_npwp_rek" id="i_npwp_rek" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama Bank NPWP</label>
                            <input type="text" class="form-control" name="i_npwp_bank" id="i_npwp_bank" placeholder="Masukkan Nama Bank NPWP" value="">
                          </div>
                          <div class="form-group">
                            <label>Jatuh Tempo</label>
                            <input type="number" class="form-control" placeholder="Masukkan Jumlah Hari Jatuh Tempo" required="required" name="i_tempo" id="i_tempo" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat Partner</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat"  name="i_addres" id="i_addres"></textarea>
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
        select_list_category();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>partner/load_data/'
            },
            "columns": [
              {"name": "partner_name"},
              {"name": "partner_telp"},
              {"name": "category_name"},
              {"name": "partner_sales_name"},
              {"name": "partner_address"},
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
          url  : '<?php echo base_url();?>partner/action_data/',
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
                url: '<?php echo base_url();?>partner/delete_data',
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
          url  : '<?php echo base_url();?>partner/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].partner_id;
              document.getElementById("i_name").value           = data.val[i].partner_name;
              document.getElementById("i_sales_partner").value  = data.val[i].partner_sales_name;
              document.getElementById("i_owner").value          = data.val[i].partner_owner;
              document.getElementById("i_telp").value           = data.val[i].partner_telp;
              document.getElementById("i_hp").value             = data.val[i].partner_hp;
              document.getElementById("i_rek").value            = data.val[i].partner_rek;
              document.getElementById("i_bank").value           = data.val[i].partner_bank;
              document.getElementById("i_mail").value           = data.val[i].partner_mail;
              document.getElementById("i_no_npwp").value        = data.val[i].partner_npwp;
              document.getElementById("i_name_npwp").value      = data.val[i].partner_name_npwp;
              document.getElementById("i_npwp_rek").value       = data.val[i].partner_npwp_rek;
              document.getElementById("i_npwp_bank").value      = data.val[i].partner_npwp_bank;
              document.getElementById("i_tempo").value          = data.val[i].partner_tempo;
              document.getElementById("i_addres").value         = data.val[i].partner_address;
              $("#i_category").append('<option value="'+data.val[i].category_id+'" selected>'+data.val[i].category_name+'</option>');
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_category() {
        $('#i_category').select2({
          placeholder: 'Pilih Type',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Partner/load_data_select_category/',
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
        $('#i_category option').remove();
      }
</script>
</body>
</html>