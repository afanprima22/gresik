<!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Main Menu</li>

                        <?
                       
                        $menu_lv1 = $this->g_mod->list_menu_lv1(1);
                        
                        foreach($menu_lv1 as $row):
                        $menu_lv2 = $this->g_mod->parent_menu($this->session->userdata('user_id'),$row['side_menu_id']);
                        ?>
                          <li class="<? if($menu_lv2){?>accordion<? }else{?>ajax-link<? }?>">
                            <a href="<?=site_url($row['side_menu_url'])?>">
                              <i class="<?=$row['side_menu_icon']?>"></i><span> <?=$row['side_menu_name']?></span>
                              <? if($menu_lv2){?><span class="pull-right-container">
                                <i class="fa fa-angle-left"></i>
                                </span><? }?></a>
                                <? if($menu_lv2){?><ul class="nav nav-pills nav-stacked"><?}

                                foreach($menu_lv2 as $row2):
                                $menu_lv3 = $this->g_mod->parent_menu($this->session->userdata('user_id'),$row2['side_menu_id']);
                                   ?>
                                <li class="<? if($menu_lv3){?>accordion<? }else{?>ajax-link<? }?>"><a href="<?=site_url($row2['side_menu_url'])?>"><i class="fa fa-circle-o"></i><?=$row2['side_menu_name']?>
                                <? if($menu_lv3){?><span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i></span><? }?></a>
                                    <? if($menu_lv3){?><ul class="nav nav-pills nav-stacked"><? }?>
                                      <? 
                             
                             foreach($menu_lv3 as $row3):
                             ?>
                             <li><a href="<?=site_url($row3['side_menu_url'])?>"><i class="fa fa-circle-o"></i><?=$row3['side_menu_name']?></a></li>
                             <?
                             endforeach;
                             ?>
                                       <? if($menu_lv3){?></ul><? }?>
                                   </li>
                           <?
                                   endforeach;
                                   ?>
                                   <? if($menu_lv2){?></ul><? }?>
                               </li>
                        <?
                        endforeach;
                        ?>

                       
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->