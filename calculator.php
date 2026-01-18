<?php require_once("config.php");?>
<?php require_once("views/helper.php");?>
<!DOCTYPE html>
<html lang="mn">
<head>
    <!-- Base URL for relative paths -->
    <base href="/shuurkhai/">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>Үнийн тооцоолуур - Shuurkhai</title>
    <!-- Bundle -->
    <link href="assets/vendor/css/bundle.min.css" rel="stylesheet">
    <!-- Plugin Css -->
    <link href="assets/css/line-awesome.min.css" rel="stylesheet">
    <link href="assets/vendor/css/revolution-settings.min.css" rel="stylesheet">
    <link href="assets/vendor/css/jquery.fancybox.min.css" rel="stylesheet">
    <link href="assets/vendor/css/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/css/cubeportfolio.min.css" rel="stylesheet">
    <link href="assets/vendor/css/LineIcons.min.css" rel="stylesheet">
    <link href="assets/vendor/css/wow.css" rel="stylesheet">
    <link href="assets/css/settings.css" rel="stylesheet">
    <link href="assets/css/blog.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">
    <style>
        /* Login button styling */
        .login-button-top {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .login-button-top:hover {
            background-color: #c82333;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        }
        .calculator-container {
            max-width: 800px;
            margin: 100px auto 50px;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .calc-input-group {
            margin-bottom: 25px;
        }
        .calc-input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .calc-input-group input,
        .calc-input-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }
        .calc-input-group input:focus,
        .calc-input-group select:focus {
            outline: none;
            border-color: #1e3a5f;
        }
        .calc-input-group input[type="number"] {
            -moz-appearance: textfield;
        }
        .calc-input-group input[type="number"]::-webkit-outer-spin-button,
        .calc-input-group input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .calc-result {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: center;
        }
        .calc-result h3 {
            color: #1e3a5f;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .calc-result-price {
            font-size: 36px;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="90">
<!-- Login Button -->
<a href="/shuurkhai/user/" title="Нэвтрэх" class="login-button-top btn btn-danger text-white">
    <i class="las la-user-circle"></i> Нэвтрэх
</a>

<?php
// Get air cargo price from admin settings
$airCargoPricePerKg = 7; // Default value

if (function_exists('settings')) {
    $paymentRate = settings('paymentrate');
    if (!empty($paymentRate)) {
        // Handle both comma (9,99) and dot (9.99) as decimal separator
        $paymentRate = str_replace(',', '.', trim($paymentRate));
        // Remove any non-numeric characters except dot
        $paymentRate = preg_replace('/[^0-9.]/', '', $paymentRate);
        
        if ($paymentRate !== '' && is_numeric($paymentRate)) {
            $rateFloat = floatval($paymentRate);
            if ($rateFloat > 0) {
                $airCargoPricePerKg = $rateFloat;
            }
        }
    }
}

// Debug: Uncomment to check what value is being used
// error_log("Calculator: Using air cargo price: " . $airCargoPricePerKg);
?>
<div class="calculator-container">
    <div class="mb-3">
        <a href="/shuurkhai/" class="btn btn-secondary btn-sm">
            <i class="las la-arrow-left"></i> Нүүр рүү буцах
        </a>
    </div>
    <h2 class="text-center mb-4" style="color: #1e3a5f;">Үнийн тооцоолуур</h2>
    <p class="text-center text-muted mb-4">Карго төрөл болон жингийн мэдээллийг оруулаад үнээ тооцоол.</p>
    <input type="hidden" id="airCargoPricePerKg" value="<?php echo htmlspecialchars($airCargoPricePerKg); ?>">
    
    <form id="calculatorForm">
        <div class="calc-input-group">
            <label for="cargoType">Карго төрөл:</label>
            <select id="cargoType" name="cargoType" onchange="toggleInputs()" required>
                <option value="air">Агаарын карго (5-10 хоног)</option>
                <option value="sea">Далайн карго (25-45 хоног)</option>
            </select>
        </div>
        
        <!-- Агаарын карго: Жин -->
        <div class="calc-input-group" id="airWeightGroup">
            <label for="weight">Жин (кг):</label>
            <input type="text" id="weight" name="weight" value="1" placeholder="Жишээ: 1.5 кг" pattern="[0-9]+(\.[0-9]+)?" inputmode="decimal" oninput="validateWeight(this)">
        </div>
        
        <!-- Далайн карго: Урт, Өргөн, Өндөр -->
        <div id="seaSizeGroup" style="display: none;">
            <div class="calc-input-group">
                <label for="length">Урт (см):</label>
                <input type="number" id="length" name="length" min="1" step="0.1" placeholder="Жишээ: 50">
            </div>
            <div class="calc-input-group">
                <label for="width">Өргөн (см):</label>
                <input type="number" id="width" name="width" min="1" step="0.1" placeholder="Жишээ: 50">
            </div>
            <div class="calc-input-group">
                <label for="height">Өндөр (см):</label>
                <input type="number" id="height" name="height" min="1" step="0.1" placeholder="Жишээ: 50">
            </div>
        </div>
        
        <button type="button" onclick="calculatePrice()" class="btn web-btn rounded-pill w-100">
            Үнэ тооцоол
        </button>
    </form>
    
    <div id="result" class="calc-result" style="display: none;">
        <h3>Тооцоолсон үнэ:</h3>
        <div class="calc-result-price" id="calculatedPrice"></div>
        <p class="mt-3" id="deliveryTime"></p>
    </div>
</div>

<script>
function validateWeight(input) {
    // Allow only numbers and one decimal point
    let value = input.value;
    // Remove any non-numeric characters except decimal point
    value = value.replace(/[^0-9.]/g, '');
    // Ensure only one decimal point
    let parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
    }
    input.value = value;
}

function toggleInputs() {
    const cargoType = document.getElementById('cargoType').value;
    const airWeightGroup = document.getElementById('airWeightGroup');
    const seaSizeGroup = document.getElementById('seaSizeGroup');
    
    if (cargoType === 'air') {
        airWeightGroup.style.display = 'block';
        seaSizeGroup.style.display = 'none';
    } else {
        airWeightGroup.style.display = 'none';
        seaSizeGroup.style.display = 'block';
    }
}

function calculatePrice() {
    const cargoType = document.getElementById('cargoType').value;
    let totalPrice = 0;
    const deliveryTime = cargoType === 'air' ? '5-10 хоног' : '25-45 хоног';
    
    if (cargoType === 'air') {
        // Агаарын карго: жингээр тооцоолно
        const weightInput = document.getElementById('weight');
        let weightValue = weightInput.value.trim();
        // Replace comma with dot for decimal
        weightValue = weightValue.replace(',', '.');
        const weight = parseFloat(weightValue) || 0;
        if (weight <= 0 || isNaN(weight)) {
            alert('Зөв жин оруулна уу! (Жишээ: 1.5)');
            weightInput.focus();
            return;
        }
        // Get price from admin settings (PHP-passed value)
        const pricePerKgInput = document.getElementById('airCargoPricePerKg');
        const pricePerKg = pricePerKgInput ? parseFloat(pricePerKgInput.value) : 7; // Fallback to 7 if not found
        totalPrice = weight * pricePerKg;
    } else {
        // Далайн карго: эзэлхүүнээр тооцоолно
        // Формула: (урт × өргөн × өндөр / 6000) × коэффициент
        // 61 × 46 × 46 см = 90$ => (129,076 / 6000) × коэффициент = 90
        // коэффициент = 90 / 21.5127 ≈ 4.184
        const length = parseFloat(document.getElementById('length').value) || 0;
        const width = parseFloat(document.getElementById('width').value) || 0;
        const height = parseFloat(document.getElementById('height').value) || 0;
        
        if (length <= 0 || width <= 0 || height <= 0) {
            alert('Урт, өргөн, өндрийг оруулна уу!');
            return;
        }
        
        // 61×46×46 см = 129,076 см³ = 90$
        // (129,076 / 6000) × коэффициент = 90
        // 21.5127 × коэффициент = 90
        // коэффициент = 90 / 21.5127 ≈ 4.184
        const referenceVolume = 61 * 46 * 46; // 129,076 см³
        const referencePrice = 90; // $
        const volumeWeight = (length * width * height) / 6000;
        const coefficient = referencePrice / (referenceVolume / 6000); // ≈ 4.184
        totalPrice = volumeWeight * coefficient;
    }
    
    // Үр дүн харуулах (2 оронтой бутархай)
    document.getElementById('calculatedPrice').textContent = totalPrice.toFixed(2) + ' $';
    document.getElementById('deliveryTime').textContent = 'Хүргэлтийн хугацаа: ' + deliveryTime;
    document.getElementById('result').style.display = 'block';
}

// Enter товч дээр дарахад тооцоолох
document.addEventListener('DOMContentLoaded', function() {
    // URL parameter-ээс карго төрөл шалгах
    const urlParams = new URLSearchParams(window.location.search);
    const cargoTypeParam = urlParams.get('type');
    
    if (cargoTypeParam === 'sea') {
        const cargoTypeSelect = document.getElementById('cargoType');
        if (cargoTypeSelect) {
            cargoTypeSelect.value = 'sea';
            toggleInputs();
        }
    }
    
    const weightInput = document.getElementById('weight');
    const lengthInput = document.getElementById('length');
    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');
    
    if (weightInput) {
        weightInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                calculatePrice();
            }
        });
    }
    
    if (heightInput) {
        heightInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                calculatePrice();
            }
        });
    }
    
    // Initial state
    toggleInputs();
});
</script>

</body>
</html>

