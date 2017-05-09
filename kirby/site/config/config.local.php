<?php

c::set('debug', true);
// For local development with gulp and browser-sync as a proxy, the Kirby base path detection
// does more harm than good, so we simply set the URL to '/' explicitly.
c::set('url', '/');
// Always force widget into test mode for development
c::set('widget.testMode', true);
