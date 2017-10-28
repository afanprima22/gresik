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
                                <th>Nama Spg</th>
                                <th>Nama Cabang</th>
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

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Spg</label>
                            <select class="form-control select2" name="i_spg" id="i_spg" style="width: 100%;" required="required"></select>
                            <input type="hidden" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" >
                          </div>
                          
                          <div class="form-group">
                            <label>Bulan</label>
                            <select class="form-control select2" name="i_month" id="i_month" style="width: 100%;" required="required"></select>
                          </div>

                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Cabang</label>
                            <select class="form-control select2" name="i_branch" id="i_branch" style="width: 100%;" required="required"></select>
                          </div>
                          <!-- <div class="form-group">
                            <label>Tanggal Laporan</label>
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="i_date" placeholder="Tanggal Order Kongsi" value="" required="required">
                            </div>
                          </div> -->
                          
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
                                      <th>Jumlah order</th>
                                      <th>Jumlah Barang Yang Laku</th>
                                      <th width="10%">Config</th>
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

    <div style="padding-top: 50px;" class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" >

          <div class="modal-dialog" style="width: 50%;">
          <form id="form_modal" role="form" action="" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4>List Data Kategori</h4>
                      <input type="hidden" class="form-control" name="i_detail_id" id="i_detail_id" placeholder="Auto" readonly="">
                      <input type="hidden" class="form-control" name="i_master_id" id="i_master_id" placeholder="Auto" readonly="">
                      <input type="text" class="form-control" name="qty_order" id="qty_order" placeholder="Auto" readonly="">
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                       <div class="col-md-6">
                            <div class="form-group">
                              <label>Tanggal 1</label>
                              <input type="text" class="form-control" onchange="set_qty_order(this.value)" placeholder="Qty yang laku" name="date1" id="date1" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 3</label>
                              <input type="text" class="form-control"  onchange="set_qty_order3(this.value)" placeholder="Qty yang laku" name="date3" id="date3" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 5</label>
                              <input type="text" class="form-control"  onchange="set_qty_order5(this.value)" placeholder="Qty yang laku" name="date5" id="date5" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 7</label>
                              <input type="text" class="form-control"  onchange="set_qty_order7(this.value)" placeholder="Qty yang laku" name="date7" id="date7" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 9</label>
                              <input type="text" class="form-control"  onchange="set_qty_order9(this.value)" placeholder="Qty yang laku" name="date9" id="date9" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 11</label>
                              <input type="text" class="form-control"  onchange="set_qty_order11(this.value)" placeholder="Qty yang laku" name="date11" id="date11" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 13</label>
                              <input type="text" class="form-control"  onchange="set_qty_order13(this.value)" placeholder="Qty yang laku" name="date13" id="date13" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 15</label>
                              <input type="text" class="form-control"  onchange="set_qty_order15(this.value)" placeholder="Qty yang laku" name="date15" id="date15" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 17</label>
                              <input type="text" class="form-control"  onchange="set_qty_order17(this.value)" placeholder="Qty yang laku" name="date17" id="date17" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 19</label>
                              <input type="text" class="form-control"  onchange="set_qty_order19(this.value)" placeholder="Qty yang laku" name="date19" id="date19" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 21</label>
                              <input type="text" class="form-control"  onchange="set_qty_order21(this.value)" placeholder="Qty yang laku" name="date21" id="date21" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 23</label>
                              <input type="text" class="form-control"  onchange="set_qty_order23(this.value)" placeholder="Qty yang laku" name="date23" id="date23" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 25</label>
                              <input type="text" class="form-control"  onchange="set_qty_order25(this.value)" placeholder="Qty yang laku" name="date25" id="date25" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 27</label>
                              <input type="text" class="form-control"  onchange="set_qty_order27(this.value)" placeholder="Qty yang laku" name="date27" id="date27" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 29</label>
                              <input type="text" class="form-control"  onchange="set_qty_order29(this.value)" placeholder="Qty yang laku" name="date29" id="date29" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 31</label>
                              <input type="text" class="form-control"  onchange="set_qty_order31(this.value)" placeholder="Qty yang laku" name="date31" id="date31" value="">
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label>Tanggal 2</label>
                              <input type="text" class="form-control"  onchange="set_qty_order2(this.value)" placeholder="Qty yang laku" name="date2" id="date2" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 4</label>
                              <input type="text" class="form-control"  onchange="set_qty_order4(this.value)" placeholder="Qty yang laku" name="date4" id="date4" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 6</label>
                              <input type="text" class="form-control"  onchange="set_qty_order6(this.value)" placeholder="Qty yang laku" name="date6" id="date6" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 8</label>
                              <input type="text" class="form-control"  onchange="set_qty_order8(this.value)" placeholder="Qty yang laku" name="date8" id="date8" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 10</label>
                              <input type="text" class="form-control"  onchange="set_qty_order10(this.value)" placeholder="Qty yang laku" name="date10" id="date10" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 12</label>
                              <input type="text" class="form-control"  onchange="set_qty_order12(this.value)" placeholder="Qty yang laku" name="date12" id="date12" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 14</label>
                              <input type="text" class="form-control"  onchange="set_qty_order14(this.value)" placeholder="Qty yang laku" name="date14" id="date14" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 16</label>
                              <input type="text" class="form-control"  onchange="set_qty_order16(this.value)" placeholder="Qty yang laku" name="date16" id="date16" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 18</label>
                              <input type="text" class="form-control"  onchange="set_qty_order18(this.value)" placeholder="Qty yang laku" name="date18" id="date18" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 20</label>
                              <input type="text" class="form-control"  onchange="set_qty_order20(this.value)" placeholder="Qty yang laku" name="date20" id="date20" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 22</label>
                              <input type="text" class="form-control"  onchange="set_qty_order22(this.value)" placeholder="Qty yang laku" name="date22" id="date22" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 24</label>
                              <input type="text" class="form-control"  onchange="set_qty_order24(this.value)" placeholder="Qty yang laku" name="date24" id="date24" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 26</label>
                              <input type="text" class="form-control"  onchange="set_qty_order26(this.value)" placeholder="Qty yang laku" name="date26" id="date26" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 28</label>
                              <input type="text" class="form-control"  onchange="set_qty_order28(this.value)" placeholder="Qty yang laku" name="date28" id="date28" value="">
                            </div>
                            <div class="form-group">
                              <label>Tanggal 30</label>
                              <input type="text" class="form-control"  onchange="set_qty_order30(this.value)" placeholder="Qty yang laku" name="date30" id="date30" value="">
                            </div>
                            
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button"  onclick="action_data_qty_per_date()" class="btn btn-primary">Simpan</button>
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
        select_list_spg();
        select_list_branch();
        select_list_month();
        document.getElementById('detail_data').style.display = 'none';
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_spg/load_data/'
            },
            "columns": [
              {"name": "spg_name"},
              {"name": "kongsi_branch_name"},
              {"name": "report_spg_date"},
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
              url: '<?php echo base_url();?>Report_spg/load_data_detail/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "order_kongsi_detail_qty"},
              {"name": "laku"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }

    /*function search_item(id) { 
        $('#table2').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Report_spg/load_data_item/'+id
            },
            "columns": [
              {"name": "item_name"},
              {"name": "order_kongsi_detail_qty"},
              {"name": "laku"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
            ],
            "order": [
              [0, 'asc']
            ],
            "iDisplayLength": 10
        });
    }*/

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
          url  : '<?php echo base_url();?>Report_spg/action_data/',
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
                edit_data(data.id);
              }else if(data.alert=='2'){
                document.getElementById('create').style.display = 'none';
                document.getElementById('update').style.display = 'block';
                document.getElementById('delete').style.display = 'none';
              }
            } 
          }
        });
    }

    function action_data_qty_per_date(){
      var id = document.getElementById("i_detail_id").value;
      var id2 = document.getElementById("i_master_id").value;
        $.ajax({
          type : "POST",
          url  : '<?php echo base_url();?>Report_spg/action_data_qty_per_date/'+id,
          data : $( "#form_modal" ).serialize(),
          dataType : "json",
          success:function(data){
            $('#myModal').modal('hide');
            search_data_detail(id2);
          }
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>Report_spg/delete_data',
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
          url  : '<?php echo base_url();?>Report_spg/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].report_spg_id;
              //document.getElementById("datepicker").value = data.val[i].report_spg_date;

              $("#i_spg").append('<option value="'+data.val[i].spg_id+'" selected>'+data.val[i].spg_name+'</option>');
              $("#i_month").append('<option value="'+data.val[i].month_id+'" selected>'+data.val[i].month_name+'</option>');
              $("#i_branch").append('<option value="'+data.val[i].kongsi_branch_id+'" selected>'+data.val[i].kongsi_branch_name+'</option>');

                document.getElementById('detail_data').style.display = 'block';
                search_data_detail(data.val[i].report_spg_id)

            }
          }
        });

        $('[href="#form"]').tab('show');
    }

      function reset2(){
        $('#i_spg option').remove();
        $('#i_branch option').remove();
        $('#i_month option').remove();
        document.getElementById('detail_data').style.display = 'none';
      }

      function select_list_spg() {
        $('#i_spg').select2({
          placeholder: 'Pilih SPG',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Spg/load_data_select_spg/',
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

      function select_list_branch() {
        $('#i_branch').select2({
          placeholder: 'Pilih Cabang',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Report_spg/load_data_select_branch/',
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

      function select_list_month() {
        $('#i_month').select2({
          placeholder: 'Pilih Bulan',
          multiple: false,
          allowClear: true,
          ajax: {
            url: '<?php echo base_url();?>Report_spg/load_data_select_month/',
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

      
      function reset3(){
        $('#i_spg option').remove();
        $('input[name="i_branch"]').val("");
        $('input[name="i_branch_address"]').val("");
        $('input[name="i_branch_id"]').val("");
      }

      function search_data_qty_per_date(id,id2,id3){
        document.getElementById("i_detail_id").value             = id;
        document.getElementById("i_master_id").value             = id2;
        document.getElementById("qty_order").value             = id3;

        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Report_spg/load_data_where_qty_per_date/'+id,
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              $('input[name="date1"]').val(data.val[i].report_spg_detail_date1);
              $('input[name="date2"]').val(data.val[i].report_spg_detail_date2);
              $('input[name="date3"]').val(data.val[i].report_spg_detail_date3);
              $('input[name="date4"]').val(data.val[i].report_spg_detail_date4);
              $('input[name="date5"]').val(data.val[i].report_spg_detail_date5);
              $('input[name="date6"]').val(data.val[i].report_spg_detail_date6);
              $('input[name="date7"]').val(data.val[i].report_spg_detail_date7);
              $('input[name="date8"]').val(data.val[i].report_spg_detail_date8);
              $('input[name="date9"]').val(data.val[i].report_spg_detail_date9);
              $('input[name="date10"]').val(data.val[i].report_spg_detail_date10);
              $('input[name="date11"]').val(data.val[i].report_spg_detail_date11);
              $('input[name="date12"]').val(data.val[i].report_spg_detail_date12);
              $('input[name="date13"]').val(data.val[i].report_spg_detail_date13);
              $('input[name="date14"]').val(data.val[i].report_spg_detail_date14);
              $('input[name="date15"]').val(data.val[i].report_spg_detail_date15);
              $('input[name="date16"]').val(data.val[i].report_spg_detail_date16);
              $('input[name="date17"]').val(data.val[i].report_spg_detail_date17);
              $('input[name="date18"]').val(data.val[i].report_spg_detail_date18);
              $('input[name="date19"]').val(data.val[i].report_spg_detail_date19);
              $('input[name="date20"]').val(data.val[i].report_spg_detail_date20);
              $('input[name="date21"]').val(data.val[i].report_spg_detail_date21);
              $('input[name="date22"]').val(data.val[i].report_spg_detail_date22);
              $('input[name="date23"]').val(data.val[i].report_spg_detail_date23);
              $('input[name="date24"]').val(data.val[i].report_spg_detail_date24);
              $('input[name="date25"]').val(data.val[i].report_spg_detail_date25);
              $('input[name="date26"]').val(data.val[i].report_spg_detail_date26);
              $('input[name="date27"]').val(data.val[i].report_spg_detail_date27);
              $('input[name="date28"]').val(data.val[i].report_spg_detail_date28);
              $('input[name="date29"]').val(data.val[i].report_spg_detail_date29);
              $('input[name="date30"]').val(data.val[i].report_spg_detail_date30);
              $('input[name="date31"]').val(data.val[i].report_spg_detail_date31);

            }
          }
        });

      }

      /*Alert Sisa Order*/

      function set_qty_order(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
         $('input[name="date1"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order2(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date2"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order3(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date3"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order4(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date4"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order5(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date5"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order6(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date6"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order7(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date7"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order8(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date8"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order9(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date9"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order10(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date10"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order11(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date11"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order12(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date12"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order13(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date13"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order14(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date14"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order15(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date15"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order16(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date16"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order17(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date17"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order18(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date18"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order19(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date19"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order20(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date20"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order21(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date21"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order22(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date22"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order23(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date23"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order24(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date24"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order25(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date25"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order26(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date26"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order27(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date27"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order28(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date28"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order29(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date29"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order30(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date30"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      function set_qty_order31(id){
        var order = document.getElementById("qty_order").value;
        if (parseFloat(id)>parseFloat(order)) {
          alert("Tidak Boleh Lebih Dari Sisa Order");
          $('input[name="date31"]').val(0);
          var id = 0;
        }
        var value = parseFloat(order) - parseFloat(id);

        document.getElementById("qty_order").value = value;
      }

      
</script>
</body>
</html>