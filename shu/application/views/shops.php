<script type="text/javascript" src="<?=base_url("assets/js/lory.min.js");?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url("assets/css/lory.css");?>" />

<div class="clearfix"></div>

<div class="panel panel-danger">
	<div class="panel-heading">Онлайн дэлгүүрүүд</div>
  <div class="panel-body">

	<div class="slider js_variablewidth variablewidth">
	<div class="frame js_frame">
	<ul class="slides js_slides">
    
	<li class="js_slide" >
	<a href="http://www.amazon.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/amazon.jpg" /></a></li>
  
	<li class="js_slide" >
	<a href="http://www.ebay.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/ebay.jpg" /></a></li>
    

    <li class="js_slide" >
	<a href="http://www.columbia.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/columbia.jpg" /></a></li>


	<li class="js_slide" >
	<a href="http://www.6pm.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/6pm.jpg" /></a></li>
	
	<li class="js_slide" >
	<a href="http://www.wallmart.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/wallmart.jpg" /></a></li>
    	
	<li class="js_slide" >
	<a href="http://www.target.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/target.jpg" /></a></li>

	<li class="js_slide" >
	<a href="http://www.hm.com/us" target="new" >
	<img src="<?=base_url()?>assets/images/logo/hm.jpg" /></a></li>
  
    <li class="js_slide" >
	<a href="http://www.macys.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/macys.jpg" /></a></li>
      
	<li class="js_slide" >
	<a href="http://www.childrensplace.com/shop/us" target="new" >
	<img src="<?=base_url()?>assets/images/logo/childrens.jpg" /></a></li>
  
    	
	<li class="js_slide" >
	<a href="http://www.zappos.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/zappos.jpg" /></a></li>
  
      	     	
    <li class="js_slide" >
	<a href="http://www.carters.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/carters.jpg" /></a></li>

	

    <li class="js_slide" >
	<a href="http://www.autopartswarehouse.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/autoparts.jpg" /></a></li>
      	
	<li class="js_slide" >
	<a href="http://www.newegg.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/newegg.jpg" /></a></li>

      	
    <li class="js_slide" >
	<a href="http://www.apple.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/apple.jpg" /></a></li>
   
   
	<li class="js_slide" >
	<a href="http://www.nike.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/nike.jpg" /></a></li>
    
	<li class="js_slide" >
	<a href="http://www.finishline.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/finishline.jpg" /></a></li>

    <li class="js_slide" >
	<a href="http://www.eastbay.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/eastbay.jpg" /></a></li>

	<li class="js_slide" >
	<a href="http://www.timberland.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/timberland.jpg" /></a></li>
  
    <li class="js_slide" >
	<a href="http://www.sorel.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/sorel.jpg" /></a></li>

	
	<li class="js_slide" >
	<a href="http://www.forever21.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/forever21.jpg" /></a></li>
    
    <li class="js_slide" >
	<a href="https://us.burberry.com/?selected=Y" target="new" >
	<img src="<?=base_url()?>assets/images/logo/burberry.jpg" /></a></li>

	<li class="js_slide" >
	<a href="http://www.zappos.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/zappos.jpg" /></a></li>
  
      	     	
    <li class="js_slide" >
	<a href="http://www.carters.com/" target="new" >
	<img src="<?=base_url()?>assets/images/logo/carters.jpg" /></a></li>
                        
                       
                    </ul>
                </div>

                <span class="js_prev prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 501.5 501.5"><g><path fill="#2E435A" d="M302.67 90.877l55.77 55.508L254.575 250.75 358.44 355.116l-55.77 55.506L143.56 250.75z"/></g></svg>
                </span>

                <span class="js_next next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 501.5 501.5"><g><path fill="#2E435A" d="M199.33 410.622l-55.77-55.508L247.425 250.75 143.56 146.384l55.77-55.507L358.44 250.75z"/></g></svg>
                </span>
            </div>
</div>
</div>

            
            
            
           
	 <script>
        'use strict';

        document.addEventListener('DOMContentLoaded', function () {
            var variableWidth    = document.querySelector('.js_variablewidth');

            lory(variableWidth, {
                rewind: true,
                enableMouseEvents: true
            });

            function handleEvent(e) {
                var newSpan = document.createElement('span');
                var time = new Date();
                time = time.getHours() + ':' + time.getMinutes() + ':' + time.getSeconds() + ',' + time.getMilliseconds();
                var newContent = document.createTextNode('[' + time + '] Event dispatched: "' + e.type + '"');
                newSpan.appendChild(newContent);
                e.target.nextElementSibling.appendChild(newSpan);
            }

            events.addEventListener('before.lory.init', handleEvent);
            events.addEventListener('after.lory.init', handleEvent);
            events.addEventListener('before.lory.slide', handleEvent);
            events.addEventListener('after.lory.slide', handleEvent);

            events.addEventListener('on.lory.resize', handleEvent);
            events.addEventListener('on.lory.touchend', handleEvent);
            events.addEventListener('on.lory.touchmove', handleEvent);
            events.addEventListener('on.lory.touchstart', handleEvent);
            events.addEventListener('on.lory.destroy', handleEvent);

            lory(events, {
                infinite: 1
            });
        });
    </script>
    
    

<div class="clearfix"></div>