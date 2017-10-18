$(document).ready( function() {
  //Needs to be dynamically loaded once back-end is created
  //Static for prototype
  
  //This value would be dynamically generated based on the number of stalls
  var vendors = 5;
  var num_cols = 4;
  //var generate_vendors = "<table id='vendors_table'><tr>";
  var generate_vendors = "";

  //Dropdown content needs to be dynamically generated
  //Probably change it to custom dropdown because this sux
  var dropdown = "<div class='dropdown btn-group'><button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Change vendor</button><div class='dropdown-menu' aria-labelledby='dropdownMenu2'><button class='dropdown-item' type='button'>Vendor 1</button><button class='dropdown-item' type='button'>Vendor 2</button><button class='dropdown-item' type='button'>Vendor 3</button><button class='dropdown-item' type='button'>Vendor 4</button><button class='dropdown-item' type='button'>Vendor 5</button><div class='dropdown-divider'></div><button class='dropdown-item' type='button'>Clear Vendor</button></div></div>";
  for(var i = 0; i < vendors; i++) {
    if(i >= num_cols && (i%num_cols == 0)) {
      //generate_vendors += "</tr><tr>";
    }
    //generate_vendors += "<td class='vendor'><div class='vendor_name'>Vendor " + (i+1) + "</div>" + dropdown + "</td>";
    generate_vendors += "<div class='vendor'><div class='vendor_name'>Vendor " + (i+1) + "</div>" + dropdown + "</div>";

  }
  generate_vendors += "</tr></table>";
  $("#vendors_container").html(generate_vendors);
  
  //$(".dropdown").on("click", function() {
    //$("#dropdown0").toggle();
  //});
});