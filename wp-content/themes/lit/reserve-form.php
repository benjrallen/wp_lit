<form id="reserveForm" class="public reserve litForm" name="form" method="post" action="">
  <div id="reserve-top">
    <h1>Reserve Your C-1</h1>
    <h2>- Fall In Love All Over Again -</h2>
  </div>
	<div id="reserveSlide1">
		<h3>Pre-order your C-1 with a deposit of $250US.</h3>
		<h4>Reserve one of the first 200 with a deposit of $1000 USD,</h4><h4>or one of the next 300 with a deposit of $500 USD.</h4>
		<h5>Please fill out the information below:</h5>

    <div class="form-block">
  		<label class="privateReserve">Deposit</label>
  		<select name="deposit" id="deposit">
  			<option value="0">Deposit Amount*</option>
  			<option value="250">$250</option>
  			<option value="500">$500</option>
  			<option value="1000">$1000</option>
  		</select>
		</div>
		
    <div class="form-block">
  		<label>Salutation</label>
  		<select name="salutation" id="salutation">
  			<option value="0">---</option>
  			<option value="mr">Mr.</option>
  			<option value="mrs">Mrs.</option>
  			<option value="ms">Ms.</option>
  		</select>
  	</div>
		
    <div class="form-block">
  		<label>First Name*</label>
  		<input type="text" placeholder="First Name*" name="firstname" id="firstname" />
  	</div>
		
    <div class="form-block">
  		<label>Last Name*</label>
  		<input type="text" placeholder="Last Name*" name="lastname" id="lastname" />
  	</div>
		
    <div class="form-block">
  		<label>Address*</label>
  		<input type="text" placeholder="Address*" name="address" id="address" />
  	</div>
		
    <div class="form-block">
  		<label>City *</label>
  		<input type="text" placeholder="City *" name="city" id="city" />
  	</div>
		
    <div class="form-block">
  		<label>State *</label>
  		<input type="text" placeholder="State *" name="state" id="state" />
  	</div>
		
    <div class="form-block">
  		<label>Postal Code / ZIP*</label>
  		<input type="text" placeholder="Postal Code / ZIP*" name="zip" id="zip" />
  	</div>

    <div class="form-block">
      <? get_template_part('countries','select'); ?>
		</div>
				
    <div class="form-block">
  		<label>E-mail*</label>
  		<input type="text" placeholder="E-mail*" name="email" id="email" />
  	</div>
		
    <div class="form-block">
  		<label>Phone Number*</label>
  		<input type="text" placeholder="Phone Number*" name="phone" id="phone" />
  	</div>
				
    <? get_template_part('reserve','faqs'); ?>
	
	<!-- <button type="submit">Submit*</button> -->
	</div>

  <button id="formSubmit" type="submit"><span class="ico"></span><span>Submit</span></button>

</form>