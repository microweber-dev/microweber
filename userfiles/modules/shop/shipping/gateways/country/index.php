<?php //  require_once($config['path_to_module'].'country_api.php'); ?>
<?php  $rand = uniqid();


 $data = api('shop/shipping/gateways/country/shipping_to_country/get', "is_active=y");
 $data_disabled = api('shop/shipping/gateways/country/shipping_to_country/get', "is_active=n");

 $countries_used = array();
  $countries_all = array();
 if( $data == false){
	 $data = array();
 }
  if(is_array($data)){
	foreach($data as $key => $item){
			if(trim(strtolower($item['shiping_country']))  == 'worldwide' ){
				 $countries_all = mw('Microweber\Forms')->countries_list();
				 unset($data[$key]);
				  if(is_array($countries_all)){

					  foreach($countries_all as  $countries_new){
						  $data[] = array('shiping_country' =>  $countries_new);
					  }

 					}
			}
	}




}



 if(is_array($data)){
	foreach($data as $key =>$item){
		$skip = false;
		if(is_array($data_disabled)){
			foreach($data_disabled as $item_disabled){
				if($item['shiping_country']  == $item_disabled['shiping_country'] ){
					$skip = 1;
					unset($data[$key]);
				}
			}
		}

	}
  }






  ?>
<script  type="text/javascript">
  mw.require('forms.js',true);
</script>
<script type="text/javascript">

  function mw_shipping_<?php print $rand; ?>(){
    mw.form.post( '#<?php print $rand; ?>', '<?php print $config['module_api']; ?>/shipping_to_country/set',function() {
	 mw.reload_module('shop/cart');

	 if(this.shiping_country != undefined){
		//d(this.shiping_country);
		mw.$("[name='country']").val(this.shiping_country)
	 }




	});
  }



$(document).ready(function(){
	//mw_shipping_<?php print $rand; ?>();
	mw.$('#<?php print $rand; ?>').change(function() {
	 mw_shipping_<?php print $rand; ?>();
	});

});



</script>
<?php if(isset($params['template']) and trim($params['template']) == 'select') : ?>

<div class="<?php print $config['module_class'] ?>" id="<?php print $rand; ?>">
  <select name="country" class="shipping-country-select">
   <option value=""><?php _e("Choose country"); ?></option>
    <?php foreach($data  as $item): ?>
    <option value="<?php print $item['shiping_country'] ?>"  <?php if(isset($_SESSION['shiping_country']) and $_SESSION['shiping_country'] == $item['shiping_country']): ?> selected="selected" <?php endif; ?>><?php print $item['shiping_country'] ?></option>
    <?php endforeach ; ?>
  </select>
</div>
<?php else: ?>
<div class="<?php print $config['module_class'] ?>">
  <div id="<?php print $rand; ?>">
    <label>
      <?php _e("Choose country:"); ?>
    </label>

    <?php  $selected_country = mw('user')->session_get('shiping_country'); ?>
    <select name="country" class="field-full">
	 <option value=""><?php _e("Choose country"); ?></option>
      <?php foreach($data  as $item): ?>
      <option value="<?php print $item['shiping_country'] ?>"  <?php if(isset($selected_country) and $selected_country == $item['shiping_country']): ?> selected="selected" <?php endif; ?>><?php print $item['shiping_country'] ?></option>
      <?php endforeach ; ?>
    </select>
  </div>
   
   <module type="custom_fields" data-id="shipping-info<?php print $params['id'] ?>" data-for="module"  default-fields="city,state,zip,street"   />

</div>
<?php endif; ?>
