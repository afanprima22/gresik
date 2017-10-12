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
                                <th>Kode Order</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Warna</th>
                                <th>Qty</th>
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

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <input type="hidden" class="form-control" name="i_id" id="i_id" value="">
                            <label>Pilih Barang Orderan :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_order_production(1)" name="i_type" id="inlineRadio2" value="option2"> Barang Jadi
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_order_production(2)" name="i_type" id="inlineRadio3" value="option3"> Barang Setengah jadi
                            </label>
                          </div>
                          <div id="item" style="display: none;">
                            <div class="form-group" >
                              <label>Barang Jadi</label>
                              <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                              </select>
                            </div>
                          </div>
                          <div id="item_half" style="display: none;">
                            <div class="form-group" >
                              <label>Barang Setengah Jadi</label>
                              <select class="form-control select2" name="i_item_half" id="i_item_half" style="width: 100%;" onchange="get_item(this.value)">
                              </select>
                            </div>
                          </div>
                          <div class="form-group" >
                              <label>Warna</label>
                              <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;">
                              </select>
                            </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Order</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Order" value="" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control" name="i_qty" id="i_qty" placeholder="Masukkan Jumlah" required="required" value="">
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

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        select_list_item();
        select_list_item_half();
    });

    function type_order_production(id){

      if (id == 1) {
        document.getElementById('item').style.display = 'block';
        document.getElementById('item_half').style.display = 'none';
      }else{
        document.getElementById('item').style.display = 'none';
        document.getElementById('item_half').style.display = 'block';
      }
      
    }


    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>order_production/load_data/'
            },
            "columns": [
              {"name": "order_production_code"},
              {"name": "order_production_date"},
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "order_production_qty"},
              {"name": "order_production_status"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [5, 'asc']
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
          url  : '<?php echo base_url();?>order_production/action_data/',
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
                url: '<?php echo base_url();?>order_production/delete_data',
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
          url  : '<?php echo base_url();?>order_production/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value            = data.val[i].order_production_id;
              document.getElementById("datepicker").value      = data.val[i].order_production_date;
              document.getElementById("i_qty").value           = data.val[i].order_production_qty;
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');

              if (data.val[i].item_status == 1) {
                $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'block';
                document.getElementById('item_half').style.display = 'none';
                document.getElementById("inlineRadio2").checked = true;
              }

              if (data.val[i].item_status == 2) {
                $("#i_item_half").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
                document.getElementById('item').style.display = 'none';
                document.getElementById('item_half').style.display = 'block';
                document.getElementById("inlineRadio3").checked = true;
              }              
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

      function reset2(){
        $('#i_item option').remove();
        $('#i_item_half option').remove();
        $('#i_item_detail option').remove();
      }


      function select_list_item() {
        $('#i_item').select2({
          placeholder: 'Pilih Barang Jadi',
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

      function select_list_item_half() {
        $('#i_item_half').select2({
          placeholder: 'Pilih Barang Setengah Jadi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Item_half/load_data_select_item_half/',
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


</script>
</body>
</html>