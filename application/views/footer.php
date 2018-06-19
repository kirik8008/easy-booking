<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
  $(document).ready(function() {

   var docHeight = $(window).height();
   var footerHeight = $('#footer').height();
   var footerTop = $('#footer').position().top + footerHeight;

   if (footerTop < docHeight) {
    $('#footer').css('margin-top', 0+ (docHeight - footerTop) + 'px');
   }
  });
 </script>

<div class="footer" id="footer">
<div class="text-white py-0 bg-secondary">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mt-3 text-center">
          <p>Page rendered in <strong>{elapsed_time}</strong> seconds. © Copyright 2018 PITka Group - All rights reserved.</p>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
