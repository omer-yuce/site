<?php
function asvg_menu() {
	add_menu_page( 'Animated SVG Icon Library', 'ASVG Icon Library', 'manage_options', ASVG_PLUGIN_MENU, 'asvg_callback' );	
}
add_action('admin_menu', 'asvg_menu');

function asvg_callback() {
	
?>
<style>
.container {
    max-width: 1300px;
    margin: auto;
}
.headerfull {
    display: inline-block;
    width: 90%;
    height: 170px;
	font-size: 14px;
    line-height: 1.4em;
    letter-spacing: 0.1px;
    font-weight: 400;
	padding-left: 80px;
	margin-bottom:15px;

}
.headerleft {
    display: inline-block;
    width: 70%;
    margin-top:15px;
    height: 120px;
    float: left;
    font-size: 14px;
    line-height: 1.4em;
    letter-spacing: 0.1px;
    font-weight: 400;
	margin-left: 80px;

}	
	
.headerright {
    display: inline-block;
    height: 120px;
    width: 10%;
    margin-right: 10%;
    margin-top: 6px;
	float: right;

}
.iframe{
    margin-left: 40px;    
    
}

.btnasvg {
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
    background: #007cba;
    border-color: #007cba;
    color: #fff;
    text-decoration: none;
    text-shadow: none;
    display: inline-block;
    text-decoration: none;
    font-size: 14px;
    line-height: 2.15em;
    min-height: 30px;
    margin: 0;
    padding: 0 10px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    -webkit-appearance: none;
    border-radius: 3px;
    white-space: nowrap;
    box-sizing: border-box;
}
.btnasvg:hover {
    background: #0073aa;
	color: #fff;
    transition-property: border,background,color;
    transition-duration: .05s;
    transition-timing-function: ease-in-out;
    
}
	
</style>


<div class="container">
<div class="headerfull">
	<h3>Animated SVG Icons for Elementor - Icon Library</h3><br>
Hello,<br><br>

Thanks for downloading Animated SVG icons for Elementor. Since the initial release of 70 icons 5 months ago the Animated SVG library rapidly grown to 746 icons. To start using the plugin open a page or post in Elementor, search for the icon widget you would like to use and drag it into a column. Select an icon and click on the "Style" tab to customize it. If you have any question, suggestions please <span style="text-decoration: underline;"><span style="color: #333333; text-decoration: underline;"><a style="color: #333333; text-decoration: underline;" href="mailto:design@animated-svg.com" target="_blank" rel="noopener">send an email</a></span></span> to get in touch.
</div>
	
<div class="headerleft">Get all <strong>746 SVG icons</strong> + <strong>Background Elements + Flip Box.</strong>  Extended widgets features, <strong>1 year of free updates </strong>(more icons).</div>
		

<div class="headerright">	

<button id="purchase" title="Only $3.75/mo." alt="Only $3.75/mo." class="btnasvg">Download PRO</button>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://checkout.freemius.com/checkout.min.js"></script>
<script>
    var handler = FS.Checkout.configure({
        plugin_id:  '5481',
        plan_id:    '8887',
        public_key: 'pk_80243b16d9b650165f1973c447a2f',
        image:      'https://animated-svg.com/wp-content/uploads/2020/01/icon-140x140-1.png'
    });
    
    $('#purchase').on('click', function (e) {
        handler.open({
            name     : 'Animated SVG PRO for Elementor Page Builder',
            licenses : 1,

            purchaseCompleted  : function (response) {

            },
            success  : function (response) {

            }
        });
        e.preventDefault();
    });
</script>
</div><div class="iframe">	
	<iframe src="https://animated-svg.com/icons-cheat-sheet-freemius-pro/" style="height:1650px; width:100%"> </iframe>
	

</div></div>
<?php

}

?>