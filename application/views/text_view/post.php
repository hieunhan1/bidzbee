<?php
$html .= '<div id="collection" class="hidden">'.$dataCollection['collection'].'</div>';
$html .= '<div id="action" class="hidden">'.$this->action.'</div>';
$html .= '<ul class="iAC-Collection">';

$name = "_id";
$field = array(
    "name" => $name,
    "type" => "hidden",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "status";
$field = array(
    "name" => $name,
    "type" => "radio",
    "check" => "string",
    "condition" => "1",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
	"data" => array(0=>'Private', 1=>'Public'),
);
$value = '1';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "properties";
$field = array(
    "name" => $name,
    "type" => "radio",
    "check" => "string",
    "condition" => "1",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
	"data" => array(1=>'Catalog', 2=>'Articles'),
);
$value = '2';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "page";
$field = array(
    "name" => $name,
    "type" => "radio",
    "check" => "string",
    "condition" => "1",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
	"data" => array('home'=>'Home', 'about'=>'About', 'article'=>'Article', 'product'=>'Product', 'contact'=>'Contact'),
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "name";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "1",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "alias";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "1",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "url";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "title";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "description";
$field = array(
    "name" => $name,
    "type" => "textarea",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "tags";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "code";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "0",
    "maxlength" => "20",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "price_cost";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "number",
    "condition" => "0",
    "maxlength" => "20",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "price_start";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "number",
    "condition" => "0",
    "maxlength" => "20",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "price_step";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "number",
    "condition" => "0",
    "maxlength" => "20",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "shipping";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "date_bid";
$field = array(
    "name" => $name,
    "type" => "datetime",
    "check" => "date",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "order";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "number",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '0';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "img";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$name = "content";
$field = array(
    "name" => $name,
    "type" => "textckeditor",
    "check" => "string",
    "condition" => "0",
	"view" => "valuesFull",
    "class" => "field",
    "error" => "Error ".$name,
);
$value = '';
if(isset($dataCurrent[$name])){
    $value = $dataCurrent[$name];
}
$html .= $form->field($field, $name, $value);

$html .= '<li class="field" name="submit" type="noaction">
        <span class="label"></span>
        <ul class="values">
            <p class="clear20"></p>
            <li class="field">
                <input type="button" name="iAC-Submit" value="Submit" class="iAC-Submit btnLarge bgBlue corner5" />
            </li>
        </ul>
    </li>
</ul>';

$html .= $css_admin.$javascript_admin;