<?php
require_once('../init.php');

Header('Content-type: text/xml');

$feed = include('../feed_raw.php');

?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; // need to echo this because of the question mark tags ?>

<rss version="2.0">
<channel>
    <title><?php echo Config('app','name'); ?></title>
    <link>http://www.website.at/</link>
    <description>Die neuesten Bilder auf <?php echo Config('app','name'); ?>.</description>

<?php
foreach($feed as $item)
{
?>
    <item>
        <title>Bild #<?php echo $item['pid'] ?></title>
        <link>http://www.website.at/</link>
        <guid><?php echo $item['pid'] ?></guid>
        <pubDate><?php echo date_create($item['pr_upload_date'])->format(DATE_RSS); ?></pubDate>
        <description>&lt;img src="ugc/thumb/<?php echo $item['pid'] ?>.jpg"&gt;</description>
    </item>
<?php
}
?>

</channel>
</rss>
