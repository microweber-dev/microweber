<?php include (MW_ADMIN_VIEWS_DIR . 'header.php'); ?>
<?php if(is_admin() == false): ?>
<module type="users/login" template="admin" />
<?php else: ?>
<?php $v1 = mw('url')->param('load_module'); ?>
<?php $v = mw('url')->param('view');
 
  if($v1 != false){
	 $holder_cls = mw('url')->slug($v1);
  }  else if($v != false){
	 $holder_cls = mw('url')->slug($v);
  } else {
	  $holder_cls = false;
  }
  ?>

<div class="admin-main-wrapper <?php print  $holder_cls ?>">
  <?php if($v1 != false): ?>
  <?php
        
        $v_mod = module_name_decode($v1);
        
         if(is_module($v_mod)){
			  include_once (MW_ADMIN_VIEWS_DIR . 'module_nav.php'); 
             $mod = load_module($v_mod, $attrs=array('view' => 'admin','backend' => 'true'));
             print $mod ;
         } else {
            print "No module found {$v_mod}" ;
             
         }
        
         ?>
  <?php else : ?>
  <?php include_once (MW_ADMIN_VIEWS_DIR . 'header_nav.php'); ?>
  <?php 
        
        
        
        $vf = MW_ADMIN_VIEWS_DIR . $v. '.php';
        $vf = str_replace('..', '', $vf);
        if(is_file($vf)){
        //d($vf);	
        
        include ($vf);
        
        }
         
         else { ?>
  <?php
        
        $v_mod = module_name_decode($v);
      
         if($v_mod != '' and is_module($v_mod)){
             $mod = load_module($v_mod, $attrs=array('view' => 'admin','backend' => 'true'));
            
			
			 print $mod ;
         } else {
             
             include (MW_ADMIN_VIEWS_DIR . 'index.php');
         }
        
         } ?>
  <?php endif; ?>
</div>
<?php endif; ?>
<?php	include (MW_ADMIN_VIEWS_DIR . 'footer.php'); ?>
