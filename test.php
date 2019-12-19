<?php
$baseUrl = 'http://157.245.220.205';
$scriptFile = 'test.lua';
#$wrkFile = __DIR__ . '/wrk';
$wrkFile = 'wrk';
$scriptJsonMarker = '---';

/*
html range(32, 2048, 32);
php range(4, 512, 4);
frameworks range(1, 300, 1);
*/

//$targets = ['html', 'php', 'pbot', 'slim', 'slim-sk', 'phalcon', 'ci', 'symfony', 'laravel', 'cake', fatfree']

$testType = 'run1';
$testRange = range(10, 11, 1);
$testTarget = 'slim/4.3.0';
$durationSeconds = 10;
$startFromNewMinute = 0;
$secondsToSleepAfter = 0;
$testUrl = "{$baseUrl}/{$testTarget}/";
if ($testTarget == 'fatfree') {
    $testUrl = rtrim($testTarget, '/');
}
$testTargetName = str_replace('/', '-', $testTarget);
$logFile = __DIR__ . "/test.{$testTargetName}.log";
//$testRange = [];

$cnt = 1;

foreach ($testRange as $connections) {
    
    $output = [];

    if ($startFromNewMinute) {
        waitTillNewMinute();
    }

    $startSql = (new DateTime())->format('Y-m-d H:i:s');
    $command = "{$wrkFile} -t1 -c{$connections} -d{$durationSeconds}s -s {$scriptFile} {$testUrl} --timeout=1s";

    if ($cnt == 1) {
        $testUrlResponse = testUrl($testUrl);
        echo "{$testUrlResponse}\n";
    }

    echo "TEST #{$cnt} - {$startSql} - {$command}\n";

    exec($command, $output);

    $json = extractJsonFromOutput($output, $scriptJsonMarker);

    echo "{$json}\n\n";

    $json = addDataToJson($json, $cnt, $startSql, $testTarget, $testType, $command);

    file_put_contents($logFile, $json, FILE_APPEND | LOCK_EX);

    $cnt++;

    if ($secondsToSleepAfter) {
        sleep($secondsToSleepAfter);
    }

}

function testUrl($testUrl) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $testUrl);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    $output = curl_exec($ch);
    curl_close($ch);
    //$output = json_decode($output, true);
    return $output;
}

function waitTillNewMinute() {
    $seconds = (int)(new DateTime())->format('s');
    if ($seconds <= 59) {
        $secondsToNewMinute = 60-$seconds;
        echo "Waiting for new minute {$secondsToNewMinute}sec ...\n";
        sleep($secondsToNewMinute);
    }
}

function extractJsonFromOutput ($output, $scriptJsonMarker) {
    $outputString = implode(' ', $output);
    $jsonStart = strpos($outputString, $scriptJsonMarker) + strlen($scriptJsonMarker);
    $jsonEnd = strpos($outputString, $scriptJsonMarker, -(strlen($scriptJsonMarker)*2));
    $jsonLength = $jsonEnd-$jsonStart;
    $json = substr($outputString, $jsonStart, $jsonLength);
    return $json;
}

function addDataToJson($json, $cnt, $startSql, $testTarget, $testType, $command) {
    $arr = json_decode($json, true);
    $arr['start'] = $startSql;
    $arr['end'] = (new DateTime())->format('Y-m-d H:i:s');
    $arr['name'] = $testTarget;
    $arr['type'] = $testType;
    $arr['cnt'] = $cnt;
    $arr['command'] = $command;
    $json = json_encode($arr) . ", ";
    return $json;
}

?>
