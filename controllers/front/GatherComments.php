<?php

use Prestashop\Module\Clientcomments\Classes\ClientcommentsModel;

class clientcommentsGatherCommentsModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        $method = Tools::getValue('method');

        // Call the appropriate method based on the 'method' parameter
        if (!empty($method) && method_exists($this, $method)) {
            $this->{$method}();
        } else {
            parent::initContent();
        }
    }

    public function getActiveJSON() : void
    {
        $selected = ClientcommentsModel::getSelected();
        header('Content-Type: application/json');
        echo json_encode($selected);
        exit;
    }
}
