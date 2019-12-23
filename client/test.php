<?php
/*
php code/client/test.php -f=1 -t=2 -s=1 -d=10 -u="http://157.245.220.205/slim/4.3.0/"
html range(32, 2048, 32);
php range(4, 512, 4);
frameworks range(1, 300, 1);
*/
$connectionsFrom = 1;
$connectionsTo = 10;
$connectionsStep = 1;
$durationSeconds = 10;
$testRange = [1];

$opt = getopt("u:f::t::s::d::");

validateOptions($opt);

$url = (string)$opt['u'];
$durationSeconds = array_key_exists('d', $opt) ? (int)$opt['d'] : $durationSeconds;
$testRange = setTestRangeFromOptions($opt, $connectionsFrom, $connectionsTo, $connectionsStep);
$testName = extractTestNameFromUrl($url);
$logDir = "/root/data";
if (!file_exists($logDir)) {
    mkdir($logDir);
}
$logFile = "{$logDir}/test.{$testName}.log";
$wrkFile = "/root/wrk/wrk";

$cnt = 1;

foreach ($testRange as $connections) {
    
    $output = [];

    $startTime = (new DateTime())->format('Y-m-d H:i:s');
    $command = "{$wrkFile} -t1 -c{$connections} -d{$durationSeconds}s -s test.lua {$url} --timeout=1s";

    if ($cnt == 1) {
        $response = testUrl($url);
        echo "{$response}\n\n";
    }

    echo "TEST #{$cnt} - {$startTime} - \"{$command}\"\n";

    exec($command, $output);

    $json = extractJsonFromOutput($output);

    echo "{$json}\n\n";

    $endTime = (new DateTime())->format('Y-m-d H:i:s');
    $json = addDataToJson($json, $cnt, $startTime, $endTime, $testName, $command);

    file_put_contents($logFile, $json, FILE_APPEND | LOCK_EX);

    $cnt++;

}

function validateOptions($opt) {
    if (
        array_key_exists('f', $opt)
        && array_key_exists('t', $opt)
        && (int)$opt['t'] < (int)$opt['f']
    ) {
        echo "ERROR: -t must be bigger than -f\n";
        exit;
    }
    if (
        array_key_exists('s', $opt)
        && (int)$opt['s'] > (int)$opt['t']-(int)$opt['f']
    ) {
        echo "ERROR: -s must be smaller than -t\n";
        exit;
    }
}

function setTestRangeFromOptions($opt, $connectionsFrom, $connectionsTo, $connectionsStep) {
    $connectionsFrom = array_key_exists('f', $opt) ? (int)$opt['f'] : $connectionsFrom;
    $connectionsTo = array_key_exists('t', $opt) ? (int)$opt['t'] : $connectionsTo;
    $connectionsStep = array_key_exists('s', $opt) ? (int)$opt['s'] : $connectionsStep ;
    if ($connectionsTo > $connectionsFrom) {
        $testRange = range($connectionsFrom, $connectionsTo, $connectionsStep);
    } elseif ($connectionsTo == $connectionsFrom) {
        $testRange = [$connectionsTo];
    } else {
        $testRange = [$connectionsFrom];
    }
    return $testRange;
}

function testUrl($url) {
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_HEADER, 1); 
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    } catch (Exception $e) {
        exit;
    }
}

function extractJsonFromOutput ($output) {
    if (!$output) {
        exit;
    }
    $scriptJsonMarker = '---';
    $outputString = implode(' ', $output);
    $jsonStart = strpos($outputString, $scriptJsonMarker) + strlen($scriptJsonMarker);
    $jsonEnd = strpos($outputString, $scriptJsonMarker, -(strlen($scriptJsonMarker)*2));
    $jsonLength = $jsonEnd-$jsonStart;
    $json = substr($outputString, $jsonStart, $jsonLength);
    return $json;
}

function addDataToJson($json, $cnt, $startTime, $endTime, $testName, $command) {
    if (!$json) {
        exit;
    }
    $arr = json_decode($json, true);
    $arr['start'] = $startTime;
    $arr['end'] = $endTime;
    $arr['name'] = $testName;
    $arr['cnt'] = $cnt;
    $arr['command'] = $command;
    $json = json_encode($arr) . ", ";
    return $json;
}

function extractTestNameFromUrl($url) {
    $pattern = '@^http://[^/]+/([^/]+)/([^/]+)/$@i';
    $urlExample = "http://ip/framework/version/";
    $framework = '';
    $version = '';
    if (!preg_match($pattern, $url, $matches)) {
        echo "ERROR: incorrect url {$url}, must be {$urlExample}\n";
        exit;
    }
    if (!array_key_exists(1, $matches)) {
        echo "ERROR: incorrect url {$url}, framework name is not found (must be {$urlExample})\n";
        exit;
    }
    if (!array_key_exists(2, $matches)) {
        echo "ERROR: incorrect url {$url}, framework version is not found (must be {$urlExample})\n";
    }
    $framework = $matches[1];
    $version = $matches[2];
    return "{$framework}-{$version}";
}
?>
