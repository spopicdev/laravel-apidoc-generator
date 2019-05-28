```json

@if(!empty($route['request']))

@php

$request = $route['request'];

function is_json($json) {
  return is_string($json) && is_array(json_decode($json, true)) ? true : false;
}

function parse_array($data) {
  static $recursion = 0;
  $json = "{ \n";
  if (is_json($data)){
    $data = json_decode($data, true);
  }

  foreach ($data as $index => $key) {
    if (!is_numeric($index)) {
        $index = "\t" . '"'. $index . '"';
      }

    if (is_json($key)) {

      $array = json_decode($key);
      $json .=  $index . ': ' . parse_array($key) . " \n";
      $recursion++;
    } elseif ( is_array($key)) {
      $json .=  $index . ' : ' . parse_array($key) . " \n";
      $recursion++;
    } else {

      if (is_numeric($key)) {
        $json .= $index . ': ' . $key . ",\n";
      } else {
        $json .= $index . ': ' . '"' . $key . '"' . ",\n";
      }
    }
    }
    $json .= "}";

  return $json;
}

function parseContent($content) {
  if (is_array($content)) {
     return parse_array($content);
  }
}

echo parseContent($request[0]);
@endphp

@endif

```
