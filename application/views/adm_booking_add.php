<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
 <div class="py-5" id="global">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        	<table class="table">
        	<? foreach($time as $key => $value) { ?>
        		<tr><td><?=$key+1?></td><td><?=$value?></td></tr>
        	<? } ?>
        	</table>
        </div>
      </div>
    </div>
  </div>
