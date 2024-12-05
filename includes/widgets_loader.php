<?php

foreach (glob(WPSM_PLUGIN_DIR . "admin/widgets/widget_*.php") as $filename) {
	require_once $filename;
}