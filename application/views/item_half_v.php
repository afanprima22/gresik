<style type="text/css">
  .money{
    text-align: right;
  }
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list" data-toggle="tab">List Data Campuran</a></li>
        <li><a href="#list2" data-toggle="tab">List Data Lagistar</a></li>
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
                                <th>Nama Barang Setengah jadi</th>
                                <th>Berat Perbuah</th>
                                <th>Jenis</th>
                                <th>Harga Netto</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

        </div>

        <div class="tab-pane" id="list2">
            <div class="box-inner">
                <div class="box-content">
                    <div id="create" class="alert alert-success" style="display: none;"><h4><i class="glyphicon glyphicon-check"></i> Sukses!</h4>Data telah Disimpan.</div>
                    <div id="update" class="alert alert-info" style="display: none;"><h4><i class="glyphicon glyphicon-info-sign"></i> Sukses!</h4>Data telah Direvisi.</div>
                    <div id="delete" class="alert alert-danger" style="display: none;"><h4><i class="glyphicon glyphicon-ban-circle"></i> Sukses!</h4>Data telah Dihapus.</div>
                    <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Nama Barang Setengah jadi</th>
                                <th>Berat Perbuah</th>
                                <th>Jenis</th>
                                <th>Harga Netto</th>
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
                            <label>Kode</label>
                            <input type="text" class="form-control" name="i_code" id="i_code" placeholder="Masukkan Kode" value="" >
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="">
                          </div>
                          <div class="form-group">
                            <label>Nama Barang Jadi</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Barang Jadi" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Berat Perbuah</label>
                            <input type="number" class="form-control" name="i_weight" id="i_weight" placeholder="Masukkan Berat Perbuah" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Berat RN</label>
                            <input type="number" class="form-control" name="i_weight_rn" id="i_weight_rn" placeholder="Masukkan Berat RN" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Jenis Barang</label>
                            <select class="form-control select2" name="i_type" id="i_type" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Jenis Satuan</label>
                            <select class="form-control select2" name="i_unit" id="i_unit" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Type Bahan</label>
                            <select class="form-control select2" name="i_material_type" id="i_material_type" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                              <label>
                                <input type="radio" name="i_status" id="status1" value="0" >
                              </label>
                              <label for="status1">
                                Baru &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_status" id="status2" value="1" >
                              </label >
                              <label for="status2">
                                Tidak Baru
                              </label>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Isi Per Satuan</label>
                            <input type="number" class="form-control" name="i_qty_per_unit" id="i_qty_per_unit" placeholder="Masukkan Berat RN" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Qty Stock</label>
                            <input type="number" class="form-control" name="i_stock" id="i_stock" placeholder="Masukkan Qty Stock" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Harga 1</label>
                            <input type="text" class="form-control money" name="i_price1" id="i_price1" placeholder="Masukkan Harga 1" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Harga 2</label>
                            <input type="text" class="form-control money" name="i_price2" id="i_price2" placeholder="Masukkan Harga 2" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Harga Netto</label>
                            <input type="text" class="form-control money" name="i_netto" id="i_netto" placeholder="Masukkan harga Netto" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Biaya Pokok</label>
                            <input type="text" class="form-control money" name="i_cost" id="i_cost" placeholder="Masukkan Biaya Pokok" required="required" value="">
                          </div>
                          
                        </div>
                        
                        <div class="col-md-12" id="detail_data">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Paket</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_color_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_color" placeholder="Masukkan Warna" onkeydown="if (event.keyCode == 13) { save_color(); }">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_dos_min" placeholder="Masukkan Qty Dos Min" onkeydown="if (event.keyCode == 13) { save_color(); }">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_dos_max" placeholder="Masukkan Qty Dos Max" onkeydown="if (event.keyCode == 13) { save_color(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_color()" class="btn btn-primary">Simpan Warna</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Warna</th>
                                      <th>Qty Dos Min</th>
                                      <th>Qty Dos Max</th>
                                      <th >Config</th>
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
                        <button type="button" onclick="reset(),reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>

                    </div>
                </form>

            </div>
        </div>

        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 70%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Data Rumus</h4><input type="text" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_formula_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <select class="form-control select2" name="i_material" id="i_material" style="width: 100%;">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_qty_formula" placeholder="Masukkan Jumlah Gram" onkeydown="if (event.keyCode == 13) { save_formula(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_formula()" class="btn btn-primary">Simpan Formula</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Bahan</th>
                                      <th>Jumlah Gram</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
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
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        search_data_lagistar();
        select_list_type();
        select_list_unit();
        search_data_color(0);
        select_list_material();
        select_list_type_material();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item_half/load_data/'
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_weight"},
              {"name": "item_type_name"},
              {"name": "item_netto"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_lagistar() { 
        $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item_half/load_data_lagistar/'
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_weight"},
              {"name": "item_type_name"},
              {"name": "item_netto"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_color(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item_half/load_data_color/'+id
            },
            "columns": [
              {"name": "item_detail_id"},
              {"name": "item_detail_color"},
              {"name": "item_detail_min"},
              {"name": "item_detail_max"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_formula(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Item_half/load_data_formula/'+id
            },
            "columns": [
              {"name": "item_formula_id"},
              {"name": "material_name"},
              {"name": "item_formula_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        $('input[name="i_detail_id"]').val(id);
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
          url  : '<?php echo base_url();?>Item_half/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              search_data_lagistar();
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
                url: '<?php echo base_url();?>Item_half/delete_data',
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
          url  : '<?php echo base_url();?>Item_half/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].item_id;
              document.getElementById("i_code").value           = data.val[i].item_code;
              document.getElementById("i_qty_per_unit").value           = data.val[i].item_per_unit;
              document.getElementById("i_name").value           = data.val[i].item_name;
              document.getElementById("i_weight").value         = data.val[i].item_weight;
              document.getElementById("i_weight_rn").value      = data.val[i].item_weight_rn;
              document.getElementById("i_price1").value         = data.val[i].item_price1;
              document.getElementById("i_price2").value         = data.val[i].item_price2;
              document.getElementById("i_netto").value          = data.val[i].item_netto;
              document.getElementById("i_cost").value           = data.val[i].item_cost;
              document.getElementById("i_stock").value          = data.val[i].item_stock;
              $("#i_unit").append('<option value="'+data.val[i].unit_id+'" selected>'+data.val[i].unit_name+'</option>');
              $("#i_type").append('<option value="'+data.val[i].item_type_id+'" selected>'+data.val[i].item_type_name+'</option>');
              $("#i_material_type").append('<option value="'+data.val[i].material_type_id+'" selected>'+data.val[i].material_type_name+'</option>');

              if (data.val[i].item_type == 0) {
                document.getElementById("status1").checked = true;
              } else{
                document.getElementById("status2").checked = true;
              }

              search_data_color(data.val[i].item_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_type() {
        $('#i_type').select2({
          placeholder: 'Pilih Type',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item_half/load_data_select_type/',
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

      function select_list_material() {
        $('#i_material').select2({
          placeholder: 'Pilih Material',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Material/load_data_select_material/',
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
      function select_list_type_material() {
        $('#i_material_type').select2({
          placeholder: 'Pilih Type Material',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Material_type/load_data_select_material_type/',
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

      function select_list_unit() {
        $('#i_unit').select2({
          placeholder: 'Pilih Satuan',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Unit/load_data_select_unit/',
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
        $('#i_unit option').remove();
        $('#i_category option').remove();
        $('#i_material_type option').remove();
        search_data_color(0);
      }

      function save_color(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Item_half/action_data_color/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_color(id_new);
            } 
          }
        });
      }

      function reset3(){
        $('input[name="i_color"]').val("");
        $('input[name="i_dos_min"]').val("");
        $('input[name="i_dos_max"]').val("");
        $('input[name="i_color_id"]').val("");
      }

      function edit_data_color(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item_half/load_data_where_color/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_color"]').val(data.val[i].item_detail_color);
              $('input[name="i_dos_min"]').val(data.val[i].item_detail_min);
              $('input[name="i_dos_max"]').val(data.val[i].item_detail_max);
              $('input[name="i_color_id"]').val(data.val[i].item_detail_id);

            }
          }
        });
      }

      function delete_data_color(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Item_half/delete_data_color',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_color(id_new);
                  }
                }
            });
        }
        
    }

    function save_formula(){
        var id = document.getElementById("i_detail_id").value;
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Item_half/action_data_formula/',
          data : $( "#form_modal" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset4();
              search_data_formula(id);
            } 
          }
        });
      }

      function reset4(){
        $('input[name="i_qty_formula"]').val("");
        $('input[name="i_formula_id"]').val("");
        $('#i_material option').remove();
      }

      function edit_data_formula(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item_half/load_data_where_formula/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_formula_id"]').val(data.val[i].item_formula_id);
              $('input[name="i_qty_formula"]').val(data.val[i].item_formula_qty);
              $("#i_material").append('<option value="'+data.val[i].material_id+'" selected>'+data.val[i].material_name+'</option>');

            }
          }
        });
      }

      function delete_data_formula(id_formula) {
        var id = document.getElementById("i_detail_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Item_half/delete_data_formula',
                data: 'id='+id_formula,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_formula(id_new);
                  }
                }
            });
        }
        
    }

    
</script>
</body>
</html>