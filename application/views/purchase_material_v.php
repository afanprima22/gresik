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
                                <th>Kode Pemebelian</th>
                                <th>Partner</th>
                                <th>Tanggal Pembelian</th>
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
                            <label>Partner</label>
                            <select class="form-control select2" name="i_partner" id="i_partner" style="width: 100%;" required="required" >
                            </select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Pembelian</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Pembelian" value="" required="required">
                            </div>
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
                                    <!--<tr>
                                      <td colspan="7">
                                        <div class="form-group">
                                          <label>Pilih Type :</label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_detail(1)" name="i_type" id="inlineRadio1" value="1"> Barang jadi
                                          </label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_detail(2)" name="i_type" id="inlineRadio2" value="2"> Barang Set jadi
                                          </label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_detail(3)" name="i_type" id="inlineRadio3" value="3"> Sperpart
                                          </label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="type_detail(4)" name="i_type" id="inlineRadio4" value="4"> Material
                                          </label>
                                        </div>
                                      </td>
                                    </tr>-->
                                    <tr>
                                      <td><input type="text" class="form-control" name="i_detail_id" placeholder="Auto" readonly=""></td>
                                      <td>
                                        <input type="text" class="form-control" name="i_detail_type" placeholder="Auto" readonly="">
                                      </td>
                                      <td>
                                        <div id="item" style="display: none;">
                                          <div class="col-md-6">
                                            <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value),get_item_price(this.value)">
                                            </select>
                                          </div>
                                          <div class="col-md-6" >
                                            <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;">
                                            </select>
                                          </div>
                                        </div>
                                        <div id="sperpart" style="display: none;">
                                          <select id="i_sperpart" class="form-control select2" name="i_sperpart" style="width: 100%;" onchange="get_sperpart_price(this.value)">
                                          </select>
                                        </div>
                                        <div id="material" >
                                          <select id="i_material" class="form-control select2" name="i_material" style="width: 100%;" onchange="get_material_price(this.value)">
                                          </select>
                                        </div>
                                      </td>
                                      <td><input type="number" class="form-control" name="i_detail_qty" placeholder="Masukkan Qty" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                      <td><input type="number" class="form-control" name="i_detail_discount" placeholder="Masukkan Discount" onkeydown="if (event.keyCode == 13) { save_detail(); }"></td>
                                      <td>
                                        <input type="text" class="form-control money" name="i_detail_price" placeholder="Masukkan Harga" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Id</th>
                                      <th>Type</th>
                                      <th>Keterangan</th>
                                      <th>Qty</th>
                                      <th>Discount</th>
                                      <th>Harga</th>
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
                        <button type="button" onclick="reset(),reset2(),reset3()" class="btn btn-warning">Batal</button>
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
      //alert("test");
        search_data();
        select_list_partner();
        //select_list_item();
        search_data_detail(0);
        select_list_material();
        select_list_sperpart();
    });

    function type_detail(id){

    if (id == 1 || id == 2) {
      document.getElementById('item').style.display     = 'block';
      document.getElementById('sperpart').style.display = 'none';
      document.getElementById('material').style.display = 'none';
        
      select_list_item_type(id);
    }else if(id == 3){
      document.getElementById('item').style.display     = 'none';
      document.getElementById('sperpart').style.display = 'block';
      document.getElementById('material').style.display = 'none';
    }else if(id == 4){
      document.getElementById('item').style.display     = 'none';
      document.getElementById('sperpart').style.display = 'none';
      document.getElementById('material').style.display = 'block';
    }
    
    $('select[name="i_item"]').val(0);
    $('select[name="i_item_detail"]').val(0);
    $('select[name="i_sperpart"]').val(0);
    $('select[name="i_material"]').val(0);

  }

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Purchase_material/load_data/'
            },
            "columns": [
              {"name": "purchase_code"},
              {"name": "partner_name"},
              {"name": "purchase_date"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Purchase_material/load_data_detail/'+id
            },
            "columns": [
              {"name": "purchase_detail_id"},
              {"name": "keterangan","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "type","orderable": false,"searchable": false, "className": "text-center"},
              {"name": "purchase_detail_qty"},
              {"name": "purchase_detail_discount"},
              {"name": "purchase_detail_price"},
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
          url  : '<?php echo base_url();?>Purchase_material/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              reset3();
              search_data();
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
            $('[href="#list"]').tab('show'); 
          }          
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Purchase_material/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
                    reset2();
                    reset3();
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
          url  : '<?php echo base_url();?>Purchase_material/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].purchase_id;
              document.getElementById("datepicker").value           = data.val[i].purchase_date;
              $("#i_partner").append('<option value="'+data.val[i].partner_id+'" selected>'+data.val[i].partner_name+'</option>');
              search_data_detail(data.val[i].purchase_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_partner() {
        $('#i_partner').select2({
          placeholder: 'Pilih Partner',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Partner/load_data_select_partner/',
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

      function select_list_sperpart() {
        $('#i_sperpart').select2({
          placeholder: 'Pilih Sperpart',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Sperpart/load_data_select_sperpart/',
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

      function select_list_item_type(id) {
        $('#i_item').select2({
          placeholder: 'Pilih Barang Jadi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item_type/'+id,
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

      function get_item(id) {
        $('#i_item_detail').select2({
          placeholder: 'Pilih Warna',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_item_detail/'+id,
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
        $('#i_partner option').remove();
      }

      function save_detail(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        //alert(id);

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Purchase_material/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              search_data_detail(id_new);
            } 
          }
        });
      }

      function reset3(){
        $('input[name="i_detail_id"]').val("");
        $('#i_item option').remove();
        $('#i_item_detail option').remove();
        $('#i_sperpart option').remove();
        $('#i_material option').remove();
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_detail_type"]').val("");
        $('input[name="i_detail_discount"]').val("");
        $('input[name="i_detail_price"]').val("");

        search_data_detail(0);
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Purchase_material/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            //reset3();
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].purchase_detail_id);
              $('input[name="i_detail_qty"]').val(data.val[i].purchase_detail_qty);
              $('input[name="i_detail_discount"]').val(data.val[i].purchase_detail_discount);
              $('input[name="i_detail_price"]').val(data.val[i].purchase_detail_price);
              

              if (data.val[i].purchase_detail_type == 1) {
                $("#i_item").append('<option value="'+data.val[i].item_so_id+'" selected>'+data.val[i].item_so_name+'</option>');
                $("#i_item_detail").append('<option value="'+data.val[i].purchase_detail_data_id+'" selected>'+data.val[i].item_so_detail_color+'</option>');
                document.getElementById('item').style.display     = 'block';
                document.getElementById('sperpart').style.display = 'none';
                document.getElementById('material').style.display = 'none';
                document.getElementById("inlineRadio1").checked = true;
              }else if (data.val[i].purchase_detail_type == 2) {
                $("#i_item").append('<option value="'+data.val[i].item_half_id+'" selected>'+data.val[i].item_half_name+'</option>');
                $("#i_item_detail").append('<option value="'+data.val[i].purchase_detail_data_id+'" selected>'+data.val[i].item_half_detail_color+'</option>');
                document.getElementById('item').style.display     = 'block';
                document.getElementById('sperpart').style.display = 'none';
                document.getElementById('material').style.display = 'none';
                document.getElementById("inlineRadio2").checked = true;
              }else if (data.val[i].purchase_detail_type == 3) {
                $("#i_sperpart").append('<option value="'+data.val[i].purchase_detail_data_id+'" selected>'+data.val[i].sperpart_name+'</option>');
                document.getElementById('item').style.display     = 'none';
                document.getElementById('sperpart').style.display = 'block';
                document.getElementById('material').style.display = 'none';
                document.getElementById("inlineRadio3").checked = true;
              }else if (data.val[i].purchase_detail_type == 4) {
                $("#i_material").append('<option value="'+data.val[i].purchase_detail_data_id+'" selected>'+data.val[i].material_name+'</option>');
                document.getElementById('item').style.display     = 'none';
                document.getElementById('sperpart').style.display = 'none';
                document.getElementById('material').style.display = 'block';
                document.getElementById("inlineRadio4").checked = true;
              }


            }
          }
        });
      }

      function delete_data_detail(id_detail) {
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Purchase_material/delete_data_detail',
                data: 'id='+id_detail,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_detail(id_new);
                  }
                }
            });
        }
        
    }

    function get_item_price(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $('input[name="i_detail_price"]').val(data.val[i].item_netto);
            }
          }
        });
    }

    function get_sperpart_price(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Sperpart/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $('input[name="i_detail_price"]').val(data.val[i].sperpart_price);
            }
          }
        });
    }

    function get_material_price(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Material/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
               $('input[name="i_detail_price"]').val(data.val[i].material_price);
            }
          }
        });
    }

</script>
</body>
</html>