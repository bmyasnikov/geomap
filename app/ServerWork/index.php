<?php

$lat = $_GET['lat'];
$lng = $_GET['lng'];

	$link = mysqli_connect("localhost", "root", "root", "locations")
	or die(mysqli_error($link));
	if($link) {
      if(($lat=="")&&($lng=="")) {
		$query = "SELECT * FROM markers";
   } else {
      //формула хаверсина
      $query = "SELECT lat, lng,
      (6371 * acos(cos(radians('$lat')) * cos( radians(markers.lat)) 
      * cos(radians(markers.lng)-radians('$lng'))+sin(radians('$lat')) 
      * sin(radians(markers.lat)))) AS distance 
      FROM markers 
      HAVING distance < 10
      ORDER BY distance";
   }
   $result = mysqli_query($link, $query);
   $arr = array();
   while($row=mysqli_fetch_assoc($result)) {
   $arr[] = $row;
}
}
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
mysqli_close($link);

?>