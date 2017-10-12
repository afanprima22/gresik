<style type="text/css">
.fileinput-button input{position:absolute;top:0;right:0;margin:0;opacity:0;-ms-filter:'alpha(opacity=0)';font-size:15px;direction:ltr;cursor:pointer}
</style>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#list" data-toggle="tab">List Data</a></li>
        <li><a href="#form" data-toggle="tab">Form Data</a></li>
        <li><a href="#approve" data-toggle="tab">Approve</a></li>
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
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Nama Sales</th>
                                <th>Total Target</th>
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
                        <div class="col-md-5">
                          
                          <div class="form-group">
                            <label>Tanggal Forceast</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Forceast" value="" required="required">
                              <input type="hidden" class="form-control" name="i_id" id="i_id" value="">
                            </div>
                          </div>

                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label>Sales</label>
                            <select id="i_sales" class="form-control select2" style="width: 100%;" name="i_sales">
                            </select>
                          </div>

                        </div>
                        <div class="col-md-2">
                          <div class="form-group" style="padding-top: 20px;">
                            <a href="#myModal" class="btn btn-info" data-toggle="modal" onclick="search_detail()"><i class="glyphicon glyphicon-search"></i>View Detail</a>
                          </div>
                        </div>
                        <div id="detail_old" style="display: none;">
                          <div class="col-md-12">
                            <div class="box-inner">
                              <div class="box-header well" data-original-title="">
                                <h2>List Detail Barang Lama</h2>
                              </div>
                              <div class="box-content">
                                <div class="form-group">
                                  <table width="100%" id="table7" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                    <thead>
                                      <tr>
                                        <th>Barang</th>
                                        <th>Qty Target</th>
                                        <th>Qty Approve</th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12" style="padding-top: 5px;">
                            <div class="box-inner">
                              <div class="box-header well" data-original-title="">
                                <h2>List Detail Barang Lama</h2>
                              </div>
                              <div class="box-content">
                                <div class="form-group">
                                  <table width="100%" id="table8" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                    <thead>
                                      <tr>
                                        <th>Barang</th>
                                        <th>Qty Target</th>
                                        <th>Qty Approve</th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                        <div id="detail_new" style="display: none;">
                          <div class="col-md-12" style="padding-top: 5px;">
                            <div class="box-inner">
                              <div class="box-header well" data-original-title="">
                                <h2>List Barang Lama</h2>
                              </div>
                              <div class="box-content">
                                <div class="form-group">
                                  <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                    <thead>
                                      <tr>
                                        <th>Nama Barang</th>
                                        <th>Jenis Barang</th>
                                        <th>Qty Target</th>
                                      </tr>
                                    </thead>
                                  </table>
                                  <button type="button" onclick="save_filter(0)" class="btn btn-info">Simpan Sementara</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12" style="padding-top: 5px;">
                            <div class="box-inner">
                              <div class="box-header well" data-original-title="">
                                <h2>List Barang Baru</h2>
                              </div>
                              <div class="box-content">
                                <div class="form-group">
                                  <table width="100%" id="table4" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                    <thead>
                                      <tr>
                                        <th>Nama Barang</th>
                                        <th>Jenis Barang</th>
                                        <th>Qty Target</th>
                                      </tr>
                                    </thead>
                                  </table>
                                  <button type="button" onclick="save_filter(1)" class="btn btn-info">Simpan Sementara</button>
                                </div>
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

        <div class="tab-pane" id="approve">
          <div class="box-inner">
            <div class="row">
              <div class="col-md-8">
                <div class="box-inner">
                  <div class="box-content">
                          <table width="100%" id="table9" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                              <thead>
                                  <tr>
                                      <th>Lokasi</th>
                                      <th>Tanggal Approval</th>
                                      <th>User Approval</th>
                                      <th>Config</th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                    </div>
              </div>
              <div class="col-md-4">
                
                  <form id="formclass" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Tanggal Approval</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker2" name="i_date_approve" placeholder="Tanggal Approve" value="" required="required">
                              <input type="hidden" class="form-control" name="i_approve_id" id="i_approve_id" value="">
                            </div>
                        </div>
                        <div class="form-group">
                          <label>Lokasi</label>
                          <select id="i_location" class="form-control select2" style="width: 100%;" name="i_location">
                          </select>
                        </div>
                      </div>
                      <div class="box-footer text-right">
                        <button type="button" class="btn btn-primary" onclick="save_approval()" <?php if(isset($c)) echo $c;?>>Simpan</button>
                      </div>
                    </div>
                  </form>
                
              </div>
              <div id="detail_approve" class="col-md-12" style="display: none;padding-top: 20px;">
                <div class="box-inner">
                              <div class="box-header well" data-original-title="">
                                <h2>List Barang</h2>
                              </div>
                              <div class="box-content">
                                <div class="form-group">
                                  <table width="100%" id="table10" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                    <thead>
                                      <tr>
                                        <th>Nama Barang</th>
                                        <th>Jenis Barang</th>
                                        <th>Type Barang</th>
                                        <th>Qty Target</th>
                                      </tr>
                                    </thead>
                                  </table>
                                </div>
                              </div>
                            </div>
              </div>

            </div>
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
                      <h4>List Data Barang</h4>
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Barang Lama</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table5" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Jenis Barang</th>
                                      <th>Qty Target</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>

                    <div class="box-inner" style="padding-top: 5px;">
                            <div class="box-header well" data-original-title="">
                              <h2>List Barang Baru</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table6" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Jenis Barang</th>
                                      <th>Qty Target</th>
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

      <div style="padding-top: 50px;" class="modal fade" id="salesModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="formcategory" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Sales Terkait</h4>
                  </div>
                  <div class="modal-body">
                      
                              <div class="form-group">
                                <table width="100%" id="table11" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Nama Sales</th>
                                      <th>Qty Target</th>
                                    </tr>
                                  </thead>
                                </table>
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
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_sales();
        select_list_item();
        search_data_detail();
        search_data_detail_new();
        search_data_item();
        search_data_item_new();
        search_data_approval();
        select_list_location();

        document.getElementById('detail_new').style.display = 'block';
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data/'
            },
            "columns": [
              {"name": "forecast_code"},
              {"name": "forecast_date"},
              {"name": "sales_name"},
              {"name": "forecast_detail_qty"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    /*function search_data_detail(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "forecast_detail_qty"},
              {"name": "forecast_detail_approve"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }*/

    function search_data_item() { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_item/'+ 0
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_item_new() { 
        $('#table4').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_item/'+ 1
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail_modal() { 
      var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        $('#table5').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_detail_modal/'+ 0+'/'+id_new
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail_new_modal() { 
      var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        $('#table6').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_detail_modal/'+ 1+'/'+id_new
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail() { 
      var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        $('#table7').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_detail/'+ 0+'/'+id_new
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_detail_new() { 
      var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        $('#table8').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_detail/'+ 1+'/'+id_new
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_approval() { 

        $('#table9').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_approval/'
            },
            "columns": [
              {"name": "location_name"},
              {"name": "forecast_approve_date"},
              {"name": "item_type_name"},
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
          url  : '<?php echo base_url();?>forecast/action_data/',
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
                url: '<?php echo base_url();?>forecast/delete_data',
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
          url  : '<?php echo base_url();?>forecast/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].forecast_id;
              document.getElementById("datepicker").value = data.val[i].forecast_date;

              $("#i_sales").append('<option value="'+data.val[i].sales_id+'" selected>'+data.val[i].sales_name+'</option>');

              document.getElementById('detail_old').style.display = 'block';
              document.getElementById('detail_new').style.display = 'none';

              search_data_detail();
              search_data_detail_new();

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function select_list_sales() {
        $('#i_sales').select2({
          placeholder: 'Pilih Sales',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Sales/load_data_select_sales/',
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

      
      function reset2(){
        $('#i_sales option').remove();
        document.getElementById('detail_old').style.display = 'none';
        document.getElementById('detail_new').style.display = 'block';
      }

      function get_detail(id){
        if (id == 0) {
          document.getElementById('detail_barang').style.display = 'block';
          document.getElementById('detail_diskon').style.display = 'none';
        }else{
          document.getElementById('detail_barang').style.display = 'none';
          document.getElementById('detail_diskon').style.display = 'block';
        }
      }

      function save_detail(){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>forecast/action_data_detail/',
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
        $('#i_item option').remove();
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_detail_id"]').val("");
      }

    function edit_data_detail(id) {
      var url = "<?= base_url(); ?>";

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>forecast/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_qty"]').val(data.val[i].forecast_detail_qty);
              $('input[name="i_detail_id"]').val(data.val[i].forecast_detail_id);

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
                url: '<?php echo base_url();?>forecast/delete_data_detail',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset3();
                    search_data_detail(id_new);
                  }
                }
            });
        }
        
    }

    function save_filter(type){
        var id = document.getElementById("i_id").value;
        if (id) {
          var id_new = id;
        }else{
          var id_new = 0;
        }

        /*if (type == 0) {
          search_data_item_new();
        }else{
          search_data_item();
        }*/

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>forecast/action_data_filter/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              alert("Berhasil di simpan!");
            }
          }
        });
    }

    function search_detail(){
      search_data_detail_modal();
      search_data_detail_new_modal();
    }

    function get_approve(value,id){
      //alert(value+'-'+id)
      $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>forecast/get_approve/',
          data : {value:value,id:id},
          dataType : "json",
          success:function(data){
            
          }
        });

    }

    function save_approval(){
      //alert("test")
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>forecast/action_data_approval/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_approval();
            }
          }
        });

    }

    function delete_data_approve(id) {

        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>forecast/delete_data_approve',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    search_data_approval();
                  }
                }
            });
        }
        
    }

    function search_data_approve(date,id){
      //alert(id)
      document.getElementById('detail_approve').style.display = 'block';

        $('#table10').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_detail_approval/'+date+'/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_type_name"},
              {"name": "item_type"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

    }

    function update_approve(date,item_id,value,id){
      //alert(date+'/'+id+'/'+value)
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>forecast/action_data_detail_approval/',
          data : {id:id,date:date,value:value,item_id:item_id},
          dataType : "json",
          success:function(data){
            
          }
        });
    }

     function search_sales(item_id,month,year) { 

        $('#table11').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>forecast/load_data_sales/'+item_id+'/'+month+'/'+year
            },
            "columns": [
              {"name": "sales_name"},
              {"name": "forecast_detail_qty"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function select_list_location() {
        $('#i_location').select2({
          placeholder: 'Pilih Lokasi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>location/load_data_select_location/',
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