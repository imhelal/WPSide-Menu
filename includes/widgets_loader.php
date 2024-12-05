<?php

foreach (glob(WPSM_PLUING_DIR . "admin/widgets/widget_*.php") as $filename) {
	require_once $filename;
}