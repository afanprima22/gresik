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
                                <th>Nama Sperpart</th>
                                <th>Stok</th>
                                <th>Harga Terakhir</th>
                                <th>Satuan</th>
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
                            <label>Nama Sperpart</label>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Sperpart" required="required" value="" >
                          </div>
                          <div class="form-group">
                            <label>Harga Beli</label>
                            <input type="text" class="form-control money" name="i_price" id="i_price" placeholder="Masukkan Harga Beli" value="" required="required" style="text-align: right;">
                          </div>
                          <div class="form-group">
                            <label>Jenis Satuan</label>
                            <select class="form-control select2" name="i_unit" id="i_unit" style="width: 100%;" required="required">
                            </select>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Qty Stock</label>
                            <input type="number" class="form-control" name="i_stock" id="i_stock" placeholder="Masukkan Qty Stock" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Qty Minimum</label>
                            <input type="number" class="form-control" name="i_min" id="i_min" placeholder="Masukkan Qty Minimum" required="required" value="">
                          </div>
                          <div class="form-group">
                            <label>Qty Maximum</label>
                            <input type="number" class="form-control" name="i_max" id="i_max" placeholder="Masukkan Qty Maximum" value="" required="required">
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
        select_list_unit();

    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Sperpart/load_data/'
            },
            "columns": [
              {"name": "sperpart_name"},
              {"name": "sperpart_qty"},
              {"name": "sperpart_price"},
              {"name": "unit_name"},
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
          url  : '<?php echo base_url();?>Sperpart/action_data/',
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
                url: '<?php echo base_url();?>Sperpart/delete_data',
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
          url  : '<?php echo base_url();?>Sperpart/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].sperpart_id;
              document.getElementById("i_name").value = data.val[i].sperpart_name;
              document.getElementById("i_price").value = data.val[i].sperpart_price;
              document.getElementById("i_stock").value = data.val[i].sperpart_qty;
              document.getElementById("i_min").value = data.val[i].sperpart_min;
              document.getElementById("i_max").value = data.val[i].sperpart_max;
              $("#i_unit").append('<option value="'+data.val[i].unit_id+'" selected>'+data.val[i].unit_name+'</option>');
            }
          }
        });

        $('[href="#form"]').tab('show');
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
        $('#i_unit option').remove();
        $('input[name="i_id"]').val("");
      }


</script>
</body>
</html>