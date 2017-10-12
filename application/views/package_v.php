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
                                <th>Nama Paket</th>
                                <th>Stok</th>
                                <th>Ukuran</th>
                                <th>Kualitas</th>
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
                            <label>Id Package (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                          <div class="form-group">
                            <label>Nama Paket</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Paket" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Stok</label>
                            <input type="number" class="form-control" placeholder="Masukkan Stok" required="required" name="i_qty" id="i_qty" value="">
                          </div>
                          <div class="form-group">
                            <label>Minimal Stok</label>
                            <input type="number" class="form-control" placeholder="Masukkan Minimal Stok" required="required" name="i_min" id="i_min" value="">
                          </div>
                          <div class="form-group">
                            <label>Maxsimal Stok</label>
                            <input type="number" class="form-control" placeholder="Masukkan Maximal Stok" required="required" name="i_max" id="i_max" value="">
                          </div>
                          <div class="form-group">
                            <label>Ukuran</label>
                            <input type="number" class="form-control" placeholder="Masukkan Ukuran" required="required" name="i_size" id="i_size" value="">
                          </div>
                          <div class="form-group">
                            <label>Kualitas</label>
                            <input type="text" class="form-control" placeholder="Masukkan Kualitas" name="i_quality" id="i_quality" value="">
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          
                          <div class="form-group">
                            <label for="exampleInputFile">Foto Paket</label>
                              <br />
                              <img id="img_package" src="" style="width:100%;"/>
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
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Package/load_data/'
            },
            "columns": [
              {"name": "package_name"},
              {"name": "package_qty"},
              {"name": "package_size"},
              {"name": "package_quality"},
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
          url  : '<?php echo base_url();?>Package/action_data/',
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
                url: '<?php echo base_url();?>Package/delete_data',
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
          url  : '<?php echo base_url();?>Package/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value       = data.val[i].package_id;
              document.getElementById("i_name").value     = data.val[i].package_name;
              document.getElementById("i_qty").value      = data.val[i].package_qty;
              document.getElementById("i_min").value      = data.val[i].package_min;
              document.getElementById("i_max").value      = data.val[i].package_max;
              document.getElementById("i_size").value     = data.val[i].package_size;
              document.getElementById("i_quality").value  = data.val[i].package_quality;
              $("#img_package").attr("src", data.val[i].package_img);

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function reset2(){
      $('#img_package').attr('src', '');
    }
</script>
</body>
</html>