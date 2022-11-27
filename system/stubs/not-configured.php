<?php

  // not-configured:
  //
  // the requested page requires an installed engine, but the database
  // and/or the user’s password are not configures, and Installer
  // is disallowed by configuration

  return [
    'heading' => 'Aegea is not configured',
    'text' => '<p>The domain '. $_SERVER['HTTP_HOST'] .' points to a server with Aegea blogging engine, but the engine is not yet configured to serve this domain.</p>',
  ];

?>