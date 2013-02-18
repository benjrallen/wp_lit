<form id="reserveForm" class="public reserve litForm" name="form" method="post" action="">
  <div id="reserve-top">
    <h1>Reserve Your C-1</h1>
    <h2>- Fall In Love All Over Again -</h2>
  </div>
	<div id="reserveSlide1">
		<h3>Reserve your C-1 for as little as $250 USD.</h3>
		<h4>Higher pre-order pricing tiers move you up in the queue. See the drop-down box below for more details.</h4>
		<h5>Please fill out the information below:</h5>

    <div class="form-block">
  		<label class="privateReserve">Deposit</label>
  		<select name="deposit" id="deposit">
  		  <option value="null">Deposit Amount*</option>
  		  <?php
  		    //$ amounts for normal reserve
  		    //$values = array( 250, 500, 1000 );
  		    $values = array(
  		      250 => '$250',
  		      500 => '$500 (#0201+)',
  		      1000 => '$1,000 (#0101 - #0200)',
  		      2000 => '$2,000 (#0051 - #0100)',
  		      5000 => '$5,000 (#0011 - #0050)',
  		      10000 => '$10,000 (#0001 - #0010)'
  		    );
  		  
  		    if( $post->post_name == 'private' ){
  		      //$ amounts for private reserves
  		      //$values = array( 0, 50, 100, 250, 500, 1000 );
  		      $values = array( 
  		        0 => '$0', 
  		        50 => '$50', 
  		        100 => '$100', 
  		        250 => '$250', 
  		        500 => '$500', 
    		      1000 => '$1,000 (#101-200)',
    		      2000 => '$2,000 (#51-100)',
    		      5000 => '$5,000 (#11-50)',
    		      10000 => '$10,000 (#1-10)'
  		      );
  		    }
          
          foreach( $values as $k => $v )
  		      echo '<option value="'.$k.'">'.$v.'</option>';
  		  ?>
  		</select>
		</div>
		
    <div class="form-block">
  		<label>Salutation</label>
  		<select name="salutation" id="salutation">
  			<option value="0">---</option>
  			<option value="dr">Dr.</option>
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