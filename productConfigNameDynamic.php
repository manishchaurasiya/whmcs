<?php
use WHMCS\Database\Capsule;

include 'init.php';

$log_directory = __DIR__.'/aaa/theme';
$files = scandir($log_directory);

$curr_id = 1;
$configId = 1;

 
foreach ($files as $key =>  $value) {
    if($key > 1){
     $optionName = $value.'|'.str_replace_first('.', ' ', ucwords(str_replace("-", " ",rtrim($value,".zip"))));
     if (Capsule::table('tblproductconfigoptionssub')->where('configid', $configId)->where('optionname', $optionName)->count() == 0) {
         	$optionArr = [
    			'configid' => $configId,
    			'optionname' => $optionName,
    			'hidden' => '0'
    		];
    	$subOptionId = Capsule::table('tblproductconfigoptionssub')->insertGetId($optionArr);
    	
    	if (Capsule::table('tblpricing')->where('type', 'configoptions')->where('currency', $curr_id)->where('relid', $subOptionId)->count() == 0) {
    	    
    	    Capsule::table('tblpricing')->insert(
    					[
    						'type' => 'configoptions',
    						'currency' => $curr_id,
    						'relid' => $subOptionId,
    						'msetupfee' => '0.00',
    						'qsetupfee' => '0.00',
    						'annually' => '0.00',
    						'biennially' => '0.00',
    						'triennially' => '0.00'
    					]
    			);  
    	    
    	}
       
    }
    
    
 
    }
   
 
}




function str_replace_first($search, $replace, $subject)
{
$search = '/'.preg_quote($search, '/').'/';
return preg_replace($search, $replace, $subject, 1);
}


?>
