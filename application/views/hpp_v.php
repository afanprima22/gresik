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
                                <th>Nama Divisi</th>
                                <th>Leader DIvisi</th>
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
                    <label>Pilih Barang :</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_id(1)" name="i_type" id="inlineRadio2" value="option2"> Barang Jadi
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <label>
                                <input type="radio" onclick="type_id(2)" name="i_type" id="inlineRadio3" value="option3"> Barang Setengah jadi
                            </label>

                      <div id="item" style="display: none;">
                            <div class="form-group" >
                              <label>Barang Jadi</label>
                              <select class="form-control select2" onchange="get_item(this.value)" name="i_item" id="i_item" style="width: 40%;" onchange="get_item(this.value)">
                              </select>
                            </div>
                          </div>
                          <div id="item_half" style="display: none;">
                            <div class="form-group" >
                              <label>Barang Setengah Jadi</label>
                              <select class="form-control select2" onchange="get_item_half(this.value)" name="i_item_half" id="i_item_half" style="width: 40%;" onchange="get_item(this.value)">
                              </select>
                            </div>
                          </div>

                      <div class="row">

                      <div class="col-md-12">
                          <div class="box-inner">
                            <div align="center" class="box-header well" data-original-title="">
                              <h2 align="center">Hitung Nilai X</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Berat Barang</label>
                                      <input type="number" class="form-control" name="x_weight" id="x_weight" value="" placeholder="Masukkan Bahan Per Kg">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Harga Bahan</label>
                                      <input type="number" class="form-control" name="x_bahan" id="x_bahan" value="" onchange="bahan(this.value)" placeholder="Masukkan harga bahan">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Persentase</label>
                                      <input type="number" class="form-control" name="x_persen" id="x_persen" value="2" readonly="">
                                    </div>
                                  </div>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                        <br>&nbsp;

                        <div class="col-md-12">
                          <div class="box-inner">
                            <div align="center" class="box-header well" data-original-title="">
                              <h2 align="center">Hitung Nilai Y</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Nilai X</label>
                                      <input type="number" class="form-control" name="i_X" id="i_X" placeholder="Variable X" required="required" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Berat Barang</label>
                                      <input type="number" class="form-control" name="y_weight" id="y_weight" placeholder="Masukkan berat barang" required="required" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>1000</label>
                                      <input type="number" class="form-control" name="y_1000" id="y_1000" required="required" value="1000" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Lusin</label>
                                      <input type="number" class="form-control" name="y_lusin" id="y_lusin" onchange="lusin(this.value)" placeholder="Masukkan lusin per pcs" required="required" value="" >
                                      <input type="number" class="form-control" name="i_Y" id="i_Y" value="" >
                                    </div>                          
                                  </div>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <br>&nbsp;
                        <div class="col-md-12">
                          <div class="box-inner">
                            <div align="center" class="box-header well" data-original-title="">
                              <h2 align="center">Hitung Nilai Z</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Cycle Time</label>
                                      <input type="number" class="form-control"  name="z_cycle" id="z_cycle" placeholder="Masukkan cycle time" required="required" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Berat Barang</label>
                                      <input type="number" class="form-control" name="z_weight" id="z_weight" value="" placeholder="Masukkan Berat Barang(dalam gram)">
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Beban mesin</label>
                                      <input type="number" class="form-control" onchange="beban(this.value)" name="z_beban" id="z_beban" value="" placeholder="Masukkan Beban Mesin Perhari">
                                    </div>                          
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Hasil Ongkos Mesin</label>
                                      <input type="number" class="form-control" name="i_V" id="i_V" value="" placeholder="hasil ongkos mesin(V)" readonly="">
                                    </div>
                                  </div>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                        <br>&nbsp;
                        <div class="col-md-12">
                          <div class="box-inner">
                            <div align="center" class="box-header well" data-original-title="">
                              <h2 align="center">Hitung Nilai W</h2>
                            </div>
                            <div class="box-content">
                              <div class="form-group">
                                <table width="100%">
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Berat Bahan</label>
                                      <input type="number" class="form-control" name="w_bahan" id="w_bahan" placeholder="Masukkan Berat Bahan" required="required" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Lusin</label>
                                      <input type="number" class="form-control" name="w_lusin" id="w_lusin" placeholder="Masukkan lusin Per pcs" required="required" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>Ongkos Mesin</label>
                                      <input type="number" class="form-control" name="w_V" id="w_V" placeholder="Masukkan ongkos mesin (V)" required="required" value="" >
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-group">
                                      <label>1000</label>
                                      <input type="number" class="form-control" name="w_1000" id="w_1000" readonly="" required="required" value="1000" >
                                    </div>                          
                                  </div>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>

                      
                    </div>
                      <div class="box-footer text-right">
                        <button type="button" onclick="reset()" class="btn btn-warning">Batal</button>
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
        //search_data();
        select_list_item();
        select_list_item_half();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>Division/load_data/'
            },
            "columns": [
              {"name": "division_name"},
              {"name": "division_leader"},
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
          url  : '<?php echo base_url();?>Division/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
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
                url: '<?php echo base_url();?>Division/delete_data',
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
          url  : '<?php echo base_url();?>Division/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].division_id;
              document.getElementById("i_name").value = data.val[i].division_name;
              document.getElementById("i_leader").value = data.val[i].division_leader;
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function get_item(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("y_weight").value = data.val[i].item_weight/1000;
              document.getElementById("x_weight").value = data.val[i].item_weight/1000;
              document.getElementById("z_weight").value = data.val[i].item_weight;
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function get_item_half(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>Item_half/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("y_weight").value = data.val[i].item_weight/1000;
              document.getElementById("x_weight").value = data.val[i].item_weight/1000;
              document.getElementById("z_weight").value = data.val[i].item_weight;
            }
          }
        });

        $('[href="#form"]').tab('show');
    }

    function type_id(id){

      if (id == 1) {
        document.getElementById('item').style.display = 'block';
        document.getElementById('item_half').style.display = 'none';
      }else{
        document.getElementById('item').style.display = 'none';
        document.getElementById('item_half').style.display = 'block';
      }
      
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


      //Nilai X
      function bahan(id){
        var berat = $('input[name="x_weight"]').val();
        var persen = $('input[name="x_persen"]').val();
        if (!berat) {
          var berat =0;
          
        };if (!persen) {
          var persen =0;
          
        };
        if (!id) {
          var id =0;
          
        };
        
        var total = (parseFloat(berat)*parseFloat(id));
        var persen2 = total*persen/100;
        var nilai = total+persen2;

        var subtotal = parseFloat(nilai);
      $('input[name="i_X"]').val(parseFloat(subtotal));
      $('input[name="w_bahan"]').val(parseFloat(berat));
      }

      //Nilai Y
      function lusin(id){
        var X = $('input[name="i_X"]').val();
        var berat = $('input[name="y_weight"]').val();
        var nilai = $('input[name="y_1000"]').val();
        if (!berat) {
          var berat =0;
          
        };if (!nilai) {
          var nilai =0;
          
        };if (!X) {
          var X =0;
          
        };
        if (!id) {
          var id =0;
          
        };
        
        var total = X*berat*id;
        var total2 = total / nilai;

        var subtotal = parseFloat(total2);
      $('input[name="i_Y"]').val(parseFloat(subtotal));
      $('input[name="w_lusin"]').val(parseFloat(id));
      }

      //Nilai Z
      function beban(id){
        var cycle = $('input[name="z_cycle"]').val();
        var berat = $('input[name="z_weight"]').val();
        if (!berat) {
          var berat =0;
          
        };if (!cycle) {
          var cycle =0;
          
        };
        if (!id) {
          var id =0;
          
        };
        
        var cycle2 = 86400/cycle;
        var berat2 = berat/1000;
        var total = cycle2 *berat2;
        var total2 = id / total;

        var subtotal = parseFloat(total2);
      $('input[name="i_V"]').val(parseFloat(subtotal));
      $('input[name="w_V"]').val(parseFloat(subtotal));
      }


</script>
</body>
</html>