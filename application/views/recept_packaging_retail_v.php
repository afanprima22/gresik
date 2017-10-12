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
                                <th>Code Packaging</th>
                                <th>Tanggal Penerimaan</th>
                                <th>Kode Penerimaan Packaging</th>
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
                            <label>Code Packaging</label>
                            <select class="form-control select2"  onchange="search_data_packaging_detail_item(this.value),hapus()" name="i_code" id="i_code" style="width: 100%;" required="required" value=""></select>
                          </div>
                        </div>
                      <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal Penerimaan Packaging</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Penerimaan" value="" required="required">
                            </div>
                          </div>
                          
                        
                      </div>
                        
                        <div class="col-md-12" id="detail_data_item">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Id</th>
                                      <th>Barang - Warna</th>
                                      <th>Eceran</th>
                                      <th>Qty yang Disimpan</th>
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
                        <button type="button" onclick="reset2()" class="btn btn-warning">Batal</button>
                        <button type="submit"  class="btn btn-primary" <?php if(isset($c)) echo $c;?>>Simpan</button>
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
        search_data_detail(0);
        select_list_code();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>recept_packaging_retail/load_data/'
            },
            "columns": [
              {"name": "packaging_id"},
              {"name": "recept_packaging_retail_date"},
              {"name": "recept_packaging_retail_code"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

    }

    function search_data_detail(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>recept_packaging_retail/load_data_detail/'+id,
            },
            
          
            "columns": [
              {"name": "recept_packaging_retail_detail_id"},
              {"name": "item_name.' - '.item_detail_color"},
              {"name": "packaging_retail"},
              {"name": "recept_packaging_detail_qty"},
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
              
        });
    }

    function search_data_packaging_detail_item(id) { 
      if (!id) {
        var id=0;
      };
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>recept_packaging_retail/load_data_detail_item/'+id
            },
            "columns": [
              {"name": "packaging_detail_item_id"},
              {"name": "item_name"},
              {"name": "packaging_retail"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>recept_packaging_retail/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].recept_packaging_retail_id;
              document.getElementById("datepicker").value           = data.val[i].recept_packaging_retail_date;

              $("#i_code").append('<option value="'+data.val[i].packaging_id+'" selected>'+data.val[i].packaging_code+'</option>');
              search_data_detail(data.val[i].recept_packaging_retail_id);
              document.getElementById('detail_data_item').style.display = 'block';
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    $("#formall").submit(function(event){
        if ($("#formall").valid()==true) {
          action_data();
        }
        return false;
      });

    function action_data(){
      save_detail();
      save_stock();
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>recept_packaging_retail/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              
              search_data_detail(0);
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
          url  : '<?php echo base_url();?>recept_packaging_retail/action_data_detail/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              //search_data_detail(id_new);
              
            } 
          }
        });
    }
    function save_stock(){
        var id = document.getElementById("i_code").value;

        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>recept_packaging_retail/action_data_stock/'+id,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              
            } 
          }
        });
    }


    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>recept_packaging_retail/delete_data',
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
               url: '<?php echo base_url();?>recept_packaging_retail/delete_data_detail',
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

    function hapus() {
      var id = document.getElementById("i_id").value;
      $.ajax({
        url: '<?php echo base_url();?>recept_packaging_retail/hapus'+id,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
          if (data.status=='200') {
          }
        }
      });
    }

    function select_list_code() {
        $('#i_code').select2({
          placeholder: 'Pilih Code Packaging',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>packaging/load_data_select_code/',
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
      $("#i_code option").remove();
      $('input[name="i_code"]').val("");
      $('input[name="i_date"]').val("");
      $('input[name="i_id"]').val("");
      document.getElementById('detail_data_item').style.display = 'block';
      search_data_detail(0);
      hapus();
    }

    function cek_data(id,value,value2){
      if (id>value) {
        alert("Tidak Boleh Melebihi jumlah Yang Dipakai");
        search_data_packaging_detail_item(value2);

      };
    }

</script>
</body>
</html>