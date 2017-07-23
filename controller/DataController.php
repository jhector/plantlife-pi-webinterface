<?php
class DataController extends BaseController {
    public function indexAction($db, $user) {
        global $twig;

        if (!isset($_GET['type'], $_GET['start'], $_GET['end'])) {
            throw new Exception("Missing parameters");
        }

        $type = $_GET['type'];
        $start = $_GET['start'];
        $end = $_GET['end'];

        $res = $db->raw_query("SELECT d.value, d.date FROM sensortype t" .
                              " INNER JOIN sensordata d ON d.typeid = t.id" .
                              " WHERE t.name = '" . $db->escape($type) . "'" .
                              " AND d.date" .
                              " BETWEEN '" . $db->escape($start) . " 00:00:00'" .
                              " AND '" . $db->escape($end) . " 23:59:59'");

        $dates = array();
        $values = array();
        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
            array_push($values, $row['value']);
            array_push($dates, $row['date']);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            "type" => $type,
            "dates" => $dates,
            "values" => $values
            ));

        exit(0);
    }
}
?>
