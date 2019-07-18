<?= '<?xml version="1.0" encoding="utf-8"?>' ?> 
<rss version="2.0">

<channel>

<title><?= htmlspecialchars ($content['title'], ENT_NOQUOTES, HSC_ENC); ?></title>
<link><?= $content['home_page_url'] ?></link>
<description></description>
<generator><?= $content['_e2_ua_string'] ?></generator>

<?php foreach ($content['items'] as $item) { ?>
<item>
<title><?= htmlspecialchars ($item['title'], ENT_NOQUOTES, HSC_ENC); ?></title>
<guid isPermaLink="<?= $item['_rss_guid_is_permalink'] ?>"><?= $item['_rss_guid'] ?></guid>
<link><?= $item['url'] ?></link>
<comments><?= $item['url'] ?></comments>
<description>
<?php if ($item['author']) { ?>
&lt;p&gt;&lt;a href="<?= $item['author']['url'] ?>"&gt;<?= $item['author']['name'] ?>&lt;/a&gt;:&lt;/p&gt;
<?php } ?>
<?= htmlspecialchars ($item['content_html'], ENT_NOQUOTES, HSC_ENC) ?>
</description>
<pubDate><?= $item['_date_published_rfc2822'] ?></pubDate>
</item>

<?php } ?>

</channel>
</rss>