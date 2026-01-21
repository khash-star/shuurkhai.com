<style>
.deliver-nav-buttons {
	display: inline-flex;
	gap: 10px;
	position: absolute;
	left: 20px;
	top: 50%;
	transform: translateY(-50%);
}
.deliver-nav-btn {
	display: inline-block;
	padding: 10px 20px;
	background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	color: white !important;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 600;
	font-size: 13px;
	box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
	transition: all 0.3s ease;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	border: 2px solid transparent;
}
.deliver-nav-btn:hover {
	transform: translateY(-2px);
	box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
	background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
	border-color: rgba(255, 255, 255, 0.3);
	color: white !important;
}
.deliver-nav-btn.active {
	background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
	box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
}
.barcode-switch-btn {
	display: inline-block;
	padding: 10px 20px;
	background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
	color: white !important;
	text-decoration: none;
	border-radius: 8px;
	font-weight: 600;
	font-size: 13px;
	box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
	transition: all 0.3s ease;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	border: 2px solid transparent;
	position: absolute;
	right: 20px;
	top: 50%;
	transform: translateY(-50%);
}
.barcode-switch-btn:hover {
	transform: translateY(-50%) translateY(-2px);
	box-shadow: 0 6px 20px rgba(17, 153, 142, 0.5);
	background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);
	border-color: rgba(255, 255, 255, 0.3);
	color: white !important;
}
</style>
<div class="deliver-nav-buttons" data-mode="FULFILLMENT_MODE">
	<a href="?action=initiate" class="deliver-nav-btn <?php echo (isset($_GET['action']) && ($_GET['action']=='initiate' || $_GET['action']=='' || $_GET['action']=='select')) ? 'active' : ''; ?>">ОЛГОЛТ</a>
	<a href="?action=initiate" class="deliver-nav-btn" onclick="if(document.querySelector('textarea[name=\"deliver\"]')) { document.querySelector('textarea[name=\"deliver\"]').focus(); } return true;" title="Гардуулалтын баркод оруулах">БАРКОД ОРУУЛАХ</a>
	<a href="?action=tel" class="deliver-nav-btn <?php echo (isset($_GET['action']) && $_GET['action']=='tel') ? 'active' : ''; ?>">УТСААР ХАЙХ</a>
	<a href="?action=delivered" class="deliver-nav-btn <?php echo (isset($_GET['action']) && $_GET['action']=='delivered') ? 'active' : ''; ?>">ГАРДУУЛСАН ИЛГЭЭМЖ</a>
</div>
<a href="barcodes" class="barcode-switch-btn">БАРКОД</a>