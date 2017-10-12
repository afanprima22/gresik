<style type="text/css">
.fileinput-button input{position:absolute;top:0;right:0;margin:0;opacity:0;-ms-filter:'alpha(opacity=0)';font-size:15px;direction:ltr;cursor:pointer}
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
                                <th>Nama Promo</th>
                                <th>Periode</th>
                                <th width="20%">Type Promo</th>
                                <th width="10%">Jumlah Diskon</th>
                                <th width="10%">Config</th>
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
                            <label>Type Discount:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" onclick="get_detail(0)" name="i_type" id="type1" value="0">
                              </label>
                              <label for="type1">
                                Bonus Barang &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" onclick="get_detail(1)" name="i_type" id="type2" value="1">
                              </label>
                              <label for="type2">
                                Diskon &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              
                          </div>
                          <div class="form-group" id="div_periode" style="display: none;">
                            <label>Periode Discount:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_periode" id="periode1" value="0">
                              </label>
                              <label for="periode1">
                                Per Nota &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_periode" id="periode2" value="1">
                              </label>
                              <label for="periode2">
                                Per Periode &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              
                          </div>   
                          <div class="form-group">
                            <label>Nama Promo</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Promo" required="required" value="">
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="">
                          </div>
                          <div class="form-group">
                            <label>Periode Promo</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="reservation" name="i_date" placeholder="Periode Promo" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Jumlah Diskon</label>
                            <input type="text" class="form-control" name="i_discount" id="i_discount" placeholder="Bonus Mencapai (%)" required="required" value="">
                          </div>

                        </div>
                        <div class="col-md-6">
                          <!--<div class="form-group">
                            <label>Status :&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                              <label>
                                <input type="radio" name="i_status" id="status1" value="Aktif">
                              </label>
                              <label for="status1">
                                Kategori &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                              </label>
                              <label>
                                <input type="radio" name="i_status" id="status2" value="Tidak Aktif">
                              </label >
                              <label for="status2">
                                Barang
                              </label>
                          </div>-->   
                          <div class="form-group">
                            <label>Wilayah</label>
                            <select id="i_city" class="form-control select2" style="width: 100%;" name="i_city[]">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Toko</label>
                            <select id="i_customer" class="form-control select2" style="width: 100%;" name="i_customer[]">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Kategori</label>
                            <select id="i_category" class="form-control select2" style="width: 100%;" name="i_category[]">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Barang</label>
                            <select id="i_item_multy" class="form-control select2" style="width: 100%;" name="i_item_multy[]">
                            </select>
                          </div>                          

                        </div>
                        
                        <div class="col-md-12" id="detail_barang" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Barang</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td colspan="4">
                                        <div class="form-group">
                                          <label>Pilih Type :</label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="select_list_item(0)" name="i_type_detail" id="inlineRadio1" value="0"> Barang Dalam
                                          </label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;
                                          <label>
                                              <input type="radio" onclick="select_list_item(1)" name="i_type_detail" id="inlineRadio2" value="1"> Barang Luar
                                          </label>
                                        </div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty_min_item" placeholder="Masukkan Qty Min Order">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control money" name="i_detail_diskon_item" placeholder="Masukkan Total Order">
                                      </td>
                                      <td>
                                        <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;">
                                        </select>
                                        <input type="hidden" class="form-control" name="i_detail_id">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty_item" placeholder="Masukkan Qty Bonus" onkeydown="if (event.keyCode == 13) { save_detail(1); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail(1)" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Qty Min Order</th>
                                      <th>Total Order</th>
                                      <th>Bonus Barang</th>
                                      <th>Qty Bonus</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-12" id="detail_diskon" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Diskon</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty_min_diskon" placeholder="Masukkan Qty Min Order">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control money" name="i_detail_diskon" placeholder="Masukkan Total Order">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty_diskon" placeholder="Masukkan Qty Diskon" onkeydown="if (event.keyCode == 13) { save_detail(2); }">
                                      </td>
                                      <td width="10%"><button type="button" onclick="save_detail(2)" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Qty Min Order</th>
                                      <th>Total Order</th>
                                      <th>Diskon %</th>
                                      <th>Config</th>
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
        select_list_city();
        select_list_customer();
        //select_list_item();
        select_list_cayegory();
        select_list_item_multy();
        search_data_item(0);
        search_data_dicount(0);
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>discount/load_data/'
            },
            "columns": [
              {"name": "discount_name"},
              {"name": "discount_date1"},
              {"name": "discount_type"},
              {"name": "discount_presentase"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_item(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>discount/load_data_item/'+id
            },
            "columns": [
              {"name": "discount_detail_qty"},
              {"name": "discount_detail_total"},
              {"name": "item_name","orderable": false,"searchable": false},
              {"name": "discount_detail_item"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_dicount(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>discount/load_data_discount/'+id
            },
            "columns": [
              {"name": "discount_detail_qty"},
              {"name": "discount_detail_total"},
              {"name": "discount_detail_persen"},
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
          url  : '<?php echo base_url();?>discount/action_data/',
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
          }
        });
    }


    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>discount/delete_data',
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
          url  : '<?php echo base_url();?>discount/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].discount_id;
              document.getElementById("i_name").value = data.val[i].discount_name;
              document.getElementById("i_discount").value = data.val[i].discount_presentase;
              document.getElementById("reservation").value = data.val[i].discount_date1+'-'+data.val[i].discount_date2;
              /*if (data.val[i].discount_status == 0) {
                document.getElementById("status1").checked = true;
              } else if (data.val[i].discount_status == 1) {
                document.getElementById("status2").checked = true;
              }*/
              if (data.val[i].discount_type == 0) {
                document.getElementById('detail_barang').style.display = 'block';
                document.getElementById('detail_diskon').style.display = 'none';
                document.getElementById("type1").checked = true;

                if (data.val[i].discount_periode == 0) {
                  document.getElementById("periode1").checked = true;
                } else {
                  document.getElementById("periode2").checked = true;
                } 

              } else if (data.val[i].discount_type == 1) {
                document.getElementById('detail_barang').style.display = 'none';
                document.getElementById('detail_diskon').style.display = 'block';
                document.getElementById("type2").checked = true;
              } 

              /*$("#i_city").append('<option value="'+data.val[i].city_id+'" selected>'+data.val[i].city_name+'</option>');
              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
              $("#i_category").append('<option value="'+data.val[i].category_item_id+'" selected>'+data.val[i].category_item_name+'</option>');*/

              for(var j=0; j<data.val[i].item.val2.length; j++){
                if (data.val[i].item.val2[j].id != '') {
                  $("#i_item_multy").append('<option value="'+data.val[i].item.val2[j].id+'" selected>'+data.val[i].item.val2[j].text+'</option>');
                }
              }

              for(var j=0; j<data.val[i].location.val2.length; j++){
                if (data.val[i].location.val2[j].id != '') {
                  $("#i_city").append('<option value="'+data.val[i].location.val2[j].id+'" selected>'+data.val[i].location.val2[j].text+'</option>');
                }
              }

              for(var j=0; j<data.val[i].customer.val2.length; j++){
                if (data.val[i].customer.val2[j].id != '') {
                  $("#i_customer").append('<option value="'+data.val[i].customer.val2[j].id+'" selected>'+data.val[i].customer.val2[j].text+'</option>');
                }
              }

              for(var j=0; j<data.val[i].category.val2.length; j++){
                if (data.val[i].category.val2[j].id != '') {
                  $("#i_category").append('<option value="'+data.val[i].category.val2[j].id+'" selected>'+data.val[i].category.val2[j].text+'</option>');
                }
              }

              search_data_item(data.val[i].discount_id);
              search_data_dicount(data.val[i].discount_id)
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_city() {
        $('#i_city').select2({
          placeholder: 'Pilih Semua Wilayah',
          multiple: true,
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

      function select_list_customer() {
        $('#i_customer').select2({
          placeholder: 'Pilih Semua Toko',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Customer/load_data_select_customer/',
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

      function select_list_item(id) {
        if (id == 0) {
          var ajax_url = '<?php echo base_url();?>Item/load_data_select_item/';
        }else{
          var ajax_url = '<?php echo base_url();?>Discount/load_data_select_item_luar/';
        }
        $('#i_item').select2({
          placeholder: 'Pilih Barang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: ajax_url,
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

      function select_list_cayegory() {
        $('#i_category').select2({
          placeholder: 'Pilih Semua Kategory',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item/load_data_select_category/',
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

      function select_list_item_multy() {
        $('#i_item_multy').select2({
          placeholder: 'Pilih Semua Barang',
          multiple: true,
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

      function reset2(){
        $('#i_city option').remove();
        $('#i_customer option').remove();
        $('#i_category option').remove();
        $('#i_item_multy option').remove();
        search_data_item(0);
        search_data_dicount(0);
      }

      function get_detail(id){
        if (id == 0) {
          document.getElementById('detail_barang').style.display = 'block';
          document.getElementById('detail_diskon').style.display = 'none';
          document.getElementById('div_periode').style.display = 'block';
        }else{
          document.getElementById('detail_barang').style.display = 'none';
          document.getElementById('detail_diskon').style.display = 'block';
          document.getElementById('div_periode').style.display = 'none';
        }
      }

      function save_detail(type){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>discount/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset3();
              if (type == 1) {
                search_data_item(id_new);
              }else{
                search_data_dicount(id_new);
              }
              
            }
          }
        });
    }

    function reset3(){
        $('#i_item option').remove();
        $('input[name="i_detail_qty_min_diskon"]').val("");
        $('input[name="i_detail_diskon"]').val("");
        $('input[name="i_detail_diskon_item"]').val("");
        $('input[name="i_detail_qty_item"]').val("");
        $('input[name="i_detail_qty_min_item"]').val("");
        $('input[name="i_detail_qty_diskon"]').val("");
        $('input[name="i_detail_id"]').val("");
      }

    function edit_data_detail(id) {
      var url = "<?= base_url(); ?>";

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>discount/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              
              $('input[name="i_detail_qty_item"]').val(data.val[i].discount_detail_item);
              $('input[name="i_detail_qty_diskon"]').val(data.val[i].discount_detail_persen);
              $('input[name="i_detail_id"]').val(data.val[i].discount_detail_id);

              if (document.getElementById("type1").checked == true) {
                $('input[name="i_detail_qty_min_item"]').val(data.val[i].discount_detail_qty);
                $('input[name="i_detail_diskon_item"]').val(data.val[i].discount_detail_total);
              }else{
                $('input[name="i_detail_qty_min_diskon"]').val(data.val[i].discount_detail_qty);
                $('input[name="i_detail_diskon"]').val(data.val[i].discount_detail_total);
              }
                

              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');

            }
          }
        });

    }

    function delete_data_detail(id) {

      var id_p = document.getElementById("i_id").value;
        if (id_p) {
          var id_new = id_p;
        }else{
          var id_new = 0;
        }

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>discount/delete_data_detail',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset3();
                    search_data_item(id_new);
                    search_data_dicount(id_new);
                  }
                }
            });
        }
        
    }
</script>
</body>
</html>