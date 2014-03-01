<!DOCTYPE html>
<head>
	<script type="text/javascript">		
		
		/*
		* Function used to create XML for all the controls and populate in txtXML.
		*/
		function addText()
		{
			//Variables decalaration
			var applicationTitle, screenTitle, selectedControls,controlName,controlType,controlValue, xmlText;
			
			//Assign values
			applicationTitle = document.getElementById("txtApplicationName").value;
			screenTitle = document.getElementById("txtScreenName").value;
			selectedControls = document.getElementById("txtXml").value;		
			controlName = document.getElementById("controlName").value;	
			controlType = document.getElementById("controlType").value; 	
			controlValue = document.getElementById("controlValue").value;	
			
			//Framing xml	
			xmlText =  '<?xml version="1.0" encoding="UTF-8"?><fields>';
			
			//Application Name
			xmlText = xmlText + "<application_name>"+applicationTitle+"</application_name>";
			
			//Screen Name
			xmlText = xmlText + "<screen_name>"+applicationTitle+"</screen_name>";
			
			if ( selectedControls.length > 0 )
			{						
				xmlText = selectedControls.replace("</fields>","") + "\n" + getXml(controlName,controlType,controlValue);
			}
			else
			{
				xmlText = xmlText + getXml(controlName,controlType,controlValue);
			}			
			xmlText = xmlText + "</fields>";
			document.getElementById("txtXml").innerHTML = xmlText;
			
			//Clear the content of the control
			document.getElementById("controlName").value = "";
			document.getElementById("controlType").selectedIndex = 0;
			document.getElementById("controlValue").value = "";
		}
		
		/*
		* Function used to show or hide the controlValue based upon the control type
		* Usually control values parameter is required only for Drop down, Radio Button and Checkbox
		*/
		function visibleControl(sel)
		{
			var controlType = sel.options[sel.selectedIndex].value;  
			if ( controlType == "spinner" || controlType == "radiobutton" || controlType == "checkbox" )
			{						
				document.getElementById("controlValue").style.display = "block";				
			}
			else
			{
				document.getElementById("controlValue").style.display = "none";	
			}
		}
		
		/*
		* Function used to ammend the | symbol when press enter key
		*/
		function fKeyDown(e) 
		{
			var  kc = window.event ? window.event.keyCode : e.which;
			if (kc == 13) 
			{
				document.getElementById('controlValue').value = document.getElementById('controlValue').value + "|";
			} 
		}
		
		/*
		* Function used to get the XML based upon each control add
		*/
		function getXml(controlName, controlType, controlValue)
		{
			var xmlText = "<field><fieldname>" + controlName + "</fieldname>";			
			xmlText = xmlText + "<fieldtype>" + controlType +"</fieldtype>";			
			if (controlValue.length > 0 )
			{				
				var controlValues = controlValue.split("|");
				if (controlValues.length > 0 )
				{
					xmlText = xmlText + "<values>";						
					for (var index=0,len=controlValues.length; index<len; index++)
					{
						
						xmlText = xmlText + "<fieldvalue"+index+">"+ controlValues[index] +"</fieldvalue"+index+">";
					}				
					xmlText = xmlText + "</values>";	
				}			
			}
			xmlText=xmlText + "</field>";
			return xmlText;
		}
		
		
	</script>
</head>
<body> 
	<div  style="background-color:lightgrey"><h2 align="center">Android Application Framework</h2></div>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
		<table>
			<tr>
				<td>Application Name</td>
				<td><input type="text" name="txtApplicationName" id="txtApplicationName"/></td>
			</tr>
			<tr>
				<td>Screen Name</td><td><input type="text" name="txtScreenName" id="txtScreenName"/></td>
			</tr>
			<tr border><td>Field Name</td><td><input type="text" name="controlName" id="controlName"></td>
			<td>
				Field Type : 
				<select name="controlType" id="controlType" onchange="visibleControl(this);">
				  <option value="normaltext">Normal Text Box</option>
				  <option value="numbertext">Number</option>
				  <option value="radiobutton">Radio Button</option>
				  <option value="datepicker">Date Picker</option>
				  <option value="spinner">Drop Down</option>
				  <option value="checkbox">Check Box</option>				 
				  <option value="phonetext">Phone</option>
				  <option value="multilinetext">Multiline Text</option>
				  <option value="passwordtext">Password Text</option>	
				  <option value="emailtext">Email</option>		
				  <option value="uritext">Web URL</option>
				</select>	
			</td>
			<td>
				<textarea name="controlValue" id="controlValue" rows="5" cols="30" style="display:none" onKeyDown=javascript:fKeyDown(event);></textarea>
			</td>
			<td><input type="button" onclick="addText();" name="btnAdd" value="Add" width="100"/></td>
			</tr>
			<tr>
				<td>XML </td><td colspan="6" align="left"><textarea name="txtXml" id="txtXml" rows="5" cols="100"></textarea>
				</td>
			</tr>
			<tr></tr>
			
			</table>
			<div align="center"><input type="submit" name="submit" value="Generate" align="center"></div>
			<p style="background-color:lightgrey" align="center">
			<?php
				if(isset($_POST['submit']))
				{
					$txtXml  = $_POST['txtXml'];	
					file_put_contents("dynamic_fields.xml", $txtXml);	
					echo "dynamic_fields.xml has been generated successfully";		
				}	
			?>
			</p>
		</form>
		<div  style="background-color:lightgrey"><h5 align="center">Msc Online | AU-KBC | Project by Kumaravel</h2></div>
	</body>
</html>
