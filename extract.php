<?php
$jsonl = file_get_contents("C:\\Users\\Raditya RR\\.gemini\\antigravity-ide\\brain\\654d14bd-0eca-4b7d-97b7-f2bd77d4b513\\.system_generated\\logs\\transcript.jsonl");
$lines = explode(PHP_EOL, $jsonl);
$edits = [];
foreach($lines as $line) {
    if(empty($line)) continue;
    $step = json_decode($line, true);
    if(isset($step["tool_calls"])) {
        foreach($step["tool_calls"] as $call) {
            if($call["name"] === "replace_file_content" || $call["name"] === "multi_replace_file_content" || $call["name"] === "write_to_file") {
                if(strpos($call["args"]["TargetFile"] ?? "", "book/detail.php") !== false) {
                    $edits[] = $call;
                }
            }
        }
    }
}
file_put_contents("book_edits.json", json_encode($edits, JSON_PRETTY_PRINT));

