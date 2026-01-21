<style>
.barcode-nav-buttons {
	display: inline-flex;
	gap: 12px;
	position: absolute;
	left: 20px;
	top: 50%;
	transform: translateY(-50%);
}
.barcode-nav-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	padding: 6px 16px;
	background: linear-gradient(135deg, #10b981 0%, #059669 100%);
	color: #ffffff !important;
	text-decoration: none;
	border-radius: 6px;
	font-weight: 500;
	font-size: 12px;
	letter-spacing: 0.3px;
	border: none;
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
	transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	text-transform: none;
	cursor: pointer;
	position: relative;
	overflow: hidden;
}
.barcode-nav-btn::before {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
	transition: left 0.5s;
}
.barcode-nav-btn:hover::before {
	left: 100%;
}
.barcode-nav-btn:hover {
	transform: translateY(-1px);
	box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
	background: linear-gradient(135deg, #059669 0%, #047857 100%);
}
.barcode-nav-btn:active {
	transform: translateY(0);
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
}
.barcode-nav-btn.active {
	background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
	box-shadow: 0 2px 4px rgba(236, 72, 153, 0.2);
}
.barcode-nav-btn.active:hover {
	background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
	box-shadow: 0 4px 8px rgba(236, 72, 153, 0.3);
}
.barcode-nav-btn.warehouse-btn {
	background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2) !important;
}
.barcode-nav-btn.warehouse-btn:hover {
	background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
	box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3) !important;
}
.barcode-nav-btn.warehouse-btn.active {
	background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2) !important;
}
.barcode-nav-btn.warehouse-btn.active:hover {
	background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
	box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3) !important;
}
.barcode-nav-right-buttons {
	display: inline-flex;
	gap: 12px;
	position: absolute;
	right: 20px;
	top: 50%;
	transform: translateY(-50%);
}
.olgolt-switch-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	padding: 8px 20px;
	background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
	color: #ffffff !important;
	text-decoration: none;
	border-radius: 6px;
	font-weight: 500;
	font-size: 13px;
	letter-spacing: 0.3px;
	border: none;
	box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
	transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	text-transform: none;
	cursor: pointer;
	position: relative;
	overflow: hidden;
}
.olgolt-switch-btn::before {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
	transition: left 0.5s;
}
.olgolt-switch-btn:hover::before {
	left: 100%;
}
.olgolt-switch-btn:hover {
	transform: translateY(-1px);
	box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
	background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
}
.olgolt-switch-btn:active {
	transform: translateY(0);
	box-shadow: 0 2px 4px rgba(99, 102, 241, 0.2);
}
.barcode-duplicate-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 6px;
	padding: 6px 16px;
	background: linear-gradient(135deg, #10b981 0%, #059669 100%);
	color: #ffffff !important;
	text-decoration: none;
	border-radius: 6px;
	font-weight: 500;
	font-size: 12px;
	letter-spacing: 0.3px;
	border: none;
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
	transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	text-transform: none;
	cursor: pointer;
}
.barcode-duplicate-btn:hover {
	transform: translateY(-1px);
	box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
	background: linear-gradient(135deg, #059669 0%, #047857 100%);
}
.barcode-duplicate-btn:active {
	transform: translateY(0);
	box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
}
.barcode-duplicate-btn::after {
	content: '▼';
	font-size: 9px;
	margin-left: 4px;
	opacity: 0.9;
	transition: transform 0.2s ease, opacity 0.2s ease;
}
.barcode-dropdown.show .barcode-duplicate-btn::after {
	transform: rotate(180deg);
	opacity: 1;
}
.barcode-dropdown {
	position: relative;
	display: inline-block;
}
.barcode-dropdown-menu {
	display: none;
	position: absolute;
	right: 0;
	top: calc(100% + 6px);
	background-color: #ffffff;
	min-width: 240px;
	max-width: 320px;
	box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 2px 6px rgba(0, 0, 0, 0.08);
	border-radius: 8px;
	z-index: 1050;
	overflow: hidden;
	border: 1px solid #e5e7eb;
	padding: 6px 0;
	animation: fadeInDown 0.15s ease-out;
}
@keyframes fadeInDown {
	from {
		opacity: 0;
		transform: translateY(-8px);
	}
	to {
		opacity: 1;
		transform: translateY(0);
	}
}
.barcode-dropdown.show .barcode-dropdown-menu {
	display: block;
}
.barcode-dropdown-item {
	display: block !important;
	padding: 11px 20px;
	color: #374151;
	text-decoration: none;
	cursor: pointer;
	visibility: visible !important;
	opacity: 1 !important;
	height: auto !important;
	overflow: visible !important;
	font-size: 14px;
	font-weight: 400;
	line-height: 1.5;
	transition: all 0.15s ease;
	border-bottom: 1px solid #f3f4f6;
	white-space: nowrap;
	position: relative;
}
.barcode-dropdown-item:first-child {
	border-top: none;
}
.barcode-dropdown-item:last-child {
	border-bottom: none;
}
.barcode-dropdown-item:hover {
	background-color: #f0f9ff;
	color: #0369a1;
	transform: none;
	padding-left: 24px;
}
.barcode-dropdown-item:hover::before {
	content: '';
	position: absolute;
	left: 0;
	top: 0;
	bottom: 0;
	width: 3px;
	background-color: #0369a1;
}
.barcode-dropdown-item:active {
	background-color: #e0f2fe;
	color: #075985;
}
</style>
<div class="barcode-nav-buttons" data-mode="BARCODE_MODE">
	<a href="barcodes" class="barcode-nav-btn warehouse-btn <?php echo (!isset($_GET['action']) || $_GET['action']=='select') ? 'active' : ''; ?>">АГУУЛАХАД ОРУУЛАХ</a>
	<a href="barcodes?action=insert" class="barcode-nav-btn <?php echo (isset($_GET['action']) && $_GET['action']=='insert') ? 'active' : ''; ?>">БАРКОД ОРУУЛАХ</a>
</div>
<div class="barcode-nav-right-buttons">
	<div class="barcode-dropdown">
		<a href="barcodes" class="barcode-duplicate-btn <?php echo (!isset($_GET['action']) || $_GET['action']=='select') ? 'active' : ''; ?>" onclick="event.preventDefault(); this.closest('.barcode-dropdown').classList.toggle('show'); return false;">БАРКОД</a>
		<div class="barcode-dropdown-menu">
			<a href="#" class="barcode-dropdown-item" data-status="warehouse">Агуулахад орсон</a>
			<a href="#" class="barcode-dropdown-item" data-status="weight_missing">Жин ороогүй</a>
			<a href="#" class="barcode-dropdown-item" data-status="new">Нисэхэд бэлэн</a>
			<a href="#" class="barcode-dropdown-item" data-status="onair">Онгоцоор ирж байгаа</a>
			<a href="#" class="barcode-dropdown-item" data-status="hand">Хүргэлттэй</a>
			<a href="#" class="barcode-dropdown-item" data-status="unhandover">Хүргэлт цуцлах</a>
			<a href="#" class="barcode-dropdown-item" data-status="custom">Гааль</a>
		</div>
	</div>
	<a href="deliver?action=initiate" class="olgolt-switch-btn">ОЛГОЛТ</a>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
	var dropdown = document.querySelector('.barcode-dropdown');
	
	// Close dropdown when clicking outside
	document.addEventListener('click', function(event) {
		if (dropdown && !dropdown.contains(event.target)) {
			dropdown.classList.remove('show');
		}
	});
	
	// Handle dropdown item clicks - change form select and submit
	if (dropdown) {
		var items = dropdown.querySelectorAll('.barcode-dropdown-item');
		items.forEach(function(item) {
			item.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var status = this.getAttribute('data-status');
				
				// Close dropdown first
				dropdown.classList.remove('show');
				
				// Find the form select dropdown
				var formSelect = document.querySelector('select[name="options"]');
				if (formSelect) {
					// Check if any barcodes are selected
					var checkboxes = document.querySelectorAll('input[type="checkbox"][name="barcode_id[]"]:checked');
					if (checkboxes.length === 0) {
						alert('Эхлээд баркод сонгоно уу!');
						return;
					}
					
					// Set the selected value
					formSelect.value = status;
					
					// Create a hidden input to ensure the value is submitted
					var hiddenInput = document.createElement('input');
					hiddenInput.type = 'hidden';
					hiddenInput.name = 'options';
					hiddenInput.value = status;
					
					// Remove existing hidden input if any
					var existingHidden = formSelect.closest('form').querySelector('input[type="hidden"][name="options"]');
					if (existingHidden) {
						existingHidden.remove();
					}
					
					// Add hidden input to form
					var form = formSelect.closest('form');
					form.appendChild(hiddenInput);
					
					// Trigger change event to show/hide additional fields
					var changeEvent = new Event('change', { bubbles: true });
					formSelect.dispatchEvent(changeEvent);
					
					// For warehouse status, wait a bit for bench select to appear
					if (status === 'warehouse') {
						setTimeout(function() {
							var benchSelect = document.querySelector('select[name="bench"]');
							if (!benchSelect || !benchSelect.value) {
								alert('Тавиурын дугаар сонгоно уу!');
								hiddenInput.remove();
								return;
							}
							// Submit form after bench is selected
							form.submit();
						}, 300);
					} else {
						// For other statuses, submit immediately
						setTimeout(function() {
							form.submit();
						}, 100);
					}
				} else {
					// If form select doesn't exist, just navigate
					window.location.href = 'barcodes?status=' + status;
				}
			});
		});
	}
});
</script>
