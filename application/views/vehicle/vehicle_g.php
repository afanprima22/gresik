<!-- The styles -->
<ul class="thumbnails gallery">
<? 
if ($query_galery<>false) {
  foreach($query_galery->result() as $val){?>
    <li>
      <div class="thumbnail">
        <button type="button" onclick="delete_galery(<?=$val->vehicle_galery_id?>)" class="btn btn-danger btn-xs">Remove</button>
        <a style="padding-top: 5px;" href="<?= base_url(); ?>images/vehicle/<?=$val->vehicle_galery_file?>" ><img src="<?= base_url(); ?>images/vehicle/<?=$val->vehicle_galery_file?>"></a>

      </div>
    </li>
<? 
  }
}
?>
</ul>
<script type="text/javascript">
  //gallery image controls example

    //gallery colorbox
    $('.thumbnail a').colorbox({
        rel: 'thumbnail a',
        transition: "elastic",
        maxWidth: "95%",
        maxHeight: "95%",
        slideshow: true
    });

    //gallery fullscreen
    $('#toggle-fullscreen').button().click(function () {
        var button = $(this), root = document.documentElement;
        if (!button.hasClass('active')) {
            $('#thumbnails').addClass('modal-fullscreen');
            if (root.webkitRequestFullScreen) {
                root.webkitRequestFullScreen(
                    window.Element.ALLOW_KEYBOARD_INPUT
                );
            } else if (root.mozRequestFullScreen) {
                root.mozRequestFullScreen();
            }
        } else {
            $('#thumbnails').removeClass('modal-fullscreen');
            (document.webkitCancelFullScreen ||
                document.mozCancelFullScreen ||
                $.noop).apply(document);
        }
    });
</script>
<!-- application script for Charisma demo
<script src="<?= base_url() ?>assets/js/charisma.js"></script>-->