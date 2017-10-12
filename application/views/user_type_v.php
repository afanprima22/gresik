<style type="text/css">
  .form_category { 
  /*background: #E5EFD5; */
  background-color:#FFC;
  font-weight: bold; 
  color: #666; 
  padding: 5px 5px 5px 15px; 
  font-size: 11px; 
  border:1px solid #e8e8e8;
}
</style>
<div class="box-inner">  
  <div class="row">
    <div class="box col-md-4">
      <div class="box-inner">
                <div class="box-content">
                    <table width="100%" id="table1" class="table table-striped table-bordered bootstrap-datatable datatable responsive">
                        <thead>
                            <tr>
                                <th>Nama user_type</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                    </table>
                </div>                
            </div>
    </div>
    <div class="box col-md-8">

                <form id="formall" role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="box-content">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Id Divisi (Auto)</label>
                            <input type="text" class="form-control" name="i_id" id="i_id" placeholder="Auto" value="" readonly="">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Nama Biaya Sales</label>
                            <input type="text" class="form-control" name="i_name" id="i_name" placeholder="Masukkan Nama Biaya Sales" required="required" value="" >
                          </div>     
                        </div>
                        <div class="col-md-12">
                          <div class="form_category col-md-9" >Menu</div>
                          <div class="form_category col-md-3" style="text-align:center">Hak Akses</div>
                        </div>
                        <div class="col-md-12">
                          <div style="padding-top:10px;" class="form-group" >
                            <label class="control-label col-md-9" for="name" style="text-align:left;"></label>
                            <div class="col-md-3">
                              <p style="font-size:20px;"><strong>&nbsp;C &nbsp;&nbsp;R &nbsp;&nbsp;&nbsp;U &nbsp;&nbsp;D</strong></p>
                            </div>
                          </div>
                          <? 
                          $list_menu = $this->g_mod->list_menu(0);
                          foreach($list_menu as $row): 
                          ?>
                            <div class="form-group">
                            <label class="control-label col-md-9" for="name" style="text-align:left;"><?=$row['side_menu_name']?></label>
                            </div>
                          <?
                          foreach($this->g_mod->list_menu($row['side_menu_id']) as $row2):
                          ?>
                            <div class="form-group" >
                              <label class="control-label col-md-9 " for="name" style="text-align:left; padding-left:5em;"><?=$row2['side_menu_name']?></label>
                              <? if($row2['side_menu_url'] != '#'){?>
                                <div class="col-md-3" style="text-align: center;">
                                  <input id="c<?=$row2['side_menu_id']?>" name="permit<?=$row2['side_menu_id']?>[]" type="checkbox" value="c">&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input id="r<?=$row2['side_menu_id']?>" name="permit<?=$row2['side_menu_id']?>[]" type="checkbox" value="r">&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input id="u<?=$row2['side_menu_id']?>" name="permit<?=$row2['side_menu_id']?>[]" type="checkbox" value="u">&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input id="d<?=$row2['side_menu_id']?>" name="permit<?=$row2['side_menu_id']?>[]" type="checkbox" value="d">
                                </div>
                              <? }?>
                            </div>
                                                
                          <?
                          foreach($this->g_mod->list_menu($row2['side_menu_id']) as $row3):
                          ?>
                        
                          <div class="form-group">
                            <label class="control-label col-md-9" for="name2" style="text-align:left; padding-left:10em;"><?=$row3['side_menu_name']?></label>
                            <? if($row3['side_menu_url'] != '#'){?>
                            <div class="col-md-3" style="text-align: center;">
                                 <input id="c<?=$row3['side_menu_id']?>" name="permit<?=$row3['side_menu_id']?>[]" type="checkbox" value="c" >&nbsp;&nbsp;&nbsp;&nbsp;
                                 <input id="r<?=$row3['side_menu_id']?>" name="permit<?=$row3['side_menu_id']?>[]" type="checkbox" value="r" >&nbsp;&nbsp;&nbsp;&nbsp;
                                 <input id="u<?=$row3['side_menu_id']?>" name="permit<?=$row3['side_menu_id']?>[]" type="checkbox" value="u" >&nbsp;&nbsp;&nbsp;&nbsp;
                                 <input id="d<?=$row3['side_menu_id']?>" name="permit<?=$row3['side_menu_id']?>[]" type="checkbox" value="d" >&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                                                        
                            <? }?>
                          </div>
                          <?
                          endforeach;
                        endforeach;
                      endforeach; 
                      ?>
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

<?php $this->load->view('layout/footer');?>
<script type="text/javascript">
    $(document).ready(function(){
        search_data();
    });

    function search_data() { 
        $('#table1').DataTable({
            destroy: true,
            "processing": true,
            "serverSide": true,
            ajax: {
              url: '<?php echo base_url();?>User_type/load_data/'
            },
            "columns": [
              {"name": "user_type_name"},
              {"name": "action","orderable": false,"searchable": false, "className": "text-center"}
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
          url  : '<?php echo base_url();?>User_type/action_data/',
          data : $( "#formall" ).serialize(),
          dataType : "json",
          success:function(data){
            if(data.status=='200'){
              reset();
              search_data();
            } 
          }
        });
    }

    function delete_data(id) {
        var a = confirm("Anda yakin ingin menghapus record ini ?");
        if(a==true){
            $.ajax({
                url: '<?php echo base_url();?>User_type/delete_data',
                data: 'id='+id,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                  if (data.status=='200') {
                    reset();
                    search_data();

                  }
                }
            });
        }
        
    }

    function edit_data(id) {
        $.ajax({
          type : "GET",
          url  : '<?php echo base_url();?>User_type/load_data_where/',
          data : "id="+id,
          dataType : "json",
          success:function(data){
            for(var i=0; i<data.val.length;i++){
              document.getElementById("i_id").value = data.val[i].user_type_id;
              document.getElementById("i_name").value = data.val[i].user_type_name;
            }

            for(var i=0; i<data.valmenu.length;i++){

              var permit = data.valmenu[i].permit_acces;

              var c = permit.indexOf("c");
              var r = permit.indexOf("r");
              var u = permit.indexOf("u");
              var d = permit.indexOf("d");
              

              if (c != -1) {
                document.getElementById("c"+data.valmenu[i].side_menu_id).checked = true;
              }
              if (r != -1) {
                document.getElementById("r"+data.valmenu[i].side_menu_id).checked = true;
              }
              if (u != -1) {
                document.getElementById("u"+data.valmenu[i].side_menu_id).checked = true;
              }
              if (d != -1) {
                document.getElementById("d"+data.valmenu[i].side_menu_id).checked = true;
              }
            }
          }
        });
    }
</script>
</body>
</html>