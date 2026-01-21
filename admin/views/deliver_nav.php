<style>
.deliver-nav-buttons {
	display: inline-flex;
	gap: 12px;
	position: absolute;
	left: 20px;
	top: 50%;
	transform: translateY(-50%);
}
.deliver-nav-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	padding: 6px 16px;
	background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
	color: #ffffff !important;
	text-decoration: none;
	border-radius: 6px;
	font-weight: 500;
	font-size: 12px;
	letter-spacing: 0.3px;
	border: none;
	box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
	transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	text-transform: none;
	cursor: pointer;
	position: relative;
	overflow: hidden;
}
.deliver-nav-btn::before {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
	transition: left 0.5s;
}
.deliver-nav-btn:hover::before {
	left: 100%;
}
.deliver-nav-btn:hover {
	transform: translateY(-1px);
	box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
	background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
}
.deliver-nav-btn:active {
	transform: translateY(0);
	box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
}
.deliver-nav-btn.active {
	background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
	box-shadow: 0 2px 4px rgba(236, 72, 153, 0.2);
}
.deliver-nav-btn.active:hover {
	background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
	box-shadow: 0 4px 8px rgba(236, 72, 153, 0.3);
}
.barcode-switch-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	padding: 8px 20px;
	background: linear-gradient(135deg, #10b981 0%, #059669 100%);
	color: #ffffff !important;
	text-decoration: none;
	border-radius: 6px;
	font-weight: 500;
	font-size: 13px;
	letter-spacing: 0.3px;
	border: none;
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
	transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	text-transform: none;
	cursor: pointer;
	position: absolute;
	right: 20px;
	top: 50%;
	transform: translateY(-50%);
}
.barcode-switch-btn:hover {
	transform: translateY(-50%) translateY(-1px);
	box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
	background: linear-gradient(135deg, #059669 0%, #047857 100%);
}
.barcode-switch-btn:active {
	transform: translateY(-50%);
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
}
</style>
<div class="deliver-nav-buttons" data-mode="FULFILLMENT_MODE">
	<a href="?action=initiate" class="deliver-nav-btn" onclick="if(document.querySelector('textarea[name=\"deliver\"]')) { document.querySelector('textarea[name=\"deliver\"]').focus(); } return true;" title="Гардуулалтын баркод оруулах">БАРКОД ОРУУЛАХ</a>
	<a href="?action=tel" class="deliver-nav-btn <?php echo (isset($_GET['action']) && $_GET['action']=='tel') ? 'active' : ''; ?>">УТСААР ХАЙХ</a>
	<a href="?action=delivered" class="deliver-nav-btn <?php echo (isset($_GET['action']) && $_GET['action']=='delivered') ? 'active' : ''; ?>">ГАРДУУЛСАН ИЛГЭЭМЖ</a>
</div>
<a href="barcodes" class="barcode-switch-btn">БАРКОД</a>