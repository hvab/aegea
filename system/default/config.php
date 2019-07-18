<?php 


// after changing some of these params it may be necessary
// to drop the cache
// for that, go to your-website-address/?go=@sync


// UI

// years range separator for the copyright line
$_config['years_range_separator'] = '&mdash;'; /* html */

// period for the most commented (hot) posts
$_config['hot_period'] = 'month'; /* 'day', 'week', 'month', 'year', 'ever' */

// period for the most read (popular) posts
$_config['popular_period'] = 'month'; /* 'day', 'week', 'month', 'year', 'ever' */

// default text formatter (make sure you know why you change it)
$_config['default_formatter'] = 'neasden'; /* 'raw', 'calliope', 'neasden' */



// THEMES

// show raw template data instead of using actual templates
$_config['raw_template_data'] = false;
  
// show raw template date with ?raw parameter
$_config['raw_template_data_with_param'] = false;

// when a template file is missing, treat it as if it were empty
$_config['ignore_missing_template_files'] = true; /* bool */

// default maximum image width
$_config['max_image_width'] = 2560; /* pixels */



// URLS

// redirect to canonical urls when synonims are used
$_config['force_canonical_urls'] = true;
  
// redirect to this domain name (will work only if force_canonical_urls is on)
$_config['preferred_domain_name'] = null; /* null or string */
  
// use beautiful (synthetic) or ?parametrised (real) urls
$_config['url_composition'] = 'auto'; /* 'auto', 'real', 'synthetic' */

// add “all/” in front of urls in case of 404
$_config['try_redirect_to_all'] = false;
  


// MISC

// sender address for outgoing mail (if ends with @, domain name will be added)
$_config['mail_from'] = 'blog@';
  
// use 'index, follow' everywhere (otherwise will be only where necessary)
$_config['index_follow_everything'] = true;
  
// accept holborn notifications
$_config['holborn'] = false;
  
// access rights to use for uploaded files
$_config['uploaded_files_mode'] = 0777;

// maximum size of all uploaded files in bytes (0 for no limit)
$_config['files_total_size_limit'] = 0;

// scale images bigger than this; 0 to disable
$_config['fit_uploaded_images'] = 2560; /* pixels */

// whois service (URL to append IP address to)
$_config['whois_service'] = 'https://www.nic.ru/whois/?ip=';

// database table prefix for storing multiple blogs in one database
$_config['db_table_prefix'] = 'e2Blog';

// by default, Aegea reindexes databases for search on switch
$_config['retain_search_indexes_on_db_switch'] = false;

// url to ping when posts become available
$_config['broadcast_url'] = 'http://blogengine.ru/blogs/@notify';

// broadcast all blog notes during indexing
$_config['broadcast_on_indexing'] = true;



// SOCIAL NETWORKS

// which networks to share to (also supported: linkedin, whatsapp)
$_config['share_to'] = 'twitter, facebook, vkontakte, telegram, pinterest';

// via whom to share to Twitter
$_config['share_to_twitter_via'] = '';



// CONSTANTS

// maximum length of a comment in bytes (bigger ones won't be accepted)
$_config['max_comment_length'] = 4096;

// for how many days are comments fresh?
$_config['comment_freshness_days'] = 14;

// number of items in RSS feeds
$_config['rss_items'] = 10;

// Rose
$_config['search_favourites_boost'] = 2;



// DEBUG

// write a log to user/log.txt? (it may get very large soon)
$_config['write_log'] = true;

// if user/log.txt is not there, create it?
$_config['write_log_create'] = false;

// reset a log in the beginning of page generation
$_config['write_log_reset'] = false;

// keep log under this limit
$_config['write_log_limit'] = 0; /* bytes */

// show call stack when displaying error?
$_config['show_call_stack'] = 0; /* 0 - no; 1 - when logged in; 2 - always */

// store backtrace in backtrace.psa?
$_config['store_backtrace'] = false;
  
// make ajax slower?
$_config['debug_slow_ajax'] = false;
  
// write HTTP request log?
$_config['request_logging'] = false;

// output rose debug info
$_config['rose_debug_info'] = false;

 

?>