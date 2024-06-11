<?php
function load_moon_phases($obj, $callback)
{
    $gets = [];
    foreach ($obj as $key => $value) {
        $gets[] = $key . "=" . urlencode($value);
    }
    $gets[] = "LDZ=" . (new DateTime("{$obj['year']}-{$obj['month']}-01"))->getTimestamp();
    $url = "https://www.icalendar37.net/lunar/api/?" . implode("&", $gets);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        $data = json_decode($response, true);
        call_user_func($callback, $data);
    } else {
        echo "Error al obtener los datos.";
    }
}
function phases_month($moon)
{
    $phMax = array();
    foreach ($moon['phase'] as $nDay => $phaseData) {
        $message = '';


        if ($phaseData['isPhaseLimit']) {

            if ($phaseData['phaseName'] == "Cuarto menguante") {

                $message = "Fortalece el cabello";
                '<span' . $message . '</span>';


            }
            if ($phaseData['phaseName'] == "Cuarto menguante") {

                $message = "Fortalece el cabello";
                '<span' . $message . '</span>';

            }
            if ($phaseData['phaseName'] == "Cuarto creciente") {

                $message = "Estimular el crecimiento";
                '<span' . $message . '</span>';

            }
            if ($phaseData['phaseName'] == "Luna nueva") {

                $message = "Evitar: Favorece la caida";
                '<span' . $message . '</span>';

            }
            if ($phaseData['phaseName'] == "Luna llena") {

                $message = "Crece más saludable y brillante.";
                '<span' . $message . '</span>';

            }
            $phMax[] = '<div>
            <span>' . $nDay . '</span>' .
                $phaseData['svg'] . '<div>' . $phaseData['phaseName'] . '<br>' . $message . '</div>
             </div>';


        }


    }

    $width = 80 / count($phMax);
    $html = "<b>" . $moon['monthName'] . " " . $moon['year'] . "</b>";
    foreach ($phMax as $element) {
        $html .= '<div style="width:' . $width . '%">' . $element . '</div>';
    }
    echo $html;

}

$configMoon = array(
    'lang' => 'es',
    'month' => date('n'),
    'year' => date('Y'),
    'size' => '100%',
    'lightColor' => 'rgb(255,255,230)',

);
load_moon_phases($configMoon, 'phases_month');
?>