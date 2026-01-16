<script type="application/javascript">
$(document).ready(function() {
   $('input[name="select_all"]').click(function(event) {
        if(this.checked) { 
            $('input[type="checkbox"]').each(function() {
                this.checked = true;            
            });
        }else{
            $('input[type="checkbox"]').each(function() {
                this.checked = false; 
            });        
        }
    });
	
	
	
	
	
	$('#more').empty();
			$('#more').append('<select name="bench" class="form-control">'+
			'<option value="1">1-р тавиур</option>'+
			'<option value="2">2-р тавиур</option>'+
			'<option value="3">3-р тавиур</option>'+
			'<option value="4">4-р тавиур</option>'+
			'<option value="5">5-р тавиур</option>'+
			'<option value="6">6-р тавиур</option>'+
			'<option value="7">7-р тавиур</option>'+
			'<option value="8">8-р тавиур</option>'+
			'<option value="9">9-р тавиур</option>'+
			'<option value="10">10-р тавиур</option>'+
			'<option value="11">11-р тавиур</option>'+
			'<option value="12">12-р тавиур</option>'+
			'<option value="13">13-р тавиур</option>'+
			'<option value="14">14-р тавиур</option>'+
			'<option value="15">15-р тавиур</option>'+
			'<option value="16">16-р тавиур</option>'+
			'<option value="17">17-р тавиур</option>'+
			'<option value="18">18-р тавиур</option>'+
			'<option value="19">19-р тавиур</option>'+
			'<option value="20">20-р тавиур</option>'+
			'<option value="21">21-р тавиур</option>'+
			'<option value="22">22-р тавиур</option>'+
			'<option value="23">23-р тавиур</option>'+
			'<option value="24">24-р тавиур</option>'+
			'<option value="25">25-р тавиур</option>'+
			'<option value="26">26-р тавиур</option>'+
			'<option value="27">27-р тавиур</option>'+
			'<option value="28">28-р тавиур</option>'+
			'<option value="29">29-р тавиур</option>'+
			'<option value="30">30-р тавиур</option>'+
			'<option value="31">31-р тавиур</option>'+
			'<option value="32">32-р тавиур</option>'+
			'<option value="33">33-р тавиур</option>'+
			'<option value="34">34-р тавиур</option>'+
			'<option value="35">35-р тавиур</option>'+
			'<option value="36">36-р тавиур</option>'+
			'<option value="37">37-р тавиур</option>'+
			'<option value="38">38-р тавиур</option>'+
			'<option value="39">39-р тавиур</option>'+
			'<option value="40">40-р тавиур</option>'+
			'<option value="41">41-р тавиур</option>'+
			'<option value="42">42-р тавиур</option>'+
			'<option value="43">43-р тавиур</option>'+
			'<option value="44">44-р тавиур</option>'+
			'<option value="45">45-р тавиур</option>'+
			'<option value="46">46-р тавиур</option>'+
			'<option value="47">47-р тавиур</option>'+
			'<option value="48">48-р тавиур</option>'+
			'<option value="49">49-р тавиур</option>'+
			'<option value="50">50-р тавиур</option>'+
			'<option value="51">51-р тавиур</option>'+
			'<option value="52">52-р тавиур</option>'+
			'<option value="53">53-р тавиур</option>'+
			'<option value="54">54-р тавиур</option>'+
			'<option value="55">55-р тавиур</option>'+
			'<option value="56">56-р тавиур</option>'+
			'<option value="57">57-р тавиур</option>'+
			'<option value="58">58-р тавиур</option>'+
			'<option value="59">59-р тавиур</option>'+
			'<option value="60">60-р тавиур</option>'+
			'<option value="61">61-р тавиур</option>'+
			'<option value="62">62-р тавиур</option>'+
			'<option value="63">63-р тавиур</option>'+
			'<option value="64">64-р тавиур</option>'+
			'<option value="65">65-р тавиур</option>'+
			'<option value="66">66-р тавиур</option>'+
			'<option value="67">67-р тавиур</option>'+
			'<option value="68">68-р тавиур</option>'+
			'<option value="69">69-р тавиур</option>'+
			'<option value="70">70-р тавиур</option>'+
			'<option value="71">71-р тавиур</option>'+
			'<option value="72">72-р тавиур</option>'+
			'<option value="73">73-р тавиур</option>'+
			'<option value="74">74-р тавиур</option>'+
			'<option value="75">75-р тавиур</option>'+
			'<option value="76">76-р тавиур</option>'+
			'<option value="77">77-р тавиур</option>'+
			'<option value="78">78-р тавиур</option>'+
			'<option value="79">79-р тавиур</option>'+
			'<option value="80">80-р тавиур</option>'+
			'<option value="81">81-р тавиур</option>'+
			'<option value="82">82-р тавиур</option>'+
			'<option value="83">83-р тавиур</option>'+
			'<option value="84">84-р тавиур</option>'+
			'<option value="85">85-р тавиур</option>'+
			'<option value="86">86-р тавиур</option>'+
			'<option value="87">87-р тавиур</option>'+
			'<option value="88">88-р тавиур</option>'+
			'<option value="89">89-р тавиур</option>'+
			'<option value="90">90-р тавиур</option>'+
			'<option value="91">91-р тавиур</option>'+
			'<option value="92">92-р тавиур</option>'+
			'<option value="93">93-р тавиур</option>'+
			'<option value="94">94-р тавиур</option>'+
			'<option value="95">95-р тавиур</option>'+
			'<option value="96">96-р тавиур</option>'+
			'<option value="97">97-р тавиур</option>'+
			'<option value="98">98-р тавиур</option>'+
			'<option value="99">99-р тавиур</option>'+
			'<option value="100">100-р тавиур</option>'+
			'<option value="101">101-р тавиур</option>'+
			'<option value="102">102-р тавиур</option>'+
			'<option value="103">103-р тавиур</option>'+
			'<option value="104">104-р тавиур</option>'+
			'<option value="105">105-р тавиур</option>'+
			'<option value="106">106-р тавиур</option>'+
			'<option value="107">107-р тавиур</option>'+
			'<option value="108">108-р тавиур</option>'+
			'<option value="109">109-р тавиур</option>'+
			'<option value="110">110-р тавиур</option>'+
			'<option value="111">111-р тавиур</option>'+
			'<option value="112">112-р тавиур</option>'+
			'<option value="113">113-р тавиур</option>'+
			'<option value="114">114-р тавиур</option>'+
			'<option value="115">115-р тавиур</option>'+
			'<option value="116">116-р тавиур</option>'+
			'<option value="117">117-р тавиур</option>'+
			'<option value="118">118-р тавиур</option>'+
			'<option value="119">119-р тавиур</option>'+
			'<option value="120">120-р тавиур</option>'+
			'<option value="121">121-р тавиур</option>'+
			'<option value="122">122-р тавиур</option>'+
			'<option value="123">123-р тавиур</option>'+
			'<option value="124">124-р тавиур</option>'+
			'<option value="125">125-р тавиур</option>'+
			'<option value="126">126-р тавиур</option>'+
			'<option value="127">127-р тавиур</option>'+
			'<option value="128">128-р тавиур</option>'+
			'<option value="129">129-р тавиур</option>'+
			'<option value="130">130-р тавиур</option>'+
			'<option value="131">131-р тавиур</option>'+
			'<option value="132">132-р тавиур</option>'+
			'<option value="133">133-р тавиур</option>'+
			'<option value="134">134-р тавиур</option>'+
			'<option value="135">135-р тавиур</option>'+
			'<option value="136">136-р тавиур</option>'+
			'<option value="137">137-р тавиур</option>'+
			'<option value="138">138-р тавиур</option>'+
			'<option value="139">139-р тавиур</option>'+
			'<option value="140">140-р тавиур</option>'+
			'<option value="141">141-р тавиур</option>'+
			'<option value="142">142-р тавиур</option>'+
			'<option value="143">143-р тавиур</option>'+
			'<option value="144">144-р тавиур</option>'+
			'<option value="145">145-р тавиур</option>'+
			'<option value="146">146-р тавиур</option>'+
			'<option value="147">147-р тавиур</option>'+
			'<option value="148">148-р тавиур</option>'+
			'<option value="149">149-р тавиур</option>'+
			'<option value="150">150-р тавиур</option>'+
			'<option value="151">151-р тавиур</option>'+
			'<option value="152">152-р тавиур</option>'+
			'<option value="153">153-р тавиур</option>'+
			'<option value="154">154-р тавиур</option>'+
			'<option value="155">155-р тавиур</option>'+
			'<option value="156">156-р тавиур</option>'+
			'<option value="157">157-р тавиур</option>'+
			'<option value="158">158-р тавиур</option>'+
			'<option value="159">159-р тавиур</option>'+
			'<option value="160">160-р тавиур</option>'+
			'<option value="161">161-р тавиур</option>'+
			'<option value="162">162-р тавиур</option>'+
			'<option value="163">163-р тавиур</option>'+
			'<option value="164">164-р тавиур</option>'+
			'<option value="165">165-р тавиур</option>'+
			'<option value="166">166-р тавиур</option>'+
			'<option value="167">167-р тавиур</option>'+
			'<option value="168">168-р тавиур</option>'+
			'<option value="169">169-р тавиур</option>'+
			'<option value="170">170-р тавиур</option>'+
			'<option value="171">171-р тавиур</option>'+
			'<option value="172">172-р тавиур</option>'+
			'<option value="173">173-р тавиур</option>'+
			'<option value="174">174-р тавиур</option>'+
			'<option value="175">175-р тавиур</option>'+
			'<option value="176">176-р тавиур</option>'+
			'<option value="177">177-р тавиур</option>'+
			'<option value="178">178-р тавиур</option>'+
			'<option value="179">179-р тавиур</option>'+
			'<option value="180">180-р тавиур</option>'+
			'<option value="181">181-р тавиур</option>'+
			'<option value="182">182-р тавиур</option>'+
			'<option value="183">183-р тавиур</option>'+
			'<option value="184">184-р тавиур</option>'+
			'<option value="185">185-р тавиур</option>'+
			'<option value="186">186-р тавиур</option>'+
			'<option value="187">187-р тавиур</option>'+
			'<option value="188">188-р тавиур</option>'+
			'<option value="189">189-р тавиур</option>'+
			'<option value="190">190-р тавиур</option>'+
			'<option value="191">191-р тавиур</option>'+
			'<option value="192">192-р тавиур</option>'+
			'<option value="193">193-р тавиур</option>'+
			'<option value="194">194-р тавиур</option>'+
			'<option value="195">195-р тавиур</option>'+
			'<option value="196">196-р тавиур</option>'+
			'<option value="197">197-р тавиур</option>'+
			'<option value="198">198-р тавиур</option>'+
			'<option value="199">199-р тавиур</option>'+
			'<option value="200">200-р тавиур</option>'+
			'</select>');
			
	$('input[name="contacts"]').change(function(){
		$('#result').append('<img src="<?=base_url()?>assets/images/ajax-loader.gif" id="loading">');
		var tel= $('input[name="contacts"]').val();
	$.ajax ({
		url: '<?=base_url()?>index.php/admin/customers_check',
		type:'POST',
		data:'tel='+tel,
		success: function(responce){
									$('#responce').remove();
									$('#result').append(responce);
									$('#result').show(500);
									$('#loading').remove();

									if (responce=="Found user") 
									{
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=rd',
										success: function(responce0){
											$('input[name="rd"]').val(responce0);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=surname',
										success: function(responce1){
											$('input[name="surname"]').val(responce1);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=name',
										success: function(responce2){
											$('input[name="name"]').val(responce2);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=email',
										success: function(responce3){
											$('input[name="email"]').val(responce3);
																	}
												});	
												
										$.ajax ({
										url: '<?=base_url()?>index.php/admin/customers_check',
										type:'POST',
										data:'tel='+tel+'&value=address',
										success: function(responce4){
											$('textarea[name="address"]').text(responce4);
																	}
												});	
									}
									}
		});	
	});
		
		$('select[name="options"]').change(function()
		{
		if ($('select[name="options"]').val()=="weight_missing")
			{
			$('#more').empty();
			}
		if ($('select[name="options"]').val()=="new")
			{
			$('#more').empty();
			}
		
		if ($('select[name="options"]').val()=="onair")
			{
			$('#more').empty();
			}
			
		if ($('select[name="options"]').val()=="custom")
			{
			$('#more').empty();
			}

		if ($('select[name="options"]').val()=="unhandover")
			{
			$('#more').empty();
			}
		
		if ($('select[name="options"]').val()=="warehouse")
			{
			$('#more').empty();
			$('#more').append('<select name="bench" class="form-control">'+
			'<option value="1">1-р тавиур</option>'+
			'<option value="2">2-р тавиур</option>'+
			'<option value="3">3-р тавиур</option>'+
			'<option value="4">4-р тавиур</option>'+
			'<option value="5">5-р тавиур</option>'+
			'<option value="6">6-р тавиур</option>'+
			'<option value="7">7-р тавиур</option>'+
			'<option value="8">8-р тавиур</option>'+
			'<option value="9">9-р тавиур</option>'+
			'<option value="10">10-р тавиур</option>'+
			'<option value="11">11-р тавиур</option>'+
			'<option value="12">12-р тавиур</option>'+
			'<option value="13">13-р тавиур</option>'+
			'<option value="14">14-р тавиур</option>'+
			'<option value="15">15-р тавиур</option>'+
			'<option value="16">16-р тавиур</option>'+
			'<option value="17">17-р тавиур</option>'+
			'<option value="18">18-р тавиур</option>'+
			'<option value="19">19-р тавиур</option>'+
			'<option value="20">20-р тавиур</option>'+
			'<option value="21">21-р тавиур</option>'+
			'<option value="22">22-р тавиур</option>'+
			'<option value="23">23-р тавиур</option>'+
			'<option value="24">24-р тавиур</option>'+
			'<option value="25">25-р тавиур</option>'+
			'<option value="26">26-р тавиур</option>'+
			'<option value="27">27-р тавиур</option>'+
			'<option value="28">28-р тавиур</option>'+
			'<option value="29">29-р тавиур</option>'+
			'<option value="30">30-р тавиур</option>'+
			'<option value="31">31-р тавиур</option>'+
			'<option value="32">32-р тавиур</option>'+
			'<option value="33">33-р тавиур</option>'+
			'<option value="34">34-р тавиур</option>'+
			'<option value="35">35-р тавиур</option>'+
			'<option value="36">36-р тавиур</option>'+
			'<option value="37">37-р тавиур</option>'+
			'<option value="38">38-р тавиур</option>'+
			'<option value="39">39-р тавиур</option>'+
			'<option value="40">40-р тавиур</option>'+
			'<option value="41">41-р тавиур</option>'+
			'<option value="42">42-р тавиур</option>'+
			'<option value="43">43-р тавиур</option>'+
			'<option value="44">44-р тавиур</option>'+
			'<option value="45">45-р тавиур</option>'+
			'<option value="46">46-р тавиур</option>'+
			'<option value="47">47-р тавиур</option>'+
			'<option value="48">48-р тавиур</option>'+
			'<option value="49">49-р тавиур</option>'+
			'<option value="50">50-р тавиур</option>'+
			'<option value="51">51-р тавиур</option>'+
			'<option value="52">52-р тавиур</option>'+
			'<option value="53">53-р тавиур</option>'+
			'<option value="54">54-р тавиур</option>'+
			'<option value="55">55-р тавиур</option>'+
			'<option value="56">56-р тавиур</option>'+
			'<option value="57">57-р тавиур</option>'+
			'<option value="58">58-р тавиур</option>'+
			'<option value="59">59-р тавиур</option>'+
			'<option value="60">60-р тавиур</option>'+
			'<option value="61">61-р тавиур</option>'+
			'<option value="62">62-р тавиур</option>'+
			'<option value="63">63-р тавиур</option>'+
			'<option value="64">64-р тавиур</option>'+
			'<option value="65">65-р тавиур</option>'+
			'<option value="66">66-р тавиур</option>'+
			'<option value="67">67-р тавиур</option>'+
			'<option value="68">68-р тавиур</option>'+
			'<option value="69">69-р тавиур</option>'+
			'<option value="70">70-р тавиур</option>'+
			'<option value="71">71-р тавиур</option>'+
			'<option value="72">72-р тавиур</option>'+
			'<option value="73">73-р тавиур</option>'+
			'<option value="74">74-р тавиур</option>'+
			'<option value="75">75-р тавиур</option>'+
			'<option value="76">76-р тавиур</option>'+
			'<option value="77">77-р тавиур</option>'+
			'<option value="78">78-р тавиур</option>'+
			'<option value="79">79-р тавиур</option>'+
			'<option value="80">80-р тавиур</option>'+
			'<option value="81">81-р тавиур</option>'+
			'<option value="82">82-р тавиур</option>'+
			'<option value="83">83-р тавиур</option>'+
			'<option value="84">84-р тавиур</option>'+
			'<option value="85">85-р тавиур</option>'+
			'<option value="86">86-р тавиур</option>'+
			'<option value="87">87-р тавиур</option>'+
			'<option value="88">88-р тавиур</option>'+
			'<option value="89">89-р тавиур</option>'+
			'<option value="90">90-р тавиур</option>'+
			'<option value="91">91-р тавиур</option>'+
			'<option value="92">92-р тавиур</option>'+
			'<option value="93">93-р тавиур</option>'+
			'<option value="94">94-р тавиур</option>'+
			'<option value="95">95-р тавиур</option>'+
			'<option value="96">96-р тавиур</option>'+
			'<option value="97">97-р тавиур</option>'+
			'<option value="98">98-р тавиур</option>'+
			'<option value="99">99-р тавиур</option>'+
			'<option value="100">100-р тавиур</option>'+
			'<option value="101">101-р тавиур</option>'+
			'<option value="102">102-р тавиур</option>'+
			'<option value="103">103-р тавиур</option>'+
			'<option value="104">104-р тавиур</option>'+
			'<option value="105">105-р тавиур</option>'+
			'<option value="106">106-р тавиур</option>'+
			'<option value="107">107-р тавиур</option>'+
			'<option value="108">108-р тавиур</option>'+
			'<option value="109">109-р тавиур</option>'+
			'<option value="110">110-р тавиур</option>'+
			'<option value="111">111-р тавиур</option>'+
			'<option value="112">112-р тавиур</option>'+
			'<option value="113">113-р тавиур</option>'+
			'<option value="114">114-р тавиур</option>'+
			'<option value="115">115-р тавиур</option>'+
			'<option value="116">116-р тавиур</option>'+
			'<option value="117">117-р тавиур</option>'+
			'<option value="118">118-р тавиур</option>'+
			'<option value="119">119-р тавиур</option>'+
			'<option value="120">120-р тавиур</option>'+
			'<option value="121">121-р тавиур</option>'+
			'<option value="122">122-р тавиур</option>'+
			'<option value="123">123-р тавиур</option>'+
			'<option value="124">124-р тавиур</option>'+
			'<option value="125">125-р тавиур</option>'+
			'<option value="126">126-р тавиур</option>'+
			'<option value="127">127-р тавиур</option>'+
			'<option value="128">128-р тавиур</option>'+
			'<option value="129">129-р тавиур</option>'+
			'<option value="130">130-р тавиур</option>'+
			'<option value="131">131-р тавиур</option>'+
			'<option value="132">132-р тавиур</option>'+
			'<option value="133">133-р тавиур</option>'+
			'<option value="134">134-р тавиур</option>'+
			'<option value="135">135-р тавиур</option>'+
			'<option value="136">136-р тавиур</option>'+
			'<option value="137">137-р тавиур</option>'+
			'<option value="138">138-р тавиур</option>'+
			'<option value="139">139-р тавиур</option>'+
			'<option value="140">140-р тавиур</option>'+
			'<option value="141">141-р тавиур</option>'+
			'<option value="142">142-р тавиур</option>'+
			'<option value="143">143-р тавиур</option>'+
			'<option value="144">144-р тавиур</option>'+
			'<option value="145">145-р тавиур</option>'+
			'<option value="146">146-р тавиур</option>'+
			'<option value="147">147-р тавиур</option>'+
			'<option value="148">148-р тавиур</option>'+
			'<option value="149">149-р тавиур</option>'+
			'<option value="150">150-р тавиур</option>'+
			'<option value="151">151-р тавиур</option>'+
			'<option value="152">152-р тавиур</option>'+
			'<option value="153">153-р тавиур</option>'+
			'<option value="154">154-р тавиур</option>'+
			'<option value="155">155-р тавиур</option>'+
			'<option value="156">156-р тавиур</option>'+
			'<option value="157">157-р тавиур</option>'+
			'<option value="158">158-р тавиур</option>'+
			'<option value="159">159-р тавиур</option>'+
			'<option value="160">160-р тавиур</option>'+
			'<option value="161">161-р тавиур</option>'+
			'<option value="162">162-р тавиур</option>'+
			'<option value="163">163-р тавиур</option>'+
			'<option value="164">164-р тавиур</option>'+
			'<option value="165">165-р тавиур</option>'+
			'<option value="166">166-р тавиур</option>'+
			'<option value="167">167-р тавиур</option>'+
			'<option value="168">168-р тавиур</option>'+
			'<option value="169">169-р тавиур</option>'+
			'<option value="170">170-р тавиур</option>'+
			'<option value="171">171-р тавиур</option>'+
			'<option value="172">172-р тавиур</option>'+
			'<option value="173">173-р тавиур</option>'+
			'<option value="174">174-р тавиур</option>'+
			'<option value="175">175-р тавиур</option>'+
			'<option value="176">176-р тавиур</option>'+
			'<option value="177">177-р тавиур</option>'+
			'<option value="178">178-р тавиур</option>'+
			'<option value="179">179-р тавиур</option>'+
			'<option value="180">180-р тавиур</option>'+
			'<option value="181">181-р тавиур</option>'+
			'<option value="182">182-р тавиур</option>'+
			'<option value="183">183-р тавиур</option>'+
			'<option value="184">184-р тавиур</option>'+
			'<option value="185">185-р тавиур</option>'+
			'<option value="186">186-р тавиур</option>'+
			'<option value="187">187-р тавиур</option>'+
			'<option value="188">188-р тавиур</option>'+
			'<option value="189">189-р тавиур</option>'+
			'<option value="190">190-р тавиур</option>'+
			'<option value="191">191-р тавиур</option>'+
			'<option value="192">192-р тавиур</option>'+
			'<option value="193">193-р тавиур</option>'+
			'<option value="194">194-р тавиур</option>'+
			'<option value="195">195-р тавиур</option>'+
			'<option value="196">196-р тавиур</option>'+
			'<option value="197">197-р тавиур</option>'+
			'<option value="198">198-р тавиур</option>'+
			'<option value="199">199-р тавиур</option>'+
			'<option value="200">200-р тавиур</option>'+
			'</select>');
			}
			
		if ($('select[name="options"]').val()=="delete")
			{
			$('#more').empty();
			}
			
		if ($('select[name="options"]').val()=="hand")
			{
			$('#more').empty();
			}
		
		
		})
		 
   
});
</script>
<div class="panel panel-primary">
  <div class="panel-heading">Barcode:Selecting</div>
  <div class="panel-body">
<? 
$query = $this->db->query("SELECT barcode.* FROM barcode ORDER BY timestamp DESC");

if ($query->num_rows() > 0)
{
	echo form_open ("admin/barcode_elimination");
	echo "<table class='table table-hover'>";
	 echo "<tr>";
	   echo "<th>".form_checkbox(array('name'=>'select_all','title'=>'Select all barcodes'))."</th>"; 
	   echo "<th>№</th>"; 
	   echo "<th>Barcode оруулсан</th>"; 
	   echo "<th>Barcode</th>"; 
	   echo "<th>Захиалгын огноо</th>"; 
       echo "<th>Илгээгч</th>"; 
	   echo "<th>Х/авагч</th>"; 
	   echo "<th>Х/авагч утас</th>"; 
	   echo "<th>Хоног</th>"; 
	   echo "<th>Төлөв</th>"; 
	   echo "<th></th>"; 
	   echo "</tr>";
	   $count=1;
	foreach ($query->result() as $row)
	{  
		$timestamp=$row->timestamp;
		$barcode=$row->barcode;
		$combine=$row->combine;
		$status=$row->combine;
		
		if ($combine==0)
		$inside_query=$this->db->query("SELECT * FROM orders WHERE barcode='$barcode'");
		else 
		$inside_query=$this->db->query("SELECT * FROM box_combine WHERE barcode='$barcode'");
		
		if ($inside_query->num_rows()==1)
			{
			$data=$inside_query->row();
			$created_date=$data->created_date;
			$sender_id=$data->sender;
			$receiver_id=$data->receiver;
			$package=$data->package;
			$Package_advance =$data->advance;
			$Package_advance_value =$data->advance_value;
			$single_status=$data->status;
			//$single_extra=$data->extra;
			
			if ($combine==0)
			$order_id=$data->order_id;
			else 
			$combine_id=$order_id=$data->combine_id;
			}


		
			
			$s_name=customer($sender_id,"name");
			$s_surname=customer($sender_id,"surname");
			$s_tel=customer($sender_id,"tel");
			$s_email=customer($sender_id,"email");
			$s_address=customer($sender_id,"address");



			$r_name=customer($receiver_id,"name");
			$r_surname=customer($receiver_id,"surname");
			$r_tel=customer($receiver_id,"tel");
			$r_email=customer($receiver_id,"email");
			$r_address=customer($receiver_id,"address");

		
	
	
		$days= (strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($created_date))))/3600/24;

	
	  	if ($Package_advance==1)
		echo "<tr class='red' title='Үлдэгдэл:".$Package_advance_value."$'>"; 
		else echo "<tr>";
		
	   echo "<td>".form_checkbox("barcode_id[]",$barcode)."</td>"; 
	   echo "<td>".$count++."</td>";
	   echo "<td>".$timestamp."</td>"; 
	   echo "<td>".$barcode."</td>"; 
	   echo "<td>".$created_date."</td>"; 
	   echo "<td>"; if($s_name!="") echo anchor("customers/detail/".$sender_id,substr($s_surname,0,2).".".$s_name); echo "</td>"; 

 		echo "<td>"; if($r_name!="") echo anchor("customers/detail/".$receiver_id,substr($r_surname,0,2).".".$r_name); echo "</td>"; 	 
		
	   echo "<td>".$r_tel."</td>"; 
	   echo "<td>".$days."</td>"; 
	   echo "<td>";
	   echo $single_status;
	  // if ($single_status=="warehouse") " ".$single_extra."-р тавиур";
	   echo "</td>"; 
	   if ($combine)
			echo "<td>".anchor('admin/combine_display/'.$combine_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
		else 
	   echo "<td>".anchor('admin/tracks_detail/'.$order_id,'<span class="glyphicon glyphicon-edit"></span>')."</td>"; 
	   echo "</tr>";
	} 
	echo "</table>";
	
	$options = array(
                  //'delivered'  => 'Хүргэж өгсөн',
				  'weight_missing'    => 'Жин ороогүй',
				  'new'    => 'Нисэхэд бэлэн',
                  'onair'    => 'Онгоцоор ирж байгаа',
                  'warehouse'   => 'Агуулахад орсон',
				  'hand' => 'Хүргэлттэй',
				  'unhandover' => 'Хүргэлт цуцлах',
                  'custom' => 'Гааль',
				  'delete' => 'Barcode устгах',
				  
                );


	echo form_dropdown('options', $options,'warehouse',array("class"=>"form-control"));
	echo "<div id='more'></div>";
	echo form_submit("submit","өөрчил",array("class"=>"btn btn-success"));
	echo form_close();
}
else echo "Barcode байхгүй";


?>

</div>
</div>