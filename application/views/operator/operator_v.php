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
                                <th>Nama Operator</th>
                                <th>Alamat</th>
                                <th>No Handphone</th>
                                <th>Bagian</th>
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
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat" required="required" name="i_addres" id="i_addres"></textarea>
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
                            <label>Bagian :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_type" id="status1" value="Sopir">
                              </label>
                              <label for="status1">
                                Sopir &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_type" id="status2" value="Kernet">
                              </label >
                              <label for="status2">
                                Kernet
                              </label>
                          </div>   
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>No KTP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No KTP" required="required" name="i_ktp" id="i_ktp" value="">
                          </div>  
                          <div class="form-group">
                            <label>No HP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Handphone" required="required" name="i_hp" id="i_hp" value="">
                          </div>
                          <div class="form-group">
                            <label>No SIM A</label>
                            <input type="number" class="form-control" placeholder="Masukkan SIM A"  name="i_sima" id="i_sima" value="">
                          </div>
                          <div class="form-group">
                            <label>No SIM B1</label>
                            <input type="number" class="form-control" placeholder="Masukkan SIM B1"  name="i_simb1" id="i_simb1" value="">
                          </div>
                          <div class="form-group">
                            <label>No SIM C</label>
                            <input type="number" class="form-control" placeholder="Masukkan SIM C"  name="i_simc" id="i_simc" value="">
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
              url: '<?php echo base_url();?>Operator/load_data/'
            },
            "columns": [
              {"name": "operator_name"},
              {"name": "operator_address"},
              {"name": "operator_hp"},
              {"name": "operator_type"},
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
          url  : '<?php echo base_url();?>Operator/action_data/',
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
                url: '<?php echo base_url();?>Operator/delete_data',
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
          url  : '<?php echo base_url();?>Operator/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].operator_id;
              document.getElementById("i_name").value = data.val[i].operator_name;
              document.getElementById("i_addres").value = data.val[i].operator_address;
              document.getElementById("datepicker").value = data.val[i].operator_birth;
              document.getElementById("i_ktp").value = data.val[i].operator_ktp;
              document.getElementById("i_hp").value = data.val[i].operator_hp;
              document.getElementById("i_sima").value = data.val[i].operator_sima;
              document.getElementById("i_simb1").value = data.val[i].operator_simb1;
              document.getElementById("i_simc").value = data.val[i].operator_simc;
              if (data.val[i].operator_type == 'Sopir') {
                document.getElementById("status1").checked = true;
              } else if (data.val[i].operator_type == 'Kernet') {
                document.getElementById("status2").checked = true;
              }

              document.getElementById('detail_data').style.display = 'block';

              $("#galeries").load("<?= base_url()?>Operator/load_galery/"+id);
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
        url  : '<?php echo base_url();?>Operator/action_galery/',
        data : new FormData($('#formall')[0]),
        dataType : "json",
        contentType: false,       
        cache: false,             
        processData:false,
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Operator/load_galery/"+id);
          }
        }
      });
    }

    function delete_galery(id_galery){
      //alert(id);
      var id =document.getElementById("i_id").value;
      
      $.ajax({
        type : "POST",
        url  : '<?php echo base_url();?>Operator/delete_galery/',
        data : {id_galery:id_galery},
        dataType : "json",
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Operator/load_galery/"+id);
          }
        }
      });
    }
</script>
</body>
</html>