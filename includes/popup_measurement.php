<div id="question" title="select measurement for this shirt" align="center">
	<p style="width:340px; text-align:left">option 1: choose a measurement that i have <br /> 
    <i style="padding-left:62px">(you have to login in order use this)</i></p>
    <button id="measurement_existing">previously entered</button>
    <p style="width:340px; text-align:left">option 2: enter a new set of measurement </p>
	<button id="measurement_customize">customize</button>
	<button id="measurement_standardize">standardize</button>
</div>
<div id="customize" title="select measurement for this shirt" align="center">
	<table width="100%">
    	<tr>
        	<td>
            	<img src="images/whitecollar.jpg" width="280" height="360" />
            </td>
            <td valign="top">
            	
                <table>
                    <tr><td colspan="2"><input type="text" name="m_name" id="m_name" alt="" value="who is this for" class="text ui-widget-content ui-corner-all" size="17" /></td></tr>
                    <tr><td>neck</td><td><input type="text" name="neck" id="neck" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>shoulder</td><td><input type="text" name="shoulder" id="shoulder" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>arm hole</td><td><input type="text" name="armhole" id="armhole" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>bicep</td><td><input type="text" name="bicep" id="bicep" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>arm length</td><td><input type="text" name="armlength" id="armlength" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>wrist</td><td><input type="text" name="wrist" id="wrist" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>chest</td><td><input type="text" name="chest" id="chest" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>waist</td><td><input type="text" name="waist" id="waist" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>waist point</td><td><input type="text" name="waistpoint" id="waistpoint" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>hips</td><td><input type="text" name="hips" id="hips" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                    <tr><td>shirt length</td><td><input type="text" name="shirtlength" id="shirtlength" alt="" value="" class="text ui-widget-content ui-corner-all" size="5" /></td></tr>
                </table>
                
            </td>
        </tr>
    </table>
    <?php 
	if($_SESSION['id'] == 0)
		echo "<i style=\"font-size:10px\">*note that you have not login and these information will not be saved under your account</i><br />";
	?>
    <img id="loading" src="images/loadingbar.gif" border="0" style="float:right" />
</div>
<div id="standard" title="select measurement for this shirt" align="center">
	select brand 
    <select id="company" class="ui-widget ui-state-default ui-corner-all" style="margin-right:10px">
        <option id="0">--select--</option>
        <?php
            $companyDB = "SELECT * FROM size_company"; 
            $company = createQuery($companyDB, $conn);
            
            while ($info = mysql_fetch_array($company)) {
                $id = $info['id'];
                $name = $info['name'];
                $image = $info['image'];
                
                echo "<option class=\"option company company_$id\" id=\"$id\" title=\"$name\" />$name</option>";
                
            }
        ?>
    </select>
    select size
    <select id="size" class="ui-widget ui-state-default ui-corner-all">
        <option id="0">--select--</option>
    </select>
    <button id="select_standard_measurement" class="use_this_standard">use this</button>
    
    <div align="center" style="padding-top:20px">
    	<img id="size" />
    </div>
</div>
<div id="exist" title="select measurement for this shirt" align="center">
	<p>which measurement do you want to choose</p>
    <select id="m_existing" class="ui-widget ui-state-default ui-corner-all">
    <?php
	
	if(!empty($_SESSION['id'])){
	
		$get_measurements = "SELECT id, name FROM account_measurement WHERE account_id =" . $_SESSION['id'];
		$data = createQuery($get_measurements, $conn);
		
		if (!mysql_num_rows($data))
			echo "";
		else{
		
			$text = "";
			while ($info = mysql_fetch_array($data)) {
				$m_id = $info[0];
				$m_name = $info[1];
				
				$text .= "<option id=\"$m_id\">$m_name</option>";
			}
			echo $text;
		}
	}
	
	?>
    </select>
    <button id="select_existing_measurement" class="use_this_existing">use this</button>
</div>
<div id="action" title="continue shopping" align="center">
	<p>would you like to add any other shirts?</p>
    <button id="select_shopping" class="action">yes, continue shopping</button>
    <button id="select_checkout" class="action">no, that's all i want</button>
</div>
<script type="text/javascript">

$( "div#question, div#customize, div#exist, div#standard, div#action" ).dialog("destroy").hide();
$("img#loading").hide();

$("button").button();
</script>