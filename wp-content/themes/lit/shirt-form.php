<form id="shirtForm" class="shirt litForm" name="form" method="post" action="">
  <div id="reserve-top">
    <h1>Lit Motors T-Shirt</h1>
    <h2>- Rekindle the Excitement -</h2>
  </div>
	<div id="reserveSlide1">
		<h3>Get your Lit Motors T-Shirt for $30 USD.</h3>
		<h4>North American shipping included. All others please add $10.</h4>

    <div class="form-block">
      <label>Size</label>
      <select id="theSize">
      	<option value="S">Small</option>
      	<option value="M">Medium</option>
      	<option value="L">Large</option>
      	<option value="XL">Extra Large</option>
      </select>
		</div>
		
    <div class="form-block">
      <label>Color</label>
      <select id="theColor">
      	<option value="Black">Black</option>
      	<option value="DkGray">Dark Gray</option>
      	<option value="LtGray">Light Gray</option>
      </select>
  	</div>
  	
	</div>

  <button id="formSubmit" type="submit"><span class="ico"></span><span>Buy Now</span></button>

<?php /* ?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="H4RFZ69HK7VJN">
<table>
<tr><td><input type="hidden" name="on0" value="Shipping">Shipping</td></tr><tr><td><select name="os0">
	<option value="North America">North America$30.00 USD</option>
	<option value="All Others">All Others$40.00 USD</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on1" value="Size">Size</td></tr><tr><td><select name="os1">
	<option value="Small">Small</option>
	<option value="Medium">Medium</option>
	<option value="Large">Large</option>
	<option value="Extra Large">Extra Large</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on2" value="Color">Color</td></tr><tr><td><select name="os2">
	<option value="Black">Black</option>
	<option value="Light Gray">Light Gray</option>
	<option value="Dark Gray">Dark Gray</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
<?php */ ?>

</form>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id="paypalForm">
    <input type="hidden" name="on0" value="Shipping">
    <input type="hidden" name="on0" value="North America">
    <input type="hidden" name="on0" value="Color">
    <input type="hidden" name="os0" value="Black">
    <input type="hidden" name="on1" value="Size">
    <input type="hidden" name="os1" value="Small">
    <input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="H4RFZ69HK7VJN">
-</form>

<form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/704111282563175" id="googleForm" method="post" name="BB_BuyButtonForm" target="_top">
    <table cellpadding="5" cellspacing="0" width="1%">
        <tr>
            <td align="right" width="1%">
            	<input type="hidden" name="item_selection_1" value="1" />
                <input name="item_option_name_1" type="hidden" value="Black T-Shirt (S)"/>
                <input name="item_option_price_1" type="hidden" value="30.0"/>
                <input name="item_option_description_1" type="hidden" value="Small Black Lit T-Shirt"/>
                <input name="item_option_quantity_1" type="hidden" value="1"/>
                <input name="item_option_currency_1" type="hidden" value="USD"/>
                <input name="item_option_name_2" type="hidden" value="Black T-Shirt (M)"/>
                <input name="item_option_price_2" type="hidden" value="30.0"/>
                <input name="item_option_description_2" type="hidden" value="Medium Black Lit T-Shirt"/>
                <input name="item_option_quantity_2" type="hidden" value="1"/>
                <input name="item_option_currency_2" type="hidden" value="USD"/>
                <input name="item_option_name_3" type="hidden" value="Black T-Shirt (L)"/>
                <input name="item_option_price_3" type="hidden" value="30.0"/>
                <input name="item_option_description_3" type="hidden" value="Large Black Lit T-Shirt"/>
                <input name="item_option_quantity_3" type="hidden" value="1"/>
                <input name="item_option_currency_3" type="hidden" value="USD"/>
                <input name="item_option_name_4" type="hidden" value="Black T-Shirt (XL)"/>
                <input name="item_option_price_4" type="hidden" value="30.0"/>
                <input name="item_option_description_4" type="hidden" value="Extra Large Black Lit T-Shirt"/>
                <input name="item_option_quantity_4" type="hidden" value="1"/>
                <input name="item_option_currency_4" type="hidden" value="USD"/>
                <input name="item_option_name_5" type="hidden" value="Black T-Shirt (XXL)"/>
                <input name="item_option_price_5" type="hidden" value="30.0"/>
                <input name="item_option_description_5" type="hidden" value="XX-Large Black Lit T-Shirt"/>
                <input name="item_option_quantity_5" type="hidden" value="1"/>
                <input name="item_option_currency_5" type="hidden" value="USD"/>
                <input name="item_option_name_6" type="hidden" value="Dark Gray T-Shirt (S)"/>
                <input name="item_option_price_6" type="hidden" value="30.0"/>
                <input name="item_option_description_6" type="hidden" value="Small Dark Gray Lit T-Shirt"/>
                <input name="item_option_quantity_6" type="hidden" value="1"/>
                <input name="item_option_currency_6" type="hidden" value="USD"/>
                <input name="item_option_name_7" type="hidden" value="Dark Gray T-Shirt (M)"/>
                <input name="item_option_price_7" type="hidden" value="30.0"/>
                <input name="item_option_description_7" type="hidden" value="Medium Dark Gray Lit T-Shirt"/>
                <input name="item_option_quantity_7" type="hidden" value="1"/>
                <input name="item_option_currency_7" type="hidden" value="USD"/>
                <input name="item_option_name_8" type="hidden" value="Dark Gray T-Shirt (L)"/>
                <input name="item_option_price_8" type="hidden" value="30.0"/>
                <input name="item_option_description_8" type="hidden" value="Large Dark Gray Lit T-Shirt"/>
                <input name="item_option_quantity_8" type="hidden" value="1"/>
                <input name="item_option_currency_8" type="hidden" value="USD"/>
                <input name="item_option_name_9" type="hidden" value="Dark Gray T-Shirt (XL)"/>
                <input name="item_option_price_9" type="hidden" value="30.0"/>
                <input name="item_option_description_9" type="hidden" value="Extra Large Dark Gray Lit T-Shirt"/>
                <input name="item_option_quantity_9" type="hidden" value="1"/>
                <input name="item_option_currency_9" type="hidden" value="USD"/>
                <input name="item_option_name_10" type="hidden" value="Dark Gray T-Shirt (XXL)"/>
                <input name="item_option_price_10" type="hidden" value="30.0"/>
                <input name="item_option_description_10" type="hidden" value="XX-Large Dark Gray Lit T-Shirt"/>
                <input name="item_option_quantity_10" type="hidden" value="1"/>
                <input name="item_option_currency_10" type="hidden" value="USD"/>
                <input name="item_option_name_11" type="hidden" value="Light Gray T-Shirt (S)"/>
                <input name="item_option_price_11" type="hidden" value="30.0"/>
                <input name="item_option_description_11" type="hidden" value="Small Light Gray Lit T-Shirt"/>
                <input name="item_option_quantity_11" type="hidden" value="1"/>
                <input name="item_option_currency_11" type="hidden" value="USD"/>
                <input name="item_option_name_12" type="hidden" value="Light Gray T-Shirt (M)"/>
                <input name="item_option_price_12" type="hidden" value="30.0"/>
                <input name="item_option_description_12" type="hidden" value="Medium Light Gray Lit T-Shirt"/>
                <input name="item_option_quantity_12" type="hidden" value="1"/>
                <input name="item_option_currency_12" type="hidden" value="USD"/>
                <input name="item_option_name_13" type="hidden" value="Light Gray T-Shirt (L)"/>
                <input name="item_option_price_13" type="hidden" value="30.0"/>
                <input name="item_option_description_13" type="hidden" value="Large Light Gray Lit T-Shirt"/>
                <input name="item_option_quantity_13" type="hidden" value="1"/>
                <input name="item_option_currency_13" type="hidden" value="USD"/>
                <input name="item_option_name_14" type="hidden" value="Light Gray T-Shirt (XL)"/>
                <input name="item_option_price_14" type="hidden" value="30.0"/>
                <input name="item_option_description_14" type="hidden" value="Extra Large Light Gray Lit T-Shirt"/>
                <input name="item_option_quantity_14" type="hidden" value="1"/>
                <input name="item_option_currency_14" type="hidden" value="USD"/>
                <input name="item_option_name_15" type="hidden" value="Light Gray T-Shirt (XXL)"/>
                <input name="item_option_price_15" type="hidden" value="30.0"/>
                <input name="item_option_description_15" type="hidden" value="XX-Large Light Gray Lit T-Shirt"/>
                <input name="item_option_quantity_15" type="hidden" value="1"/>
                <input name="item_option_currency_15" type="hidden" value="USD"/>
            </td>
        </tr>
    </table>
</form>