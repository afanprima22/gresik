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
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Nama Toko</th>
                                <th>Jenis kongsi</th>
                                <th>Wilayah</th>
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
                            <label>Kategori</label>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" >
                            <select class="form-control select2" name="i_category" id="i_category" style="width: 70%;" required="required">
                            </select>
                            <a href="#myModal" class="btn btn-info btn-xs" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i>Kategori</a>
                          </div>
                          <div class="form-group">
                            <label>Nama kongsi</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama kongsi" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat kongsi</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat" required="required" name="i_addres" id="i_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>Nama Toko</label>
                            <input type="text" class="form-control" name="i_store" id="i_store" placeholder="Masukkan Nama Toko" value="" required="required">
                          </div>
                          <div class="form-group">
                            <label>Alamat Toko</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Toko" required="required" name="i_store_addres" id="i_store_addres"></textarea>
                          </div>
                          <div class="form-group">
                            <label>No Telepon</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Telepon" required="required" name="i_telp" id="i_telp" value="">
                          </div>
                          <div class="form-group">
                            <label>No HP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No Handphone" required="required" name="i_hp" id="i_hp" value="">
                          </div>
                          <div class="form-group">
                            <label>Email</label>
                            <input type="mail" class="form-control" placeholder="Masukkan Mail" name="i_mail" id="i_mail" value="">
                          </div>
                          <div class="form-group">
                            <label>Alamat Gudang</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Gudang" name="i_warehouse_addres" id="i_warehouse_addres"></textarea>
                          </div>
                          

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Pembelian</label>
                            <div class="form-group">
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Masukkan PIC Pembelian" name="i_purchase_pic" id="i_purchase_pic" value="">
                              </div>
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Masukkan No Telepon" name="i_purchase_tlp" id="i_purchase_tlp" value="">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Gudang</label>
                            <div class="form-group">
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Masukkan PIC Gudang" name="i_warehouse_pic" id="i_warehouse_pic" value="">
                              </div>
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Masukkan No Telepon" name="i_warehouse_tlp" id="i_warehouse_tlp" value="">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Toko</label>
                            <div class="form-group">
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Masukkan PIC Toko" name="i_store_pic" id="i_store_pic" value="">
                              </div>
                              <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Masukkan No Telepon" name="i_store_tlp" id="i_store_tlp" value="">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>No NPWP</label>
                            <input type="number" class="form-control" placeholder="Masukkan No NPWP" name="i_no_npwp" id="i_no_npwp" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama NPWP</label>
                            <input type="text" class="form-control" placeholder="Masukkan Nama NPWP" name="i_name_npwp" id="i_name_npwp" value="">
                          </div>
                          <div class="form-group">
                            <label>Jenis kongsi</label>
                            <select class="form-control select2" name="i_type" id="i_type2" style="width: 100%;" required="required" onchange="get_type(this.value)">
                            </select>
                          </div>
                          <div class="form-group" style="display: none;" id="sub_type">
                            <label>Alokasi Harga Khusus</label>
                            <select class="form-control select2" name="i_type_sub" id="i_type_sub" style="width: 100%;">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Wilayah</label>
                            <select class="form-control select2" name="i_city" id="i_city2" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputFile">Foto Toko</label>
                              <br />
                              <img id="img_kongsi" src="" style="width:100%;"/>
                              <br />
                            <input type="file" name="i_img" id="i_img" >
                            
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
                                      <td><input type="text" class="form-control" name="i_branch_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_branch" placeholder="Masukkan Nama Cabang" onkeydown="if (event.keyCode == 13) { save_branch(); }">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_branch_address" placeholder="Masukkan Alamat Cabang" onkeydown="if (event.keyCode == 13) { save_branch(); }">
                                      </td>
                                      <td>
                                        <!-- <input type="text" class="form-control" name="i_pic" placeholder="Masukkan PIC" onkeydown="if (event.keyCode == 13) { save_branch(); }"> -->
                                      </td>
                                      <td>
                                        <select class="form-control select2" name="i_spg" id="i_spg" style="width: 100%;"></select>
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_branch()" class="btn btn-primary">Simpan Cabang</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Cabang</th>
                                      <th>Alamat Cabang</th>
                                      <th>PIC</th>
                                      <th>SPG</th>
                                      <th width="10%">Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-12" id="detail_data_price" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Price</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Nama Promo 1</label>
                                      <input type="text" class="form-control" placeholder="Masukkan Nama Promo 1" name="i_name_promo1" id="i_name_promo1" value="">
                                    </div>
                                    <div class="form-group">
                                      <label>Tanggal Promo 1</label>
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="glyphicon glyphicon-calendar"></i>
                                        </div>
                                        <input type="text" name="i_promo1_date" class="form-control pull-right" id="reservation" value="">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Nama Promo 2</label>
                                      <input type="text" class="form-control" placeholder="Masukkan Nama Promo 2" name="i_name_promo2" id="i_name_promo2" value="">
                                    </div>
                                    <div class="form-group">
                                      <label>Tanggal Promo 2</label>
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="glyphicon glyphicon-calendar"></i>
                                        </div>
                                        <input type="text" name="i_promo2_date" class="form-control pull-right" id="reservation2" value="">
                                      </div>
                                    </div>
                                  </div>
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_price_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_price" placeholder="Masukkan Harga Khusus" onkeydown="if (event.keyCode == 13) { save_price(); }">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_promo1" placeholder="Masukkan Harga Promo" onkeydown="if (event.keyCode == 13) { save_price(); }">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_promo2" placeholder="Masukkan Harga Promo" onkeydown="if (event.keyCode == 13) { save_price(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_price()" class="btn btn-primary">Simpan Harga</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Barang Jadi</th>
                                      <th>Harga Khusus</th>
                                      <th><label id="promo1">Harga</label></th>
                                      <th><label id="promo2">Harga</label></th>
                                      <th width="10%">Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="form-group">&nbsp;</div>
                      <div class="box-footer text-right">
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="formcategory" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Data Kategori</h4>
                  </div>
                  <div class="modal-body">
                      <!--<div class="box-inner">
                            
                            <div class="box-content">-->
                              <div class="form-group">
                                <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="hidden" class="form-control" name="i_category_id" id="i_category_id"></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_category_name" id="i_category_name" placeholder="Masukkan Nama Kategori" onkeydown="if (event.keyCode == 13) { save_category(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_category()" class="btn btn-primary">Simpan Kategori</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Nama Kategori</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            <!--</div>
                          </div>-->
                  </div>
                  <div class="modal-footer">
                      <a href="#" class="btn btn-warning" data-dismiss="modal">Selesai</a>
                      <!--<a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Save changes</a>-->
                  </div>
              </div>
          </form>
          </div>
      </div>

</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_type();
        select_list_type2();
        select_list_city();
        select_list_spg();
        select_list_item();
        search_data_category();
        select_list_category();
        document.getElementById('detail_data').style.display = 'none';
        document.getElementById('detail_data_price').style.display = 'none';
        document.getElementById('sub_type').style.display = 'none';
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Kongsi/load_data/'
            },
            "columns": [
              {"name": "kongsi_name"},
              {"name": "kongsi_telp"},
              {"name": "kongsi_store"},
              {"name": "kongsi_type_name"},
              {"name": "location_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_branch(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Kongsi/load_data2/'+id
            },
            "columns": [
              {"name": "kongsi_branch_id"},
              {"name": "kongsi_branch_name"},
              {"name": "kongsi_branch_address"},
              {"name": "kongsi_purchase_pic"},
              {"name": "spg_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_price(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Kongsi/load_data3/'+id
            },
            "columns": [
              {"name": "kongsi_price_id"},
              {"name": "item_name"},
              {"name": "kongsi_price_value"},
              {"name": "kongsi_price_promo1"},
              {"name": "kongsi_price_promo2"},
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
          url  : '<?php echo base_url();?>Kongsi/action_data/',
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

    function save_branch(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Kongsi/action_data_cabang/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_branch(id_new);
            } 
          }
        });
      }

      function save_price(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Kongsi/action_data_price/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_price(id_new);
            } 
          }
        });
      }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Kongsi/delete_data',
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
          url  : '<?php echo base_url();?>Kongsi/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].kongsi_id;
              document.getElementById("i_name").value = data.val[i].kongsi_name;
              document.getElementById("i_addres").value = data.val[i].kongsi_address;
              document.getElementById("i_store").value = data.val[i].kongsi_store;
              document.getElementById("i_store_addres").value = data.val[i].kongsi_store_address;
              document.getElementById("i_telp").value = data.val[i].kongsi_telp;
              document.getElementById("i_hp").value = data.val[i].kongsi_hp;
              document.getElementById("i_mail").value = data.val[i].kongsi_mail;
              document.getElementById("i_no_npwp").value = data.val[i].kongsi_no_npwp;
              document.getElementById("i_name_npwp").value = data.val[i].kongsi_name_npwp;

              document.getElementById("i_warehouse_addres").value = data.val[i].kongsi_warehouse;
              document.getElementById("i_warehouse_pic").value = data.val[i].kongsi_warehouse_pic;
              document.getElementById("i_warehouse_tlp").value = data.val[i].kongsi_warehouse_tlp;
              document.getElementById("i_purchase_pic").value = data.val[i].kongsi_purchase_pic;
              document.getElementById("i_purchase_tlp").value = data.val[i].kongsi_purchase_tlp;
              document.getElementById("i_store_tlp").value = data.val[i].kongsi_store_tlp;
              document.getElementById("i_store_pic").value = data.val[i].kongsi_store_pic;

              $("#i_type2").append('<option value="'+data.val[i].kongsi_type_id+'" selected>'+data.val[i].kongsi_type_name+'</option>');
              $("#i_type_sub").append('<option value="'+data.val[i].kongsi_type_sub_id+'" selected>'+data.val[i].kongsi_type_sub_name+'</option>');
              $("#i_city2").append('<option value="'+data.val[i].location_id+'" selected>'+data.val[i].location_code+'-'+data.val[i].location_name+'</option>');
              $("#i_category").append('<option value="'+data.val[i].kongsi_category_id+'" selected>'+data.val[i].kongsi_category_name+'</option>');
              $("#img_kongsi").attr("src", data.val[i].kongsi_img);

              if (data.val[i].kongsi_type_id == 4) {
                document.getElementById('detail_data').style.display = 'block';
                document.getElementById('detail_data_price').style.display = 'block';
                document.getElementById('sub_type').style.display = 'block';
                search_data_branch(data.val[i].kongsi_id);
                search_data_price(data.val[i].kongsi_id);
                document.getElementById('promo1').innerHTML = 'Harga '+data.val[i].promo1_name;
                document.getElementById('promo2').innerHTML = 'Harga '+data.val[i].promo2_name;
                document.getElementById("i_name_promo1").value = data.val[i].promo1_name;
                document.getElementById("i_name_promo2").value = data.val[i].promo2_name;
                document.getElementById("reservation").value = data.val[i].promo1_date;
                document.getElementById("reservation2").value = data.val[i].promo2_date;
              }else{
                document.getElementById('detail_data').style.display = 'none';
                document.getElementById('sub_type').style.display = 'none';
              }

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function edit_data_branch(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Kongsi/load_data_where_branch/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $("#i_spg").append('<option value="'+data.val[i].spg_id+'" selected>'+data.val[i].spg_name+'</option>');
              $('input[name="i_branch"]').val(data.val[i].kongsi_branch_name);
              $('input[name="i_branch_address"]').val(data.val[i].kongsi_branch_address);
              $('input[name="i_branch_id"]').val(data.val[i].kongsi_branch_id);

            }
          }
        });
      }

    function edit_data_price(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Kongsi/load_data_where_price/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $('input[name="i_price"]').val(data.val[i].kongsi_price_value);
              $('input[name="i_promo1"]').val(data.val[i].kongsi_price_promo1);
              $('input[name="i_promo2"]').val(data.val[i].kongsi_price_promo2);
              $('input[name="i_price_id"]').val(data.val[i].kongsi_price_id);

            }
          }
        });
      }

      function delete_data_price(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Kongsi/delete_data_price',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_price(id_new);
                  }
                }
            });
        }
        
    }

    function select_list_type() {
        $('#i_type2').select2({
          placeholder: 'Pilih Type',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Kongsi/load_data_select_type/',
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

      function select_list_type2() {
        $('#i_type_sub').select2({
          placeholder: 'Pilih Type',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Kongsi/load_data_select_type/',
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

      function select_list_city() {
        $('#i_city2').select2({
          placeholder: 'Pilih Wilayah',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Location/load_data_select_location/',
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
        $('#i_type2 option').remove();
        $('#i_type_sub option').remove();
        $('#i_city2 option').remove();
        $('#i_category option').remove();
        $('#img_kongsi').attr('src', '');
        document.getElementById('detail_data').style.display = 'none';
        document.getElementById('detail_data_price').style.display = 'none';
        document.getElementById('sub_type').style.display = 'none';
      }

      function select_list_spg() {
        $('#i_spg').select2({
          placeholder: 'Pilih SPG',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Spg/load_data_select_spg/',
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

      function select_list_category() {
        $('#i_category').select2({
          placeholder: 'Pilih Kategori',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Kongsi/load_data_select_category/',
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

      function select_list_item() {
        $('#i_item').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item/',
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

      

      function reset3(){
        $('#i_spg option').remove();
        $('input[name="i_branch"]').val("");
        $('input[name="i_branch_address"]').val("");
        $('input[name="i_branch_id"]').val("");
      }

      function reset4(){
        $('#i_item option').remove();
        $('input[name="i_price"]').val("");
        $('input[name="i_promo1"]').val("");
        $('input[name="i_promo2"]').val("");
        $('input[name="i_price_id"]').val("");
      }

      function delete_data_branch(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Kongsi/delete_data_branch',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_branch(id_new);
                  }
                }
            });
        }
        
    }

    function get_type(id){
      if (id == 4) {
        document.getElementById('sub_type').style.display = 'block';
      }else{
        document.getElementById('sub_type').style.display = 'none';
      }
      
    }

    function search_data_category() { 
        $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Kongsi/load_data_category/'
            },
            "columns": [
              {"name": "kongsi_category_id"},
              {"name": "kongsi_category_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function save_category(){
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Kongsi/action_data_category/',
          data : $( "#formcategory" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset5();
              search_data_category();
            } 
          }
        });
    }

    function delete_data_category(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Kongsi/delete_data_category',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset5();
                    search_data_category();

                  }
                }
            });
        }
        
    }

    function edit_data_category(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Kongsi/load_data_where_category/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_category_id").value               = data.val[i].kongsi_category_id;
              document.getElementById("i_category_name").value             = data.val[i].kongsi_category_name;

            }
          }
        });

    }

    function reset5(){
      document.getElementById("i_category_id").value = '';
      document.getElementById("i_category_name").value = '';
    }
</script>
</body>
</html>