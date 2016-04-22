// declare a global  XMLHTTP Request object
var XmlHttpObj;

// create an instance of XMLHTTPRequest Object, varies with browser type, try for IE first then Mozilla
function CreateXmlHttpObj()
{
	// try creating for IE (note: we don't know the user's browser type here, just attempting IE first.)
	try	{
		XmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP");
	} catch(e) {
		try {
			XmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
		} catch(oc) {
			XmlHttpObj = null;
		}
	}

	// if unable to create using IE specific code then try creating for Mozilla (FireFox) 
	if(!XmlHttpObj && typeof XMLHttpRequest != "undefined") {
		XmlHttpObj = new XMLHttpRequest();
	}
}

// this function called when state of  XmlHttpObj changes
// we're interested in the state that indicates data has been
// received from the server
function StateChangeHandler()
{
	// state ==4 indicates receiving response data from server is completed
	if(XmlHttpObj.readyState == 4) {
		// To make sure valid response is received from the server, 200 means response received is OK
		if(XmlHttpObj.status == 200) {
			populateModelList(XmlHttpObj.responseXML.documentElement);
		} else {
			alert("problem retrieving data from the server, status code: "  + XmlHttpObj.status);
		}
	}
}

function getZone(zoneListId)
{
	zoneListFormId = zoneListId;
	var zoneList = document.getElementById(zoneListId);
	var selectedCountry = zoneList.options[zoneList.selectedIndex].value;
	var requestUrl;
	requestUrl = "xml_zone_data.php" + "?filter=" + encodeURIComponent(selectedCountry);

	CreateXmlHttpObj();
	if(XmlHttpObj) {
        // assign the StateChangeHandler function ( defined below in this file)
        // to be called when the state of the XmlHttpObj changes
        // receiving data back from the server is one such change
		XmlHttpObj.onreadystatechange = ZoneChangeHandler;
		
		// define the iteraction with the server -- true for as asynchronous.
		XmlHttpObj.open("GET", requestUrl, true);
		
		// send request to server, null arg  when using "GET"
		XmlHttpObj.send(null);		
	}
}

// this function called when state of  XmlHttpObj changes
// we're interested in the state that indicates data has been
// received from the server
function ZoneChangeHandler()
{
	// state ==4 indicates receiving response data from server is completed
	if(XmlHttpObj.readyState == 4) {
		// To make sure valid response is received from the server, 200 means response received is OK
		if(XmlHttpObj.status == 200) {
			populateZoneList(XmlHttpObj.responseXML.documentElement);
		} else {
			alert("problem retrieving data from the server, status code: "  + XmlHttpObj.status);
		}
	}
}

// populate the contents of the dropdown list
function populateZoneList(zoneNode)
{
	if(zoneListFormId == 'country') {
		var zoneFormId = 'state';
	}

    var zoneList = document.getElementById(zoneFormId);
	
	// clear the list 
	for (var count = zoneList.options.length-1; count >-1; count--) {
		zoneList.options[count] = null;
	}

	var zoneNode = zoneNode.getElementsByTagName('zone');
	var idValue;
	var textValue; 
	var optionItem;
	
	// populate the dropdown list with data from the xml doc
	for (var count = 0; count < zoneNode.length; count++) {
   		textValue = GetInnerText(zoneNode[count]);
		idValue = zoneNode[count].getAttribute("id");
		optionItem = new Option( textValue, idValue,  false, false);
		zoneList.options[zoneList.length] = optionItem;
	}
}

// returns the node text value 
function GetInnerText (node)
{
	 return (node.textContent || node.innerText || node.text) ;
}