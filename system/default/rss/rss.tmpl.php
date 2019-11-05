<?= '<?xml version="1.0" encoding="utf-8"?>' ?> 
<rss version="2.0"
  xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
  xmlns:atom="http://www.w3.org/2005/Atom">

<channel>

<title><?= htmlspecialchars ($content['title'], ENT_NOQUOTES, HSC_ENC); ?></title>
<link><?= $content['home_page_url'] ?></link>
<description><?= $content['_rss_description'] ?></description>
<author><?= $content['author']['name'] ?></author>
<generator><?= $content['_e2_ua_string'] ?></generator>

<?php foreach ($content['items'] as $item) { ?>
<item>
<title><?= htmlspecialchars ($item['title'], ENT_NOQUOTES, HSC_ENC); ?></title>
<guid isPermaLink="<?= $item['_rss_guid_is_permalink'] ?>"><?= $item['_rss_guid'] ?></guid>
<link><?= $item['url'] ?></link>
<pubDate><?= $item['_date_published_rfc2822'] ?></pubDate>
<?php if (array_key_exists ('author', $item)) { ?>
<author><?= $item['author']['name'] ?></author>
<?php } else { ?>
<author><?= $content['author']['name'] ?></author>
<?php } ?>
<comments><?= $item['url'] ?></comments>
<?php foreach ($item['_rss_enclosures'] as $enclosure) { ?>
<enclosure url="<?= $enclosure['url'] ?>" type="<?= $enclosure['type'] ?>" />
<?php } ?>
<description>
<?php if (array_key_exists ('author', $item)) { ?>
&lt;p&gt;&lt;a href="<?= $item['author']['url'] ?>"&gt;<?= $item['author']['name'] ?>&lt;/a&gt;:&lt;/p&gt;
<?php } ?>
<?= htmlspecialchars ($item['content_html'], ENT_NOQUOTES, HSC_ENC) ?>
</description>
</item>

<?php } ?>

</channel>
</rss>