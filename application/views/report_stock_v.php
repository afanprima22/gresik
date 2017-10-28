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
                                <th>Tanggal Laporan</th>
                                <th>Jenis Laporan</th>
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
                        <div class="form-group">
                            &nbsp;&nbsp;<label>&nbsp;&nbsp;Laporan :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(1)" name="i_type" id="inlineRadio1" value="1"> Stock Gudang
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(2)" name="i_type" id="inlineRadio2" value="2"> Stock Packaging
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(3)" name="i_type" id="inlineRadio3" value="3"> Stock Eceran
                            </label>
                          </div>
                        <div class="col-md-6">

                          <div class="form-group">
                            <label>Tanggal Laporan</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Laporan Stock" value="" required="required">
                              <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" >
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div id="gudang" style="display: none;">
                            <div class="form-group">
                              <label>Gudang</label>
                              <select class="form-control select2" onchange="search_data_stock(this.value)" name="i_warehouse" id="i_warehouse" style="width: 100%;"></select>
                            </div>
                          </div>

                          <div id="eceran" style="display: none;">
                            <div class="form-group">
                              <label>Gudang</label>
                              <select class="form-control select2" onchange="search_data_stock(this.value)" name="i_warehouse2" id="i_warehouse2" style="width: 100%;"></select>
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
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Warna</th>
                                      <th>Qty Stock</th>
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

    

</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_warehouse();
        select_list_warehouse2();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_stock/load_data/'
            },
            "columns": [
              {"name": "report_stock_date"},
              {"name": "type"},
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
              url: '<?php echo base_url();?>Report_stock/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "report_stock_detail_qty_stock"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_stock(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_stock/load_data_stock/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "stock_qty"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_stock_eceran(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_stock/load_data_stock/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "stock_qty"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function search_data_stock_packaging() { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_stock/load_data_stock_packaging/'
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "stock_qty"},
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
          url  : '<?php echo base_url();?>Report_stock/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
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
                url: '<?php echo base_url();?>Report_stock/delete_data',
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
          url  : '<?php echo base_url();?>Report_stock/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].report_stock_id;
              document.getElementById("datepicker").value = data.val[i].report_stock_date;
              
              if (data.val[i].report_stock_type == '1') {
                document.getElementById("inlineRadio1").checked = true;
                document.getElementById('gudang').style.display = 'block';
                document.getElementById('eceran').style.display = 'none';

                $("#i_warehouse").append('<option value="'+data.val[i].warehouse_id+'" selected>'+data.val[i].warehouse_name+'</option>');
              }else if (data.val[i].report_stock_type == '3') {
                document.getElementById("inlineRadio3").checked = true;
                document.getElementById('gudang').style.display = 'none';
                document.getElementById('eceran').style.display = 'block';

                $("#i_warehouse2").append('<option value="'+data.val[i].warehouse_id+'" selected>'+data.val[i].warehouse_name+'</option>');
              }else if (data.val[i].report_stock_type == '2'){
                document.getElementById("inlineRadio2").checked = true;
                document.getElementById('gudang').style.display = 'none';
                document.getElementById('eceran').style.display = 'none';
              }
                search_data_detail(data.val[i].report_stock_id);

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

      function reset2(){
        $('#i_warehouse option').remove();
        $('#i_warehouse2 option').remove();
        $('input[name="i_id"]').val("");
        $('input[name="i_date"]').val("");
        search_data_detail(0);
      }

      function select_list_warehouse() {
        $('#i_warehouse').select2({
          placeholder: 'Pilih Gudang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Warehouse/load_data_select_warehouse/',
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

      function select_list_warehouse2() {
        $('#i_warehouse2').select2({
          placeholder: 'Pilih Gudang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Warehouse/load_data_select_warehouse/',
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

    function type_payment(id){

      if (id == 1) {
        document.getElementById('gudang').style.display = 'block';
         document.getElementById('eceran').style.display = 'none';
         reset3();
      }else if (id == 2){
        document.getElementById('eceran').style.display = 'none';
        document.getElementById('gudang').style.display = 'none';
         search_data_stock_packaging();
      }else{
        document.getElementById('eceran').style.display = 'block';
        document.getElementById('gudang').style.display = 'none';
         reset3();
      }
    }

    function reset3(){
        $('#i_warehouse option').remove();
        $('#i_warehouse2 option').remove();
        search_data_detail(0);
      }

      
</script>
</body>
</html>