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
                                <th>Nama sales</th>
                                <th>Alamat</th>
                                <th>No Handphone</th>
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
                            <label>SIM A</label>
                            <input type="text" class="form-control" name="i_sima" id="i_sima" placeholder="Masukkan SIM A" value="">
                          </div>
                          <div class="form-group">
                            <label>Status :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_status" id="status1" value="Aktif">
                              </label>
                              <label for="status1">
                                Aktif &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_status" id="status2" value="Tidak Aktif">
                              </label >
                              <label for="status2">
                                Tidak Aktif
                              </label>
                          </div>   

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Status Kawin:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_married" id="married1" value="0">
                              </label>
                              <label for="married1">
                                Belum Kawin &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_married" id="married2" value="1">
                              </label >
                              <label for="married2">
                                Sudah Kawin
                              </label>
                          </div> 
                          <div class="form-group">
                            <label>Type Sales:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_type" id="type1" value="0">
                              </label>
                              <label for="type1">
                                Lokal &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_type" id="type2" value="1">
                              </label>
                              <label for="type2">
                                Export &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_type" id="type3" value="2">
                              </label >
                              <label for="type3">
                                Online
                              </label>
                          </div>   
                          <div class="form-group">
                            <label>No KTP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No KTP" required="required" name="i_ktp" id="i_ktp" value="">
                          </div>  
                          <div class="form-group">
                            <label>No HP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Handphone" required="required" name="i_hp" id="i_hp" value="">
                          </div>
                          <div class="form-group">
                            <label>No SIM C</label>
                            <input type="number" class="form-control" placeholder="Masukkan SIM C"  name="i_simc" id="i_simc" value="">
                          </div>
                          <div class="form-group">
                            <label>Wilayah</label>
                            <select id="selectcity" class="form-control select2" style="width: 100%;" name="i_city[]">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Mulai Masuk</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date2" placeholder="Tanggal Mulai Masuk" value="" required="required">
                            </div>
                          </div>

                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Note</label>
                            <textarea class="form-control" rows="2" placeholder="Masukkan Note" name="i_note" id="i_note"></textarea>
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
        select_list_city()
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Sales/load_data/'
            },
            "columns": [
              {"name": "sales_name"},
              {"name": "sales_address"},
              {"name": "sales_hp"},
              {"name": "sales_type"},
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
          url  : '<?php echo base_url();?>Sales/action_data/',
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
            document.getElementById('detail_data').style.display = 'none'; 
          }
        });
    }


    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Sales/delete_data',
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
      var url = "<?= base_url(); ?>";

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Sales/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].sales_id;
              document.getElementById("i_name").value = data.val[i].sales_name;
              document.getElementById("i_addres").value = data.val[i].sales_address;
              document.getElementById("datepicker").value = data.val[i].sales_birth;
              document.getElementById("datepicker2").value = data.val[i].sales_begin;
              document.getElementById("i_ktp").value = data.val[i].sales_ktp;
              document.getElementById("i_hp").value = data.val[i].sales_hp;
              document.getElementById("i_note").value = data.val[i].sales_note;
              document.getElementById("i_simc").value = data.val[i].sales_simc;
              document.getElementById("i_sima").value = data.val[i].sales_sim_a;
              if (data.val[i].sales_status == 'Aktif') {
                document.getElementById("status1").checked = true;
              } else if (data.val[i].sales_status == 'Tidak Aktif') {
                document.getElementById("status2").checked = true;
              }

              if (data.val[i].sales_married == 0) {
                document.getElementById("married1").checked = true;
              } else if (data.val[i].sales_married == 1) {
                document.getElementById("married2").checked = true;
              }
              if (data.val[i].sales_type == 0) {
                document.getElementById("type1").checked = true;
              } else if (data.val[i].sales_type == 1) {
                document.getElementById("type2").checked = true;
              } else if (data.val[i].sales_type == 2) {
                document.getElementById("type3").checked = true;
              }

              for(var j=0; j<data.val[i].cities.val2.length; j++){
                $("#selectcity").append('<option value="'+data.val[i].cities.val2[j].id+'" selected>'+data.val[i].cities.val2[j].text+'</option>');
              }

              document.getElementById('detail_data').style.display = 'block';

              $("#galeries").load("<?= base_url()?>Sales/load_galery/"+id);
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
        url  : '<?php echo base_url();?>Sales/action_galery/',
        data : new FormData($('#formall')[0]),
        dataType : "json",
        contentType: false,       
        cache: false,             
        processData:false,
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Sales/load_galery/"+id);
          }
        }
      });
    }

    function delete_galery(id_galery){
      //alert(id);
      var id =document.getElementById("i_id").value;
      
      $.ajax({
        type : "POST",
        url  : '<?php echo base_url();?>Sales/delete_galery/',
        data : {id_galery:id_galery},
        dataType : "json",
        success:function(data){
          if(data.status=='200'){
             $("#galeries").load("<?= base_url()?>Sales/load_galery/"+id);
          }
        }
      });
    }

    function select_list_city() {
        $('#selectcity').select2({
          placeholder: 'Pilih Wilayah',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>City/load_data_select_city/',
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
        $('#selectcity option').remove();
      }
</script>
</body>
</html>