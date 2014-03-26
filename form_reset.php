<!DOCTYPE HTML> 
<html>
<head>
	<style>
		font-family: {courier, sans-serif;}
		font-size:	{14px;}
		.error {color: #FF0000;}
	</style>
    <script>
		function clean_hardware_form ()
		{
			document.forms["hardware_form"].reset();
			alert("clean_hardware_form()");
			document.hardware_form.getElementById("name").value = "";
			document.hardware_form.getElementById("car").selected = "1";
			alert("form reseteado.");
		}

		function checkForm (myForm)
		{
			var myForm	= document.getElementById(myFormId);
			var str		= "";

			alert ("Checking...");
			str.concat (str, "Name = ", document.hardware_form.getElementById("name").value, "\n");
			str.concat (str, "Gender = ", document.hardware_form.getElementById("gender").value, "\n");
			str.concat (str, "Car = ", document.hardware_form.getElementById("car").value, "\n");
			str.concat (str, "Feature = ", document.hardware_form.getElementById("feature").value, "\n");
			alert (str);
		}

		function clearElements(el) {
		    // variable declaration
		    var x, y, z, type = null, object = [];
		    // collect form elements
		    object[0] = document.getElementById(el).getElementsByTagName('input');
		    object[1] = document.getElementById(el).getElementsByTagName('textarea');
		    object[2] = document.getElementById(el).getElementsByTagName('select');
		    // loop through found form elements
		    for (x = 0; x < object.length; x++) {
		        for (y = 0; y < object[x].length; y++) {
		            // define element type
		            type = object[x][y].type;
		            switch (type) {
		            case 'text':
		            case 'textarea':
		            case 'password':
		                object[x][y].value = '';
		                break;
		            case 'radio':
		            case 'checkbox':
		                object[x][y].checked = '';
		                break;
		            case 'select-one':
		                object[x][y].options[0].selected = true;
		                break;
		            case 'select-multiple':
		                for (z = 0; z < object[x][y].options.length; z++) {
		                    object[x][y].options[z].selected = false;
		                }
		                break;
		            } // end switch
		        } // end for y
		    } // end for x
		}


	   function resetForm(myFormId)
	   {
		   var myForm = document.getElementById(myFormId);

	       for (var i = 0; i < myForm.elements.length; i++)
	       {
	           if ('submit' != myForm.elements[i].type && 'reset' != myForm.elements[i].type)
	           {
	               myForm.elements[i].checked = false;
	               myForm.elements[i].value = '';
	               myForm.elements[i].selectedIndex = 0;
	           }
	       }
		   history.pushState(stateObj, "", ('http://localhost/form_reset.php'));
		   myForm.submit();
	   }
	</script>
</head>
<body> 

<?php

$debugstr = "";

function resetParameters()
{
	$GLOBALS['debugstr'] .= "resetParameters()<br />";
	unset ($_GET) ;
	$GLOBALS['name'] = $GLOBALS['gender'] = $GLOBALS['car'] = $GLOBALS['feature'] = "";
	$GLOBALS['debugstr'] .= "Variables unset.<br />";

	echo "<script>
		alert('cleaning...');
	   	var myForm = document.getElementById('hardware_form');

       	alert ('resetForm() runs');
       	for (var i = 0; i < hardware_form.elements.length; i++)
       	{
           if ('submit' != hardware_form.elements[i].type && 'reset' != hardware_form.elements[i].type)
           {
               hardware_form.elements[i].checked = false;
               hardware_form.elements[i].value = '';
               hardware_form.elements[i].selectedIndex = 0;
           }
       	}
		</script>";

}



// define variables and set to empty values
$name = $gender = $car = $feature = "";
$nameErr = $genderErr = $carErr = $featureErr = "";
$selected = "selected=\"selected\"";


if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	if (empty($_GET["name"]))
	{
		$nameErr = "Name is required";
	}
	else
	{
		$name = test_input($_GET["name"]);
	  	// check if name only contains letters and whitespace
	  	if (!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$nameErr = "Only letters and white space allowed"; 
		}
	}

	if (empty ($_GET["gender"]))
	{
		$genderErr = "Gender is required";
	}
	else
	{
		$gender = test_input ($_GET["gender"]);
	}
	

	if (empty($_GET["car"]))
	{
		$car = "";
	}
	else
	{
		$car = test_input($_GET["car"]);
	}

	if (empty($_GET["feature"]))
	{
		$featureErr = "Feature is empty.";
		$feature = "off";
	}
	else
	{
		$feature = test_input($_GET["feature"]);
		$featureErr = $feature;
	}
}


function test_input($data)
{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form id="hw_form" name="hardware_form" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	
	
	Name: <input type="text" name="name" value="<?php echo $name;?>">
	<span class="error">* <?php echo $nameErr;?></span>
	<br><br>

	Gender:
	<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?>  value="female">Female
	<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?>  value="male">Male
	<span class="error">* <?php echo $genderErr;?></span>
	<br><br>

	<select name="car" size="1">
		<option value="volvo" <?php $str = ("volvo" == $car) ? $selected : "  " ; echo $str; ?>	 >Volvo</option>
		<option value="saab" <?php $str = ("saab" == $car) ? $selected : "  " ; echo $str; ?>	 >Saab</option>
		<option value="mercedes" <?php $str = ("mercedes" == $car) ? $selected : "  " ; echo $str; ?>	 >Mercedes</option>
		<option value="audi" <?php $str = ("audi" == $car) ? $selected : "  " ; echo $str; ?>	 >Audi</option>
	</select>
	<br><br>

	<label for="feature">Feature:</label>
	<input type="checkbox" name="feature"
		<?php if (isset($green) and $green == "on") echo "checked=\"checked\"" ?>
>
	<br><br>

	<input type="submit" name="submit" value="Submit"> 
	<input type="button" name="reset" value="Reset" onclick="resetForm('hardware_form')">
	<input type="button" name="check" value="Check" onclick="checkForm()">
	<input type="button" name="clear" value="Clear" onclick="clearElements()">
</form>

<?php
echo "<h2>Your Input:</h2>";

echo $name;
echo "<br>";
echo $gender;
echo "<br>";
echo $car;
echo "<br>";
echo $feature;
echo "<br>";
echo $debugstr;
echo "<br>";
echo date('l jS \of F Y h:i:s A');
?>

</body>
</html>