<!DOCTYPE HTML> 
<html>
<head>
	<style>
	body {
		font-family:	sans-serif;
		font-size:		14px;
	}
	/*.error {color: #FF0000;}*/
	</style>
    <script>
		function clean_hw_form ()
		{
			document.forms["hw_form"].reset();
			alert("clean_hw_form()");
			document.hw_form.getElementById("name").value = "";
			document.hw_form.getElementById("car").selected = "1";
			alert("form reseteado.");
		}

		function checkForm (myForm)
		{			
			document.hw_form.getElementById("name").value		= "";
			document.hw_form.getElementById("gender").value	= "";
			document.hw_form.getElementById("car").value		= "";
			document.hw_form.getElementById("feature").value	= "";
		}

		function clearElements(el)
		{
		    // variable declaration
		    var x, y, z, type = null, object = [];
		    // collect form elements
		    object[0] = document.getElementById(el).getElementsByTagName('input');
		    object[1] = document.getElementById(el).getElementsByTagName('textarea');
		    object[2] = document.getElementById(el).getElementsByTagName('select');
		
		    // loop through found form elements
		    for (x = 0; x < object.length; x++)
			{
		        for (y = 0; y < object[x].length; y++)
				{
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


	   function emptyForm(myFormId)
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

function emptyForm()
{
	$GLOBALS['debugstr'] .= "emptyForm()<br />";
	unset ($_GET) ;
	$GLOBALS['name'] = $GLOBALS['gender'] = $GLOBALS['car'] = $GLOBALS['feature'] = "";
	$GLOBALS['debugstr'] .= "Variables unset.<br />";

	echo "<script>
		alert('cleaning...');
	   	var myForm = document.getElementById('hw_form');

       	alert ('emptyForm() runs');
       	for (var i = 0; i < hw_form.elements.length; i++)
       	{
			switch (hw_form.elements[i].type)
			{
			case 'submit':
			case 'reset':
			case 'button':
				/* do nothing */
				break;
			default:
                hw_form.elements[i].checked = false;
                hw_form.elements[i].value = '';
                hw_form.elements[i].selectedIndex = 0;
			}
			/***
           if ('submit' != hw_form.elements[i].type && 'reset' != hw_form.elements[i].type)
           {
               hw_form.elements[i].checked = false;
               hw_form.elements[i].value = '';
               hw_form.elements[i].selectedIndex = 0;
           }
			***/
       	}
		</script>";
}



// define variables and set to empty values
$name = $gender = $car = $feature = "";
$selected = "selected=\"selected\"";


if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	if (isset($_GET["name"]))		$name		= test_input($_GET["name"]);
	if (isset($_GET["gender"]))		$gender		= test_input ($_GET["gender"]);
	if (isset($_GET["car"]))		$car		= test_input($_GET["car"]);
	if (isset($_GET["feature"]))	$feature	= test_input($_GET["feature"]);
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
<form id="hw_form_id" name="hw_form_name" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	
<fieldset id="hardware" class="left">

<div>
	<label for="name">Name:</label>
	<input type="text" name="name" value="<?php echo $name;?>">
</div>
	<br>
	<br>
<div>
	<label for="gender">Gender:</label>
	<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?>  value="female">Female
	<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?>  value="male">Male
</div>
	<br>
	<br>
<div>
	<label for="car">Gender:</label>
	<select name="car" size="1">
		<option value="volvo" <?php $str = ("volvo" == $car) ? $selected : "  " ; echo $str; ?>	 >Volvo</option>
		<option value="saab" <?php $str = ("saab" == $car) ? $selected : "  " ; echo $str; ?>	 >Saab</option>
		<option value="mercedes" <?php $str = ("mercedes" == $car) ? $selected : "  " ; echo $str; ?>	 >Mercedes</option>
		<option value="audi" <?php $str = ("audi" == $car) ? $selected : "  " ; echo $str; ?>	 >Audi</option>
	</select>
</div>
	<br>
	<br>

<div>
	<label for="feature">Feature:</label>
	<input type="checkbox" name="feature"
		<?php if (isset($green) and $green == "on") echo "checked=\"checked\"" ?>
>
	<br>
	<br>
</div>

</fieldset>

	<input type="submit" name="submit" value="Submit">
	<input type="reset" />
	<input type="button" name="empty" value="Empty" onclick="emptyForm('hw_form')">
	<input type="button" name="check" value="Check" onclick="checkForm()">
	<input type="button" name="clear" value="Clear" onclick="clearElements('hw_form')">
</form>

<?php
echo "<h2>Your Input:</h2>";

echo "Name: " . $name;
echo "<br>";
echo "Gender: " . $gender;
echo "<br>";
echo "Car: " . $car;
echo "<br>";
echo "Feature: " . $feature;
echo "<br>";
echo $debugstr;
echo "<br>";
echo date('l jS \of F Y h:i:s A');
?>

</body>
</html>