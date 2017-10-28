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
                                <th>Tanggal Periode</th>
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
                              <label>Tanggal Laporan</label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="glyphicon glyphicon-calendar"></i>
                                </div>
                                  <input type="text" placeholder="Masukkan Tanggal Laporan" name="i_date_report" class="form-control pull-right" id="datepicker" value="">
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Tanggal Periode Awal</label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="glyphicon glyphicon-calendar"></i>
                                </div>
                                  <input type="hidden" class="form-control" name="i_id" id="i_id" >
                                  <input type="text" placeholder="Masukkan Tanggal Periode awal" name="i_date1" class="form-control pull-right" id="datepicker2" value="" required>
                              </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                              <label>Tanggal Periode Akhir</label>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="glyphicon glyphicon-calendar"></i>
                                </div>
                                  <input type="text" placeholder="Masukkan Tanggal Periode Akhir" name="i_date2" class="form-control pull-right" id="datepicker3" value="" required>
                              </div>
                            </div>
                            <div class="form-group">
                            <label>Opsi :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(1)" name="i_type" id="inlineRadio1" value="1"> Wilayah
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_payment(2)" name="i_type" id="inlineRadio2" value="2"> Customer
                            </label>
                          </div>
                          <div id="nomor_card" style="display: none;">
                            <div class="form-group">
                              <label>Pilih Provinsi</label>
                              <select class="form-control select2" onchange="search_invoice(this.value),select_list_kab(this.value)" name="i_prov" id="i_prov" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                              <label>Pilih Kabupaten</label>
                              <select class="form-control select2" onchange="search_invoice(this.value),select_list_kec(this.value)" name="i_kab" id="i_kab" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                              <label>Pilih Kecamatan</label>
                              <select class="form-control select2" onchange="search_invoice(this.value),select_list_kel(this.value)" name="i_kec" id="i_kec" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                              <label>Pilih Kelurahan</label>
                              <select class="form-control select2" onchange="search_invoice(this.value)" name="i_kel" id="i_kel" style="width: 100%;"></select>
                            </div>
                          </div>

                          <div id="nomor_card2" style="display: none;">
                            <div class="form-group">
                            <label>Pilih Customer</label>
                            <select class="form-control select2" onchange="search_invoice2(this.value)" name="i_customer" id="i_customer" style="width: 100%;"></select>
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
                                      <th>Kode Penjualan</th>
                                      <th>Nominal</th>
                                      <th>Opsi</th>
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
        
        <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Penjualan</h4><input type="hidden" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                      <div class="box-inner">
                            
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%" id="table3" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                                  <thead>
                                    <tr>
                                      <th>Nama Barang</th>
                                      <th>Harga</th>
                                      <th>Jumlah Barang</th>
                                      <th>Diskon</th>
                                      <th>Total</th>
                                    </tr>
                                  </thead>
                                </table>
                              </div>
                            </div>
                          </div>
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
        select_list_customer();
        select_list_prov();
        select_list_kab();
        select_list_kec();
        select_list_kel();
        
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_sales/load_data/'
            },
            "columns": [
              {"name": "report_sales_date"},
              {"name": "report_sales_date1.' - '.report_sales_date2"},
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
              url: '<?php echo base_url();?>Report_sales/load_data_detail/'+id
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "nota_detail_price"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

      function search_invoice(id){
        var id1 =  document.getElementById("datepicker3").value;
        var id2 =  document.getElementById("datepicker2").value;
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_sales/load_data_invoice?id='+id+'&id1='+id1+'&id2='+id2,
              data : "id2="+id2,
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "nota_detail_price"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
      }

      function search_invoice2(id){
        var id1 =  document.getElementById("datepicker3").value;
        var id2 =  document.getElementById("datepicker2").value;
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_sales/load_data_invoice2?id='+id+'&id1='+id1+'&id2='+id2,
              data : "id2="+id2,
            },
            "columns": [
              {"name": "nota_code"},
              {"name": "nota_detail_price"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
      }

      function search_data_detail_nota(id) { 
        $('#table3').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_sales/load_data_detail_nota/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "nota_detail_price"},
              {"name": "nota_detail_qty"},
              {"name": "nota_detail_discount"},
              {"name": "nota_detail_price*nota_detail_qty"},
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
          url  : '<?php echo base_url();?>Report_sales/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              reset2()
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

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Report_sales/delete_data',
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
          url  : '<?php echo base_url();?>Report_sales/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].report_sales_id;
              document.getElementById("datepicker").value = data.val[i].report_sales_date;
              document.getElementById("datepicker2").value = data.val[i].report_sales_date1;
              document.getElementById("datepicker3").value = data.val[i].report_sales_date2;

              if (data.val[i].report_sales_type == '1') {
                document.getElementById("inlineRadio1").checked = true;
                document.getElementById('nomor_card').style.display = 'block';
                document.getElementById('nomor_card2').style.display = 'none';
                $("#i_prov").append('<option value="'+data.val[i].location_id+'" selected>'+data.val[i].prov+'</option>');
                $("#i_kab").append('<option value="'+data.val[i].location_id2+'" selected>'+data.val[i].kab+'</option>');
                $("#i_kec").append('<option value="'+data.val[i].location_id3+'" selected>'+data.val[i].kec+'</option>');
                $("#i_kel").append('<option value="'+data.val[i].location_id4+'" selected>'+data.val[i].kel+'</option>');
               // search_invoice(data.val[i].city_id);
              } else if (data.val[i].report_sales_type == '2') {
                document.getElementById("inlineRadio2").checked = true;
                document.getElementById('nomor_card').style.display = 'none';
                document.getElementById('nomor_card2').style.display = 'block';
                $("#i_customer").append('<option value="'+data.val[i].customer_id+'" selected>'+data.val[i].customer_name+'</option>');
                //search_invoice2(data.val[i].customer_id);
              }
              search_data_detail(data.val[i].report_sales_id)

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

      function reset2(){
        $('input[name="i_id"]').val("");
        $('input[name="i_date1"]').val("");
        $('input[name="i_date2"]').val("");
        $('input[name="i_date_report"]').val("");
        $('#i_prov option').remove();
        $('#i_kab option').remove();
        $('#i_kec option').remove();
        $('#i_kel option').remove();
        $('#i_customer option').remove();
        search_data_detail(0);
         document.getElementById('nomor_card').style.display = 'none';
         document.getElementById('nomor_card2').style.display = 'none';
      }

      function type_payment(id){

      if (id == 1) {
        document.getElementById('nomor_card').style.display = 'block';
         document.getElementById('nomor_card2').style.display = 'none';
      }else{
        document.getElementById('nomor_card').style.display = 'none';
        document.getElementById('nomor_card2').style.display = 'block';
      }

      /*$.ajax({
        type: 'POST',
        url: '<?=site_url('nota/read_coa')?>',
        data: {id:id},
        dataType: 'json',
        success: function(data){
          $('#i_coa').html(data);
        } 
      });*/

      
    }

    function select_list_prov() {
        $('#i_prov').select2({
          placeholder: 'Pilih Provinsi',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Report_sales/load_data_select_provinsi',
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

      function select_list_kab(id) {
        $('#i_kab').select2({
          placeholder: 'Pilih Kabupaten',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Report_sales/load_data_select_kabupaten/'+id,
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

      function select_list_kec(id) {
        $('#i_kec').select2({
          placeholder: 'Pilih Kecamatan',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Report_sales/load_data_select_kecamatan/'+id,
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

      function select_list_kel(id) {
        $('#i_kel').select2({
          placeholder: 'Pilih Kelurahan',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Report_sales/load_data_select_kelurahan/'+id,
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
            url: '<?php echo base_url();?>Report_sales/load_data_select_customer',
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