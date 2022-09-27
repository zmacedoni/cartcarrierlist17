<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Adapter\Presenter\Object\ObjectPresenter;

class Cartcarrierlist extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'cartcarrierlist';
        $this->tab = 'shipping_logistics';
        $this->version = '1.0.0';
        $this->author = 'vorkum';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Display / change carrier(s) in cart');
        $this->description = $this->l('Let your customers to choose carrier in cart before the chekout process.');

        $this->confirmUninstall = $this->l('Are you sure?');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayCheckoutSubtotalDetails');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
    }

    public function hookDisplayCheckoutSubtotalDetails($params)
    {
      $deliveryOptionsFinder = new DeliveryOptionsFinder(
          $this->context,
          $this->getTranslator(),
          new ObjectPresenter,
          new PriceFormatter()
      );

      $this->context->smarty->assign(
          [
            "delivery_options" => $deliveryOptionsFinder->getDeliveryOptions(),
            "delivery_option" => $deliveryOptionsFinder->getSelectedDeliveryOption(),
            "id_address" => $this->context->cart->id_address_delivery
          ]
      );
      return $this->fetch('module:'.$this->name.'/views/templates/hook/cart_shipping_options.tpl');
    }
}
