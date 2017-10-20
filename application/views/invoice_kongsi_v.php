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
                                <th>Kode Order Kongsi</th>
                                <th>Kongsi</th>
                                <th>Tanggal Cetak Invoice</th>
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
                            <label>Kongsi</label>
                            <select class="form-control select2" name="i_kongsi" id="i_kongsi" style="width: 100%;" required="required">
                            </select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" >
                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- <div class="form-group">
                            <label>Memo</label>
                            <select class="form-control select2" name="i_memo[]" id="selectmemo" style="width: 100%;">
                            </select>
                          </div> -->
                          <div class="form-group">
                            <label>Tanggal Order Kongsi</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Order Kongsi" value="" required="required">
                            </div>
                          </div>

                        </div>

                        <div class="col-md-12">
                          <div id="print_invoice_kongsi" style="display: none;float: left;">
                            <button type="button"  onclick="print_invoice_kongsi()" class="btn btn-info"><i class="glyphicon glyphicon-print"></i> invoice_kongsi</button>&nbsp;
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
                                    <!-- <tr>
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
                                    </tr> -->
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Qty Order</th>
                                      <th>Qty Yang Laku</th>
                                      <th>Qty Cetak Invoice</th>
                                      <th>Harga</th>
                                      <th>Diskon %</th>
                                      <th>Total</th>
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
                                        <input type="number" placeholder="%" class="form-control" name="i_discount2" id="i_discount2" onchange="update_discount2(this.value)" style=" text-align: right;">
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
        select_list_kongsi();
        //select_list_spg();
        //select_list_item();
        //search_data_detail(0);
        //get_memo();
        //select_list_material();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Invoice_kongsi/load_data/'
            },
            "columns": [
              {"name": "invoice_kongsi_code"},
              {"name": "kongsi_name"},
              {"name": "invoice_kongsi_date"},
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
              url: '<?php echo base_url();?>Invoice_kongsi/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "order_kongsi_detail_qty"},
              {"name": "laku"},
              {"name": "invoice_kongsi_detail_qty_print"},
              {"name": "order_kongsi_detail_price"},
              {"name": "invoice_kongsi_detail_discount"},
              {"name": "invoice_kongsi_detail_total","orderable": false,"searchable": false},
              //{"name": "action","orderable": false,"searchable": false, "className": "text-center"}
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
          url  : '<?php echo base_url();?>Invoice_kongsi/action_data/',
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
    
    function update_qty_print(id){
      var id2 = document.getElementById("i_id").value;
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Invoice_kongsi/update_qty_print/'+id,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_detail(id2);
              get_grand_total(id2);
            } 
          }
        });
    }

    function update_discount(id){
      var id2 = document.getElementById("i_id").value;
      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Invoice_kongsi/update_discount/'+id,
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              search_data_detail(id2);
              get_grand_total(id2);
            } 
          }
        });
    }
    
    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Invoice_kongsi/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            reset2();
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value             = data.val[i].invoice_kongsi_id;
              document.getElementById("datepicker").value           = data.val[i].invoice_kongsi_date;
              document.getElementById("i_discount2").value           = data.val[i].invoice_kongsi_discount;
              $("#i_kongsi").append('<option value="'+data.val[i].kongsi_id+'" selected>'+data.val[i].kongsi_name+'</option>');
              
              
              document.getElementById('detail_data').style.display = 'block';
              search_data_detail(data.val[i].invoice_kongsi_id);

               /*document.getElementById('print_sj').style.display = 'block';
              if (data.val[i].invoice_kongsi_sj == 1) {
                document.getElementById('print_invoice_kongsi').style.display = 'block';
              }*/
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Invoice_kongsi/delete_data',
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


    function select_list_kongsi() {
        $('#i_kongsi').select2({
          placeholder: 'Pilih kongsi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>kongsi/load_data_select_kongsi/',
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
        $('#i_spg option').remove();
        $('input[name="i_id"]').val("");
        $('#i_kongsi option').remove();
        $('#selectmemo option').remove();
        document.getElementById('detail_data').style.display = 'none';
      }

    function get_grand_total(id){

        var discount = 0;

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Invoice_kongsi/get_grand_total/',
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

    /*function print_invoice_kongsi(){
      var id = document.getElementById("i_id").value;

      window.open('<?php echo base_url();?>Invoice_kongsi/print_invoice_kongsi_pdf?id='+id);
      //alert(id)
    }

    function print_sj(){
      var id = document.getElementById("i_id").value;

      window.open('<?php echo base_url();?>Invoice_kongsi/print_surat_jalan_pdf?id='+id);

      //alert(id)
    }*/

    function update_discount2(value){
      var id = document.getElementById("i_id").value;

      $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Invoice_kongsi/update_discount2/',
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