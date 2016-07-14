<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <script src="../public/js/jsJquery.js"></script>
  <script src="../public/js/jquery-ui.js"></script>
    
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; background-color: #CCC;}
  #sortable li span { position: absolute; margin-left: -1.3em; }
  </style>
</head>
<body>
 
<ul id="sortable">
  <li>Item 1</li>
  <li>Item 2</li>
  <li>Item 3</li>
  <li>Item 4</li>
  <li>Item 5</li>
  <li>Item 6</li>
  <li>Item 7</li>
</ul>
 <div id="submit">submit</div>
 <script>
 $(document).ready(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
            
    $("#submit").on("click", function(){
        $("#sortable li").each(function(index, element){
            console.log(index, $(element).html() );
        });
    });
 });
 </script>
</body>
</html>