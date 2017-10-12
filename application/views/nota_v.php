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
                                <th>Kode nota</th>
                                <th>Customer</th>
                                <th>Sales</th>
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
                            <label>Customer</label>
                            <select class="form-control select2" name="i_customer" id="i_customer" style="width: 100%;" required="required" onchange="get_memo()">
                            </select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" >
                          </div>
                          <div class="form-group">
                            <label>Sales</label>
                            <select class="form-control select2" name="i_sales" id="i_sales" style="width: 100%;" required="required" onchange="get_memo()">
                            </select>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Memo</label>
                            <select class="form-control select2" name="i_memo[]" id="selectmemo" style="width: 100%;">
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Tanggal Nota</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Nota" value="" required="required">
                            </div>
                          </div>

                        </div>

                        <div class="col-md-12">
                          <div id="print_nota" style="display: none;float: left;">
                            <button type="button"  onclick="print_nota()" class="btn btn-info"><i class="glyphicon glyphicon-print"></i> Nota</button>&nbsp;
                          </div>
                          <div id="print_sj" style="display: none; float: left;">
                            <button type="button" onclick="print_sj()" class="btn btn-info"><i class="glyphicon glyphicon-print"></i> Surat Jalan</button>
                          </div>
                        </div>
                        
                        <div class="col-md-12">&nbsp;</div>

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
                                      <td>
                                        <select class="form-control select2" name="i_item" id="i_item" style="width: 100%;" onchange="get_item(this.value)">
                                        </select>
                                        <input type="hidden" class="form-control" name="i_detail_id" placeholder="Auto" readonly="">
                                      </td>
                                      <td>
                                        <select id="i_item_detail" class="form-control select2" name="i_item_detail" style="width: 100%;" onchange="get_price()">
                                        </select>
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="i_detail_price" placeholder="Auto" readonly="">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_qty" placeholder="Masukkan Qty" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control" name="i_detail_discount" placeholder="Masukkan Diskon" onkeydown="if (event.keyCode == 13) { save_detail(); }">
                                      </td>
                                      <td>&nbsp;</td>
                                      <td width="10%"><button type="button" onclick="save_detail()" class="btn btn-primary">Simpan Detail</button></td>
                                    </tr>
                                    <tr>
                                      <th>Barang</th>
                                      <th>Warna</th>
                                      <th>Harga</th>
                                      <th>Qty</th>
                                      <th>Diskon %</th>
                                      <th>Jml Harga</th>
                                      <th>Config</th>
                                    </tr>
                                  </thead>
                                  <tfoot>
                                    <tr>
                                      <th colspan="5"><div id="detail_discount_name"></div></th>
                                      <th colspan="2" style="text-align: right;"><div id="detail_discount_value"></div></th>
                                    </tr>
                                    <tr>
                                      <th colspan="5">Total Harga</th>
                                      <th colspan="2" align="right"><input type="text" class="form-control" name="grand_total" readonly="" style="border: none;background: transparent; text-align: right;"></th>
                                    </tr>
                                    <tr>
                                      <th colspan="5">Total Diskon</th>
                                      <th colspan="2" align="right"><input type="text" class="form-control" name="grand_diskon" readonly="" style="border: none;background: transparent; text-align: right;"></th>
                                    </tr>
                                    <tr>
                                      <th colspan="4">Diskon Global %</th>
                                      <th align="right">
                                        <input type="number" placeholder="%" class="form-control" name="i_discount" id="i_discount" onchange="update_discount(this.value)" style=" text-align: right;">
                                      </th>
                                      <th colspan="2" align="right"><input type="text" class="form-control" name="i_discount_jml" readonly="" style="border: none;background: transparent; text-align: right;"></th>
                                    </tr>
                                    <tr>
                                      <th colspan="5">Total Netto</th>
                                      <th colspan="2" align="right"><input type="text" class="form-control" name="grand_netto" readonly="" style="border: none;background: transparent; text-align: right;"></th>
                                    </tr>
                                  </tfoot>
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
        select_list_customer();
        select_list_sales();
        select_list_item();
        search_data_detail(0);
        get_memo();
        //select_list_material();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>nota/load_data/'
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "customer_name"},
              {"name": "sales_name"},
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
              url: '<?php echo base_url();?>nota/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "item_detail_color"},
              {"name": "nota_detail_price"},
              {"name": "nota_detail_qty"},
              {"name": "nota_detail_discount"},
              {"name": "nota_detail_total","orderable": false,"searchable": false},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });

        get_grand_total(id);
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
          url  : '<?php echo base_url();?>nota/action_data/',
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
                url: '<?php echo base_url();?>nota/delete_data',
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
          url  : '<?php echo base_url();?>nota/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset2();
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].nota_id;
              document.getElementById("datepicker").value           = data.val[i].nota_date;
              document.getElementById("i_discount").value             = data.val[i].nota_discount;
              $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
              $("#i_sales").append('<option value="'+data.val[i].sales_id+'" selected>'+data.val[i].sales_name+'</option>');
              
              for(var j=0; j<data.val[i].memos.val2.length; j++){
                if (data.val[i].memos.val2[j].id != '') {
                  $("#selectmemo").append('<option value="'+data.val[i].memos.val2[j].id+'" selected>'+data.val[i].memos.val2[j].text+'</option>');
                }
              }
              
              document.getElementById('detail_data').style.display = 'block';
              search_data_detail(data.val[i].nota_id);

               document.getElementById('print_sj').style.display = 'block';
              if (data.val[i].nota_sj == 1) {
                document.getElementById('print_nota').style.display = 'block';
              }
            }
          }
        });

        $('[href="#form"]').tab('show');
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

      function get_memo() {

        var sales_id = document.getElementById("i_sales").value;
        var customer_id = document.getElementById("i_customer").value;

        $('#selectmemo').select2({
          placeholder: 'Pilih Memo',
          multiple: true,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Memo/load_data_select_memo/'+customer_id+'/'+sales_id,
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
        $('#i_customer option').remove();
        $('#selectmemo option').remove();
        document.getElementById('detail_data').style.display = 'none';
        document.getElementById('print_nota').style.display = 'none';
        document.getElementById('print_sj').style.display = 'none';
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
          url  : '<?php echo base_url();?>nota/action_data_detail/',
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
        $('input[name="i_detail_qty"]').val("");
        $('input[name="i_detail_price"]').val("");
        $('input[name="i_detail_discount"]').val("");
      }

      function edit_data_detail(id){
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>nota/load_data_where_detail/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="i_detail_id"]').val(data.val[i].nota_detail_id);
              $('input[name="i_detail_qty"]').val(data.val[i].nota_detail_qty);
              $('input[name="i_detail_price"]').val(data.val[i].nota_detail_price);
              $('input[name="i_detail_discount"]').val(data.val[i].nota_detail_discount);
              $("#i_item").append('<option value="'+data.val[i].item_id+'" selected>'+data.val[i].item_name+'</option>');
              $("#i_item_detail").append('<option value="'+data.val[i].item_detail_id+'" selected>'+data.val[i].item_detail_color+'</option>');

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
                url: '<?php echo base_url();?>nota/delete_data_detail',
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

    function get_price(){

      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Nota/get_price/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            $('input[name="i_detail_price"]').val(data);
          }
        });
    }

    function get_grand_total(id){

        var discount = 0;

        /*$.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>nota/get_discount/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            var discount_name = "";
            var discount_value = "";
            for(var i=0; i<data.val.length;i++){
              discount_name += "Diskon "+data.val[i].discount_name+"<br>";
              discount_value += " "+ data.val[i].discount_detail_value_format +"<br>";

              discount += parseFloat(data.val[i].discount_detail_value);
            }

            document.getElementById("detail_discount_name").innerHTML = discount_name;
            document.getElementById("detail_discount_value").innerHTML = discount_value;
          }
        });*/

        //$("#detail_discount").load("<?= base_url()?>nota/get_discount/"+id);

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>nota/get_grand_total/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            var total_diskon = (data.total) - discount;
            var total_diskon = total_diskon.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

            var discount_global = (data.total) * (data.discount_global) / 100;

            var netto        = (data.total) - (data.discounts) - discount_global;
            var netto        = netto.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

            var discount_global = discount_global.toFixed(0).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

            $('input[name="i_discount_jml"]').val(discount_global);
            $('input[name="grand_total"]').val(data.total_format);
            $('input[name="grand_diskon"]').val(data.diskon_format);
            $('input[name="grand_netto"]').val(netto);
          }
        });
      }

    function print_nota(){
      var id = document.getElementById("i_id").value;

      window.open('<?php echo base_url();?>Nota/print_nota_pdf?id='+id);
      //alert(id)
    }

    function print_sj(){
      var id = document.getElementById("i_id").value;

      window.open('<?php echo base_url();?>Nota/print_surat_jalan_pdf?id='+id);

      //alert(id)
    }

    function update_discount(value){
      var id = document.getElementById("i_id").value;

      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Nota/update_discount/',
          data : {id:id,value:value},
          dataType : "json",
          success:function(data){
            get_grand_total(id);

            
          }
        });
    }

</script>
</body>
</html>