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

$name = "username";
$field = array(
    "name" => $name,
    "type" => "text",
    "check" => "user",
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

$name = "email";
$field = array(
    "name" => $name,
    "type" => "email",
    "check" => "email",
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

$name = "password";
$field = array(
    "name" => $name,
    "type" => "password",
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

$name = "address";
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

$name = "tel";
$field = array(
    "name" => $name,
    "type" => "tel",
    "check" => "tel",
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

$name = "birthday";
$field = array(
    "name" => $name,
    "type" => "date",
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

$name = "gender";
$field = array(
    "name" => $name,
    "type" => "radio",
    "check" => "string",
    "condition" => "0",
    "class" => "field",
    "label" => ucfirst($name),
    "error" => "Error ".$name,
	"data" => array(0=>'Female', 1=>'Male'),
);
$value = '1';
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

$name = "random_key";
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

$name = "date_expiration";
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

$name = "login";
$field = array(
    "name" => $name,
    "type" => "datalist",
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

$name = "group";
$field = array(
    "name" => $name,
    "type" => "datalist",
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