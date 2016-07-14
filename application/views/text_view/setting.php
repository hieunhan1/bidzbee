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
	"data" => array(0=>'Disable', 1=>'Enable'),
);
$value = '1';
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

$name = "value";
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

$name = "order";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "string",
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