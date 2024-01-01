<?php
/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

// require_once(_PS_MODULE_DIR_ . 'clientcomments/sql/ClientcommentsModel.php');

use Prestashop\Module\Clientcomments\Classes\ClientcommentsModel;

class Clientcomments extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'clientcomments';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'sHKamil - Kamil Hałasa';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Client Comments');
        $this->description = $this->l('Displays added text as comments on home page.');

        $this->confirmUninstall = $this->l('You will lose all data of this module (added comments).');

        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('CLIENTCOMMENTS_LIVE_MODE', false);
        Configuration::updateValue('CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE', '3');
        Configuration::updateValue('CLIENTCOMMENTS_ABOUT_TITLE', '');
        Configuration::updateValue('CLIENTCOMMENTS_ABOUT', '');
        Configuration::updateValue('CLIENTCOMMENTS_COMMENTS_TITLE', '');

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName('CLIENTCOMMENTS_LIVE_MODE');
        Configuration::deleteByName('CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE');
        Configuration::deleteByName('CLIENTCOMMENTS_ABOUT_TITLE');
        Configuration::deleteByName('CLIENTCOMMENTS_ABOUT');
        Configuration::deleteByName('CLIENTCOMMENTS_COMMENTS_TITLE');
        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitClientcommentsModule')) == true) {
            $this->postProcess();
        }
        if (((bool)Tools::isSubmit('submitNewCommentsForm')) == true) {
            ClientcommentsModel::saveComment($_POST['new_client_name'], $_POST['new_comment']);
        }
        if (((bool)Tools::isSubmit('submitCommentsForm')) == true) {
            $this->activateComments($_POST['switch_comments']);
            if(!empty($_POST['delete_comments'])) {
                foreach ($_POST['delete_comments'] as $key => $id) {
                    ClientcommentsModel::deleteById($id);
                }
            }
        }

        $this->context->smarty->assign([
            'module_dir' => $this->_path,
            'client_comments' => ClientcommentsModel::getAllData(),
        ]);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitClientcommentsModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $linkCore = new LinkCore;

        $helper->tpl_vars = [
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'controller' => $linkCore->getAdminLink('CommentListController')
        ];

        return $helper->generateForm([$this->getConfigForm()]);
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return [
            'form' => [
                'legend' => [
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'switch',
                        'label' => $this->l('Live mode'),
                        'name' => 'CLIENTCOMMENTS_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Use this module in live mode'),
                        'values' => [
                            [
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ],
                            [
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            ]
                        ],
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Active comments'),
                        'name' => 'CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE',
                        'desc' => $this->l('Comments on home page. (MAX 6)'),
                        'class' => 'fixed-width-xs',
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('About title'),
                        'name' => 'CLIENTCOMMENTS_ABOUT_TITLE',
                        'desc' => $this->l('Title to section About.'),
                    ],
                    [
                        'type' => 'textarea',
                        'label' => $this->l('About content'),
                        'name' => 'CLIENTCOMMENTS_ABOUT',
                        'desc' => $this->l('About the shop.'),
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Comments title'),
                        'name' => 'CLIENTCOMMENTS_COMMENTS_TITLE',
                        'desc' => $this->l('Title to section Comments.'),
                    ]
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                ],
            ],
        ];
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return [
            'CLIENTCOMMENTS_LIVE_MODE' => Configuration::get('CLIENTCOMMENTS_LIVE_MODE', true),
            'CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE' => Configuration::get('CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE'),
            'CLIENTCOMMENTS_ABOUT_TITLE' => Configuration::get('CLIENTCOMMENTS_ABOUT_TITLE'),
            'CLIENTCOMMENTS_ABOUT' => Configuration::get('CLIENTCOMMENTS_ABOUT'),
            'CLIENTCOMMENTS_COMMENTS_TITLE' => Configuration::get('CLIENTCOMMENTS_COMMENTS_TITLE'),
        ];
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            if($key === 'CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE') {
                $value = intval(Tools::getValue($key));
                if($value >= 1 && $value <= 6) { // Setting cap of the maximum comments on homepage
                    Configuration::updateValue($key, Tools::getValue($key));
                }
            } else {
                Configuration::updateValue($key, Tools::getValue($key));
            }
        }
    }

    protected function activateComments($comments): void
    {
        
        $toActivate = [];
        foreach ($comments as $key => $value) {
            if($value === "on") array_push($toActivate, $key);
        }
        
        if(count($toActivate) <= intval(Configuration::get('CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE'))) {

            $activated = [];
            foreach (ClientcommentsModel::getSelected() as $key => $comment) {
                array_push($activated, $comment["id_clientcomments"]);
            }

            if(count($activated) !== 0) {
                foreach ($activated as $key => $comment_id) {
                    ClientcommentsModel::setActive($comment_id, 0);
                }
            }

            foreach ($toActivate as $key => $comment_id) {
                ClientcommentsModel::setActive($comment_id, 1);
            }
        }
        return; 
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookActionBackControllerSetMedia()
    {
        $this->context->controller->registerJavascript(
            'backJS',
            'modules/' . $this->name . '/views/js/back.js',
            [
                'type' => 'module'
            ]
        );
    }

    public function hookDisplayHome()
    {
        $this->context->smarty->assign([
            'comments' => ClientcommentsModel::getSelected(),
            'max_comments' => intval(Configuration::get('CLIENTCOMMENTS_COMMENTS_ON_HOME_PAGE'))
        ]);

        return $this->display(__FILE__, 'views/templates/front/clientcomments.tpl');
    }
}
