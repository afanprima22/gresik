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
                                <th>Kode Nota Pajak</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
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
                            <label>Id Nota Pajak (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="" style="width: 20%;">
                          </div>
                          <div class="form-group">
                            <label>Customer</label>
                            <select class="form-control select2" name="i_customer" id="i_customer" style="width: 100%;" required="required" onchange="get_nota(this.value)">
                            </select>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nota</label>
                            <select class="form-control select2" name="i_nota[]" id="selectnota" style="width: 100%;" required="required">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Nota Pajak</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Nota Pajak" value="" required="required">
                            </div>
                          </div>

                        </div>
                        
                        <div class="col-md-12" id="detail_data" style="display: none;">
                          <div class="box-inner">
                            <div class="box-header well" data-original-title="">
                              <h2>List Detail</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table2" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Barang</th>
                                      <th>Harga</th>
                                      <th>Qty Nota</th>
                                      <th>Qty Pajak</th>
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

    </div>
</div>
<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
        //select_list_nota();
        search_data_detail(0);
        select_list_customer();
        get_nota();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>nota_tax/load_data/'
            },
            "columns": [
              {"name": "nota_tax_code"},
              {"name": "customer_name"},
              {"name": "nota_tax_date"},
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
              url: '<?php echo base_url();?>nota_tax/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "nota_tax_detail_price"},
              {"name": "nota_tax_detail_qty"},
              {"name": "nota_tax_detail_tax"}
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
          url  : '<?php echo base_url();?>nota_tax/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2();
              search_data();
              if (data.alert=='1') {
                document.getElementById('create').style.display = 'block';
                document.getElementById('update').style.display = 'none';
                document.getElementById('delete').style.display = 'none';
                edit_data(data.id);
              }else if(data.alert=='2'){
                document.getElementById('create').style.display = 'none';
                document.getElementById('update').style.display = 'block';
                document.getElementById('delete').style.display = 'none';
                $('[href="#list"]').tab('show');
              }
            } 
          }
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Nota_tax/delete_data',
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
          url  : '<?php echo base_url();?>Nota_tax/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset2();
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].nota_tax_id;
              document.getElementById("datepicker").value       = data.val[i].nota_tax_date;

              //$("#i_nota").append('<option value="'+data.val[i].nota_id+'" selected>'+data.val[i].nota_code+'</option>');
              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
              for(var j=0; j<data.val[i].notas.val2.length; j++){
                if (data.val[i].notas.val2[j].id != '') {
                  $("#selectnota").append('<option value="'+data.val[i].notas.val2[j].id+'" selected>'+data.val[i].notas.val2[j].text+'</option>');
                }
              }

              document.getElementById('detail_data').style.display = 'block';
              search_data_detail(data.val[i].nota_tax_id);
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function get_nota(id) {
        $('#selectnota').select2({
          placeholder: 'Pilih Nota',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Nota/load_data_select_nota/'+id,
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
          placeholder: 'Pilih Customer',
          multiple: false,
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
     
      function reset2(){
        $('#selectnota option').remove();
        $('#i_customer option').remove();
        document.getElementById('detail_data').style.display = 'none';
        search_data_detail(0);
      }

      function edit_tax(id,value){
        //alert(value);
        $.ajax({
          url: '<?php echo base_url();?>Nota_tax/update_tax',
          data: {id:id,value:value},
          type: 'POST',
          dataType: 'json',
          success: function (data) {
          
          }
        });
      }

</script>
</body>
</html>