$(document).ready(function() {
  //Needs to be dynamically loaded once back-end is created
  //Static for prototype
  displayVendors(1);
  displayVendors(0);

  //Dropdown content needs to be dynamically generated
  //Probably change it to custom dropdown because this sux
  //var dropdown = "<div class='dropdown btn-group'><button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Change vendor</button><div class='dropdown-menu' aria-labelledby='dropdownMenu2'><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 1</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 2</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 3</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 4</button><button class='dropdown-item' type='button' onclick='changeVendor(event)'>Vendor 5</button><div class='dropdown-divider'></div><button class='dropdown-item' type='button' >Clear Vendor</button></div></div>";
  
});

function displayVendors(state) {
  var vendors = 5;
  var generate_vendors = "";
  var buttons = "<div class='btn_container'><button class='btn btn-primary' data-toggle='modal' data-target='#edit_vendor'>Edit Vendor</button><br/>";
  if(state == 1)
    buttons += "<button class='btn btn-primary'>Deactivate</button></div>"
  else
    buttons += "<button class='btn btn-primary'>Activate</button></div>"
  for(var i = 0; i < vendors; i++) {
    generate_vendors += "<div class='vendor'><div class='vendor_name'>Vendor " + (i+1) + buttons + "</div></div>";

  }
  //generate_vendors += "</tr></table>";
  if(state == 1)
    $("#active_vendors_container").html(generate_vendors);
  else
    $("#inactive_vendors_container").html(generate_vendors);
}