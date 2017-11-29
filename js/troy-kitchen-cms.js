$(document).ready(function() {
  $("#del_vendor").on('click', function() {
    $("#edit_vendor").modal('toggle');
    $("#confirm").modal('toggle');
  });
  
  $("#confirm_delete").on('click', function() {
    $("#delete_vendor").click();
  });
  
  $("#cancel").on('click', function() {
    $("#edit_vendor").modal('toggle');
  });
});

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

function populateInfo(event, vendor_data) {
  console.log(vendor_data);
  var name = vendor_data.name;
  $("#edit-vendor-name").val(name);
  var desc = vendor_data.description;
  $("#edit-description").val(desc);
  var id = vendor_data.vendor_id;
  $("#vendor-id").val(id);
  var logo = vendor_data.logo;
  var insert_image = 'No Logo Available';
  if(logo != "" & logo != null) {
    insert_image = "<img src='../resources/" + logo + "' alt='" + logo + "' class='logo'>";
  }
  $("#existing_logo").html(insert_image);
  var images = vendor_data.images;
  var image_string = "";
  for(var i = 0; i < images.length; i++) {
    image_string += "<div class='image-container'><img src='../resources/" + images[i].image_url + "' alt='" + images[i].image_url + "' class='images'>";
    image_string += "<button class='btn btn-danger delete-img' onclick='$.post( \"dashboard.php\", { delete_image: \"\", image_url: \"" + images[i].image_url + "\" } ); '>Delete</button></div>";
  }
  $("#existing_images").html(image_string);
  var menu = vendor_data.menu_url;
  var insert_menu = 'No Menu Available';
  if(menu != "" & menu != null) {
    insert_menu = "<img src='../resources/" + menu + "' alt='" + menu + "' class='menu'>";
  }
  $("#existing_menu").html(insert_menu);
  $("#edit_vendor").modal();
}

