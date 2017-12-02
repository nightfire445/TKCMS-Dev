function populateContent(vendor_data) {
  console.log(vendor_data);
  output = "";
  output += "<h2 class='vendor_name'>" + vendor_data.name + "</h2>";
  output += "<h3 class='vendor_desc'>" + vendor_data.description + "</h3>";
  output += "<div id='content_container'>";
  
  var menu = vendor_data.menu_url;
  var insert_menu = "<p>No Menu Available for " + vendor_data.name + "</p>";
  if(menu != "" & menu != null) {
    insert_menu = "<div id='menu_container'><img src='../resources/" + menu + "' alt='Unable to load vendor menu' class='menu'></div>";
  }
  output += insert_menu;
  var images = vendor_data.images;
  output += "<div id='images_container'>";
  var image_string = "";
  for(var i = 0; i < images.length; i++) {
    image_string += "<div class='image-container'><img src='../resources/" + images[i].image_url + "' alt='Unable to load vendor image' class='images'>";
    image_string += "</div>";
  }
  output += image_string + "</div></div>";
  $("#content").html(output);
}