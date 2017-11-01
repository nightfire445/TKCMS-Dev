$(document).ready(function() {
  //Needs to be dynamically loaded once back-end is created
  //Static for prototype
  displayVendors(1, 5);
  displayVendors(0, 2);
  populateLocation();
  //Dropdown content needs to be dynamically generated
  //Probably change it to custom dropdown because this sux
  //var dropdown = "<div class='dropdown btn-group'><button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Change vendor</button><div class='dropdown-menu' aria-labelledby='dropdownMenu2'><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 1</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 2</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 3</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 4</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 5</button><div class='dropdown-divider'></div><button class='dropdown-item' type='button' >Clear Vendor</button></div></div>";
  
});

function displayVendors(state, num) {
  vendors = num;
  var generate_vendors = "";
  var buttons = "<div class='btn_container'><button type='button' class='btn btn-default' onclick='populateInfo(event)'>Edit Vendor</button><br/>";
  if(state == 1)
    buttons += "<button  type='button' class='btn btn-danger btn-xs'>Deactivate</button></div>"
  else
    buttons += "<button type='button' class='btn btn-success btn-xs'>Activate</button></div>"
  for(var i = 0; i < vendors; i++) {
    generate_vendors += "<div class='vendor'><div class='vendor_name'>Vendor " + (i+1) + "</div>" + buttons + "</div>";

  }
  //generate_vendors += "</tr></table>";
  if(state == 1)
    $("#active_vendors_container").html(generate_vendors);
  else
    $("#inactive_vendors_container").html(generate_vendors);
}

function populateLocation() {
  var output = "";
  var locations = ["Troy", "Schenectady"];
  for(var i = 0; i < locations.length; i++) {
    output += "<button class='dropdown-item' type='button' onclick='updateLocation(event)'>" + locations[i] + "</button>"
  }
  $("#dropdownMenu").html(output);
}

function updateLocation(event) {
  $("#location").html("Current Location: " + event.currentTarget.innerText);
  displayVendors(1, 5);
  displayVendors(0, 2);
}

function populateInfo(event) {
  $("#edit_vendor").modal();
}