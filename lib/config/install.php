<?php

$plugin_id = array('shop', 'productorders');
$app_settings_model = new waAppSettingsModel();
$app_settings_model->set($plugin_id, 'status', '1');
$app_settings_model->set($plugin_id, 'states', '{"new":"1","processing":"1"}');
