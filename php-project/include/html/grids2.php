<?php
function getHistory($cfg_file, $accordion_id, $open_first_history_tab = false) {
   ob_start(); ?>
   <h3>History</h3>
   <div class="panel-group" id="accordion<?= $accordion_id ?>">
      <?php foreach (array_reverse(glob('client-conf/'.basename(pathinfo($cfg_file, PATHINFO_DIRNAME)).'/history/*')) as $i => $file): ?>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion<?= $accordion_id ?>" href="#collapse<?= $accordion_id ?>-<?= $i ?>">
                     <?php
                     $history_file_name = basename($file);
                     $chunks = explode('_', $history_file_name);
                     printf('[%s] %s', date('r', $chunks[0]), $chunks[1]);
                     ?>
                  </a>
               </h4>
            </div>
            <div id="collapse<?= $accordion_id ?>-<?= $i ?>" class="panel-collapse collapse <?= $i===0 && $open_first_history_tab?'in':'' ?>">
               <div class="panel-body"><pre><?= file_get_contents($file) ?></pre></div>
            </div>
         </div>
      <?php endforeach; ?>
   </div><?php
   $history = ob_get_contents();
   ob_end_clean();
   return $history;
}
?>
<ul class="nav nav-tabs">
   <li class="active"><a data-toggle="tab" href="#menu0">Table of Avaliable Servers</a></li>
</ul>
<div class="tab-content">
   <div id="menu-1-0" class="tab-pane fade in active">
      <textarea readonly class="form-control" data-config-file="<?= $cfg_file='scripts/list.txt' ?>" name="" id="" cols="30" rows="40"><?= file_get_contents($cfg_file) ?></textarea>
   </div>
</div>

<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/bootstrap/js/modal.js"></script>
<script src="vendor/bootstrap/js/tooltip.js"></script>
<script src="vendor/bootstrap/js/tab.js"></script>
<script src="vendor/bootstrap/js/collapse.js"></script>
<script src="vendor/bootstrap/js/popover.js"></script>
<script src="vendor/bootstrap-table/dist/bootstrap-table.min.js"></script>
<script src="vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="vendor/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.min.js"></script>
<script src="vendor/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="vendor/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js"></script>
<script src="js/grids.js"></script>

<script>
$(document).ready(function(){
   /*
   https://stackoverflow.com/a/19015027/3214501
   -> keep the currently active tab beyond page reloading
   */
   $('.nav.nav-tabs a').click(function(e) {
     e.preventDefault();
     $(this).tab('show');
   });
   $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
     var id = $(e.target).attr("href").substr(1);
     window.location.hash = id;
   });
   $('.nav.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
});
</script>
