<?php

class shopProductordersPlugin extends shopPlugin {

    public function backendProduct($product) {
        $data = array();
        foreach ($product->skus as $sku) {
            $sku_id = $sku['id'];
            $orders = $this->getOrdersBySku($sku_id);
            $data[$sku_id] = $orders;
        }

        $view = wa()->getView();
        $template_path = wa()->getAppPath('plugins/productorders/templates/BackendProduct.html', 'shop');
        $view->assign('data', $data);
        $html = $view->fetch($template_path);
        return array(
            'toolbar_section' => $html
        );
    }

    private function getOrdersBySku($sku_id) {
        $app_settings_model = new waAppSettingsModel();
        $settings = $app_settings_model->get(array('shop', 'productorders'));
        $settings['states'] = json_decode($settings['states'], true);
        $states = array_keys($settings['states']);
        if (!$states) {
            return false;
        }

        $model = new waModel();
        $sql = "SELECT DISTINCT `so`.*
                FROM `shop_order_items` AS `soi`
                LEFT JOIN `shop_order` AS `so` ON `so`.`id` = `soi`.`order_id`
                WHERE `soi`.`sku_id` = '" . $model->escape($sku_id) . "'
                AND `so`.`state_id` IN ('" . implode("', '", $states) . "')
                ORDER BY `soi`.`order_id` DESC";
        $items = $model->query($sql)->fetchAll();
        $orders = array();
        foreach ($items as $item) {
            $orders[] = $item;
        }
        shopHelper::workupOrders($orders);
        return $orders;
    }

}
