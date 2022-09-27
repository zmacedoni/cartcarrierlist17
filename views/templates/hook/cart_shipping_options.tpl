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

<div class="delivery-options-list delivery-options-list-cart">
  {if $delivery_options|count}
    <form
      class="clearfix"
      id="js-delivery"
      data-url-update="{url entity='order' params=['ajax' => 1, 'action' => 'selectDeliveryOption']}"
      method="post"
    >
      <div class="form-fields">
        {block name='delivery_options'}
          <div class="delivery-options">
            {foreach from=$delivery_options item=carrier key=carrier_id}
                <div class="delivery-option">

                    <label for="delivery_option_{$carrier.id|escape:'html':'UTF-8'}">
                      <span class="custom-radio">
                        <input type="radio" name="delivery_option[{$id_address|escape:'html':'UTF-8'}]" id="delivery_option_{$carrier.id|escape:'html':'UTF-8'}" value="{$carrier_id|escape:'html':'UTF-8'}"{if $delivery_option == $carrier_id} checked{/if}>
                        <span></span>
                      </span>
                      <span class="h6 carrier-name">{$carrier.name|escape:'html':'UTF-8'}</span>
                      <span class="carrier-price">{$carrier.price|escape:'html':'UTF-8'}</span>
                    </label>
                    <br>
                      <span class="carrier-delay">{$carrier.delay|escape:'html':'UTF-8'}</span>

                </div>
            {/foreach}
          </div>
        {/block}
      </div>
    </form>
  {else}
    {*<p class="alert alert-danger">{l s='Unfortunately, there are no carriers available for your delivery address.' d='Shop.Theme.Checkout'}</p>*}
  {/if}
</div>
