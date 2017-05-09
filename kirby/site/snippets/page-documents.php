<div class="row" data-equalizer>
  <?php
  function getColumnClass($currentColumn, $totalColumns) {
    if($totalColumns == 1) {
      return ' small-centered';
    } else if ($totalColumns == 2 && $currentColumn == 1) {
      return ' large-offset-2';
    } else if ($totalColumns == $currentColumn) {
      return ' end';
    }
  }
  ?>

  <?php
  $index = 0;
  $count = $page->documents()->count();
  foreach($page->documents() as $document):
    $index++;
    ?>
    <div class="columns small-10 medium-6 large-4 <?php echo getColumnClass($index, $count); ?>">
      <div class="callout medium text-center" data-equalizer-watch>
        <img src="<?php echo kirby()->urls()->assets() ?>/images/doc.png" alt="" />
        <h4><?php echo $document->fileTitle()->html() ?></h4>
        <?php echo $document->fileText()->kirbytext() ?>
        <a target="_blank" href="<?php echo $document->url() ?>" type="button" class="button">Download</a>
      </div><!-- /.callout -->
    </div><!-- /.columns medium-4 large-4 -->
  <?php endforeach; ?>
</div><!-- /.row -->
