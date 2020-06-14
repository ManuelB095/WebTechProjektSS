<h1>News</h1>
<a href="rss"><span class="ui-icon ui-icon-link"></span>RSS</a><br>

<?php

$feed = include('../feed_raw.php');

foreach($feed as $item)
{
    ?>
<img class="img-fluid" src="ugc/thumb/<?php echo $item['pid']; ?>.jpg">
    <?php
}

