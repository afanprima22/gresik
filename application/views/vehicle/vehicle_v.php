<style type="text/css">
.fileinput-button input{position:absolute;top:0;right:0;margin:0;opacity:0;-ms-filter:'alpha(opacity=0)';font-size:15px;direction:ltr;cursor:pointer}
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
                                <th>Nama Kendaraan</th>
                                <th>Merk</th>
                                <th>Tahun Buat</th>
                                <th>Nomor STNK</th>
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
                            <label>Id Divisi (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Kendaraan" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Merk</label>
                            <input type="text" class="form-control" name="i_brand" id="i_brand" placeholder="Masukkan Merk Kendaraan" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Tanggal Kir</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date_kir" placeholder="Tanggal Kir" value="" required="required">
                            </div>
                          </div>               
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tahun Pembuatan</label>
                            <input type="number" class="form-control" name="i_year" id="i_year" placeholder="Masukkan Tahun Pembuatan" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>No BPKB</label>
                            <input type="number" class="form-control" placeholder="Masukkan No BPKB" required="required" name="i_bpkb" id="i_bpkb" value="">
                          </div>
                          <div class="form-group">
                            <label>No STNK</label>
                            <input type="number" class="form-control" placeholder="Masukkan No STNK" required="required" name="i_stnk" id="i_stnk" value="">
                          </div>
                          <div class="form-group">
                            <label>Tanggal Pajak STNK</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_stnk" placeholder="Tanggal Pajak STNK" value="" required="required">
                            </div>
                          </div>

                        </div>

                        <div class="col-md-12" id="detail_data" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2><i class="glyphicon glyphicon-picture"></i> Gallery</h2>
                              <div class="box-icon">
                              <div>
                                <span class="btn btn-success btn-xs fileinput-button"><i class="glyphicon glyphicon-plus"></i><span>Add files...</span><input type="file" onchange="get_save_galery(this.value)" name="i_galery" id="i_galery" title="fill slider img" /></span>
                                </div>
                              </div>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                
                                <div id="galeries"></div>

                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="form-group"></div>
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
              url: '<?php echo base_url();?>vehicle/load_data/'
            },
            "columns": [
              {"name": "vehicle_name"},
              {"name": "vehicle_brand"},
              {"name": "vehicle_year"},
              {"name": "vehicle_stnk"},
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
          url  : '<?php echo base_url();?>Vehicle/action_data/',
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
            document.getElementById('detail_data').style.display = 'none'; 
          }
        });
    }


    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Vehicle/delete_data',
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
      var url = "<?= base_url(); ?>";

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Vehicle/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].vehicle_id;
              document.getElementById("i_name").value = data.val[i].vehicle_name;
              document.getElementById("i_brand").value = data.val[i].vehicle_brand;
              document.getElementById("datepicker").value = data.val[i].vehicle_kir;
              document.getElementById("i_year").value = data.val[i].vehicle_year;
              document.getElementById("i_bpkb").value = data.val[i].vehicle_bpkb;
              document.getElementById("i_stnk").value = data.val[i].vehicle_stnk;
              document.getElementById("datepicker2").value = data.val[i].vehicle_stnk_date;

              document.getElementById('detail_data').style.display = 'block';

              /*$("#galeries").empty();
              for(var j=0; j<data.val[i].list_galery.val2.length; j++){
                $("#galeries").append('\
                  <li>\
                    <div class="thumbnail">\
                      <a href="'+url+'images/vehicle/'+data.val[i].list_galery.val2[j].vehicle_galery_file+'" ><img src="'+url+'images/vehicle/'+data.val[i].list_galery.val2[j].vehicle_galery_file+'"></a><br>\
                      <button type="button" onclick="delete_galery('+data.val[i].list_galery.val2[j].vehicle_galery_id+')" class="btn btn-danger btn-xs">Remove</button>\
                    </div>\
                  </li>'
                );
              }*/

              $("#galeries").load("<?= base_url()?>Vehicle/load_galery/"+id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function get_save_galery(value){
      //alert(id);
      var id =document.getElementById("i_id").value;

      $.ajax({
        type : "POST",
        url  : '<?php echo base_url();?>Vehicle/action_galery/',
        data : new FormData($('#formall')[0]),
        dataType : "json",
        contentType: false,       
        cache: false,             
        processData:false,
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Vehicle/load_galery/"+id);
          }
        }
      });
    }

    function delete_galery(id_galery){
      //alert(id);
      var id =document.getElementById("i_id").value;
      
      $.ajax({
        type : "POST",
        url  : '<?php echo base_url();?>Vehicle/delete_galery/',
        data : {id_galery:id_galery},
        dataType : "json",
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Vehicle/load_galery/"+id);
          }
        }
      });
    }
</script>
</body>
</html>