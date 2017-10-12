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
                              <th width="5%">No</th>
                              <th width="15%">Kode Lokasi</th>
                              <th>Nama Lokasi</th>
                              <th width="15%">Tingkatan</th>
                              <th width="15%">Config</th>
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
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="" >
                            <label>Pilih Lokasi : </label>
                            &nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_location(0)" name="i_type" id="inlineRadio1" value="1"> Provinsi
                            </label>
                            &nbsp;
                            <label>
                                <input type="radio" onclick="type_location(1)" name="i_type" id="inlineRadio2" value="2"> Kabupaten
                            </label>
                             &nbsp;
                            <label>
                                <input type="radio" onclick="type_location(2)" name="i_type" id="inlineRadio3" value="3"> Kecamatan
                            </label>
                             &nbsp;
                            <label>
                                <input type="radio" onclick="type_location(3)" name="i_type" id="inlineRadio4" value="4"> Kelurahan
                            </label>
                          </div>
                          <div id="type_location" style="display: none;">
                            <div class="form-group">
                              <label>Lokasi</label>
                              <select class="form-control select2" name="i_location" id="i_location" style="width: 100%;">
                              </select>
                            </div>
                          </div>
                                                  
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama Lokasi</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Wilayah" required="required" value="" >
                          </div>  
                          
                      </div>
                    </div>
                      <div class="box-footer text-right">
                        <button type="button" onclick="reset()" class="btn btn-warning">Batal</button>
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
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>location/load_data/'
            },
            "columns": [
              {"name": "location_id","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "location_code"},
              {"name": "location_name"},
              {"name": "location_type"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [1, 'asc']
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
          url  : '<?php echo base_url();?>location/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
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
                url: '<?php echo base_url();?>location/delete_data',
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
          url  : '<?php echo base_url();?>location/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].location_id;
              document.getElementById("i_name").value = data.val[i].location_name;

              if (data.val[i].location_type == 1) {
                document.getElementById("inlineRadio1").checked = true;
              }else if(data.val[i].location_type == 2){
                document.getElementById("inlineRadio2").checked = true;
              }else if(data.val[i].location_type == 3){
                document.getElementById("inlineRadio3").checked = true;
              }else if(data.val[i].location_type == 4){
                document.getElementById("inlineRadio4").checked = true;
              }
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function type_location(id){
      if (id == 0) {
        document.getElementById('type_location').style.display = 'none';
      }else{
        document.getElementById('type_location').style.display = 'block';
      }
      select_list_location(id);
    }

    function select_list_location(id) {
        $('#i_location').select2({
          placeholder: 'Pilih Lokasi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>location/load_data_select_location/'+id,
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