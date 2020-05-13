<?php

// Please do NOT run this on a browser. Instead, run this on your
// system with the following command (on the main Powerhouse dir):
//
//     php system/cli/issue_writer.php
//
// This should automatically start the process, and your Step 1a and
// 1b content should be output to the terminal.
//
// This script is available only in English.

// This is to make sure you're not running this in a browser.
// As you should.

if (substr(php_sapi_name(), 0, 3) != "cli") {
    echo "Please run this in a CLI terminal instead.";
    exit();
}

function in() {
    $handle = fopen("php://stdin","r");
    $line = fgets($handle);
    fclose($handle);
    return $line;
}

function ask($q) {
    out($q);
    $handle = fopen("php://stdin","r");
    $line = fgets($handle);
    fclose($handle);
    return $line;
}

$finalOut = "";
function final_out($s = "") {
    global $finalOut;
    $finalOut .= $s . PHP_EOL;
    echo $s . PHP_EOL;
}

function out($s = "") {
    echo "[" . date("Y-m-d H:i:s") . "] " . $s;
}

function outln($s = "") {
    echo "[" . date("Y-m-d H:i:s") . "] " . $s . PHP_EOL;
}

function ln() {
    outln();
}

function outr($r, $s = "") {
    $o = "";
    for ($i = 0; $i < $r; $i++)
        $o .= $s;

    echo "[" . date("Y-m-d H:i:s") . "] " . $o . PHP_EOL;
}

function outc($s = "", $m = 45, $p = 4, $pc = " ", $sc = " ") {
    if (strlen($s) == 0) {
        ln();
        return;
    }
    $sl = strlen($s);
    $usable = $m - ($p * 2);
    $o = [$s];
    if ($sl > $usable) {
        $ft = [];
        $t = "";
        $ws = explode(" ", $s);
        foreach ($ws as $i => $w) {
            $tw = "";
            if ($t != "")
                $tw .= " ";
            $tw .= $w;
            if (strlen($t . $tw) <= $usable) {
                $t .= $tw;
            } else {
                array_push($ft, $t);
                $t = trim($tw);
            }
            if ($i === count($ws) - 1)
                array_push($ft, $t);
        }
        $o = $ft;
    }
    foreach ($o as $l) {
        $lp = "";
        for ($i = 0; $i < $p; $i++)
            $lp .= $pc;

        $ls = "";
        $lsr = floor($usable / 2) - floor(strlen($l) / 2);
        for ($i = 0; $i < $lsr; $i++)
            $ls .= $sc;

        $ts = "";
        $tsr = $m - strlen($lp) - strlen($ls) - strlen($l) - $p;
        for ($i = 0; $i < $tsr; $i++)
            $ts .= $sc;

        $tp = "";
        for ($i = 0; $i < $p; $i++)
            $tp .= $pc;

        outln($lp . $ls . $l . $ts . $tp);
    }
}

function outcm($s = array(), $m = 45, $p = 4, $pc = " ", $sc = " ") {
    foreach ($s as $l)
        outc($l, $m, $p, $pc, $sc);
}

outr(45, "=");
ln();
outc("Welcome to the GitHub issue request auto-writer!");
ln();
outcm(["This script will automatically build steps 1a and 1b of your issue request on the GitHub repository.", "", "To write to a file, use the \"-f\" argument, then specify a path."]);
ln();
outr(45, "=");
ln();

$constLocation = realpath(__DIR__ . "/../../const.php");
$envLocation = realpath(__DIR__ . "/../../env.php");

$checklist = [
    "const_valid" => false,
    "const_unchanged" => false,
    "env_valid" => false,
    "env_changed" => false,
    "env_primed" => false
];

// Starting up...
start:
outln("Starting up...");

$step = "starting up";
$exceptions = array();

set_error_handler(function($errno, $errstr, $errfile = null, $errline = null) {
    global $exceptions, $step;
    array_push($exceptions,
        array(
            "step" => $step,
            "err" => array(
                "n" => $errno,
                "e" => $errstr,
                "f" => $errfile,
                "l" => $errline
            )
        )
    );
    return true;
});

function extractDefinitions($sourceFile) {
    $definitions = array();

    preg_match_all('/define\\("([^"]+)", ?([^)]+)\\)/', $sourceFile, $matches);

    foreach ($matches[1] as $i => $v) {
        $definitions[strval($v)] = strval($matches[2][$i]);
    }
    return $definitions;
}

$skipped = [];

// Skip configuration checks?
if (in_array("--no-config-checks", $argv)) {
    array_push($skipped, "config");
    goto system_info;
}


// Grabbing the default const.php and env.php files from GitHub
config_download:
outln("Grabbing the default configuration from GitHub...");
$step = "grabbing default configuration";

$downloadOK = false;
$downloadTries = 0;

$defaultConstURL = "https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/const.php";
$defaultEnvURL = "https://raw.githubusercontent.com/ChlodAlejandro/powerhouse/master/env.default.php";

$defaultConstFile = null;
$defaultEnvFile = null;

function downloadFile($url) {
    try {
        return file_get_contents($url);
    } catch (Exception $e) {
        return false;
    }
}

$timeouts = [10, 20, 30, 45, 60, 60, 60, 120, 120, 120];

do {
    do {
        outln("Downloading default \"const.php\"... (try " . ($downloadTries + 1) . " of 10)");
        $defaultConstFile = downloadFile($defaultConstURL);

        if ($defaultConstFile) break;
        else outln("An error occurred downloading the default \"const.php\" file.");
        outln("Trying again in " . $timeouts[$downloadTries] . " seconds...");

        sleep($timeouts[$downloadTries]);
        $downloadTries++;
    } while ($downloadTries < 10);
    $downloadTries = 0;

    do {
        outln("Downloading default \"env.php\"... (try " . ($downloadTries + 1) . " of 10)");
        $defaultEnvFile = downloadFile($defaultEnvURL);
        if ($defaultEnvFile) break;
        else outln("An error occurred downloading the default \"env.php\" file.");
        outln("Trying again in " . $timeouts[$downloadTries] . " seconds...");

        //sleep($timeouts[$downloadTries]);
        $downloadTries++;
    } while ($downloadTries < 10);
    $downloadTries = 0;

    if (!$defaultConstFile || !$defaultEnvFile) {
        ln();
        outc(" [ MANUAL INTERVENTION ] ", 45, 4, "=", "=");
        ln();
        outcm(["Powerhouse cannot download the default versions of the configuration from GitHub. This might mean that there is an error with your internet connection.", "", "If you would like to try again, enter [r]. If you would like to manually download the required files, enter [m]. To exit, enter [e]."]);
        ln();
        outr(45, "=");
        do {
            out("Next action [r/m/e]: ");
            $in = strtolower(trim(in()));

            if ($in != "r" && $in != "m" && $in != "e") {
                outln("Invalid input. Try again.");
                continue;
            }

            switch ($in) {
                case "r":
                    break 2;
                case "m": {
                    ln();
                    outln("Please download the following file, and place it in the following directory.");
                    ln();
                    outln("  FR: " . $defaultConstURL);
                    outln("  TO: " . realpath(__DIR__ . "/defaults/const.php"));
                    ln();
                    outln("When you're done, press the ENTER key to continue.");
                    in();
                    ln();
                    outln("Please download the following file, and place it in the following directory.");
                    ln();
                    outln("  FR: " . $defaultEnvFile);
                    outln("  TO: " . realpath(__DIR__ . "/defaults/env.default.php"));
                    ln();
                    outln("When you're done, press the ENTER key to continue.");
                    in();

                    $defaultConstFile = file_get_contents(__DIR__ . "/defaults/const.php");
                    $defaultEnvFile = file_get_contents(__DIR__ . "/defaults/env.default.php");
                    break;
                }
                case "e":
                    goto shutdown;
                    break 3;
            }
        } while ($in != "r" && $in != "m" && $in != "e");
    } else $downloadOK = true;
} while (!$downloadOK);


$defaultConst = extractDefinitions($defaultConstFile);
$defaultEnv = extractDefinitions($defaultEnvFile);

// Read local  Powerhouse configuration
config_read:
outln("Reading local Powerhouse configuration...");
$step = "reading local Powerhouse configuration";

$constOK = true;
$envOK = true;

$actualConstFile = null;
$actualEnvFile = null;

outln("Expecting const.php at \"" . $constLocation . "\"...");
outln("Expecting env.php at \"" . $envLocation . "\"...");

if (!file_exists($constLocation)) {
    ln();
    outr(45, "=");
    ln();
    outc("const.php is missing.");
    ln();
    outcm(["It seems like const.php is unavailable. This may be the reason why your Powerhouse installation is inaccessible. Before making your request and continuing, please make sure that const.php exists and is readable.", "", "If you want to download a fresh copy of const.php, you may download it from the Powerhouse repository. If you wish to skip the configuration checks, run the script with \"--no-config-checks\"."]);
    ln();
    outr(45, "=");
    ln();
    exit();
}

if (!file_exists($constLocation)) {
    ln();
    outr(45, "=");
    ln();
    outc("env.php is missing.");
    ln();
    outcm(["It seems like env.php is unavailable. This may be the reason why your Powerhouse installation is inaccessible. Before making your request and continuing, please make sure that env.php exists and is readable.", "", "If you want to download a fresh copy of env.php, please re-setup your Powerhouse installation by vising the setup page. If you wish to skip the configuration checks, run the script with \"--no-config-checks\"."]);
    ln();
    outr(45, "=");
    ln();
    exit();
}

$constSyntaxCheck = trim(shell_exec("php -l \"" . preg_replace("/[\\\\\"\s]/", "\\$1", $constLocation) . "\""));
if (substr($constSyntaxCheck, 0, 25) != "No syntax errors detected") {
    $checklist["const_valid"] = new Exception("Syntax check for \"const.php\" failed.", 0,
        new Exception($constSyntaxCheck));
} else $checklist["const_valid"] = true;

$envSyntaxCheck = trim(shell_exec("php -l \"" . preg_replace("/[\\\\\"\s]/", "\\$1", $envLocation) . "\""));
if (substr($envSyntaxCheck, 0, 25) != "No syntax errors detected") {
    $checklist["env_valid"] = new Exception("Syntax check for \"env.php\" failed.", 0,
        new Exception($envSyntaxCheck));
} else $checklist["env_valid"] = true;

$actualConstFile = file_get_contents($constLocation);
$actualEnvFile = file_get_contents($envLocation);

$actualConst = extractDefinitions($actualConstFile);
$actualEnv = extractDefinitions($actualEnvFile);

$checklist["const_unchanged"] = sha1($defaultConstFile) == sha1($actualConstFile);
$checklist["env_changed"] = sha1($defaultEnvFile) != sha1($actualEnvFile);

if (isset($actualEnv["POWERHOUSE_CONFIGURED"]) || $actualEnv["POWERHOUSE_CONFIGURED"] == "true") {
    $checklist["env_primed"] = true;
}

// Version and data collection
system_info:
outln("Collecting system information...");
$step = "collecting system information";

ln();
outln("For the following sections, your attention is required.");
ln();

$sys_info = [];

$sys_info["Web Server"] = ask("Please enter the name and version of your web server (e.g. Apache 2.4, nginx 1.17.10): ");
$sys_info["PHP Info"] = PHP_EOL . "<details>" . PHP_EOL . "<summary>PHP Info</summary>" . PHP_EOL . PHP_EOL . "```" . PHP_EOL;
$sys_info["PHP Info"] .= shell_exec("php -r \"phpinfo(INFO_GENERAL);\"");
$sys_info["PHP Info"] .= PHP_EOL . "```" . PHP_EOL . PHP_EOL . "**Extensions**: ";
$sys_info["PHP Info"] .= "`" . join("`, `", get_loaded_extensions()) . "`";
$sys_info["PHP Info"] .= PHP_EOL . "</details>";

// Version and data collection
ph_info:
outln("Collecting Powerhouse information...");
$step = "collecting Powerhouse information";

$phinfo = [];

$ph_info["Version"] = in_array("config", $skipped) ? ask("Please enter the Powerhouse version (can be found in const.php): ") : isset($actualConst["POWERHOUSE_VERSION"]) ?
    $actualConst["POWERHOUSE_VERSION"] :
    ask("Please enter the Powerhouse version (can be found in const.php): ");
$ph_info["const.php tampered"] = in_array("config", $skipped) ? ask("Please enter \"Yes\" if const.php was modified. Otherwise, please enter \"No\":") : ($checklist["const_unchanged"] ? "No" : "Yes");
$ph_info["env.php exists"] = file_exists($envLocation) ? "Yes" : "No";


// Build
build:

ln();
ln();
out("Please copy the text in between the lines and paste it");
out("into the designated area inside of your issue request.");
ln();
outr(50, "=");
final_out("*Auto-generated by Powerhouse on " . date("Y-m-d H:i:s") . ".*");
final_out();
if (count($exceptions) > 0) {
    final_out("**[!] Exceptions encountered during automatic generation.**");
    final_out();
    final_out("<details>");
    final_out("<summary>Exceptions</summary>" . PHP_EOL);
    final_out("```");
    var_dump($exceptions);
    final_out("```");
    final_out("</details>");
    final_out();
}
if (count(array_filter($checklist, function($v) { return $v == false; })) > 0) {
    final_out("**[!] Checklist issues encountered during automatic generation.**");
    final_out();
    final_out("<details>");
    final_out("<summary>Checklist</summary>" . PHP_EOL);
    foreach ($checklist as $i => $v) {
        if ($v) {
            final_out("* **" . $i . ":** OK");
        } else {
            final_out("* **" . $i . ":** Not OK.");
            final_out("```");
            final_out(json_encode($v));
            final_out("```");
        }
    }
    final_out("</details>");
    final_out();
}
final_out("## 1a: System Info");
foreach ($sys_info as $i => $v)
    final_out("* **" . $i . ":** " . $v);
final_out();
final_out("## 1b: Powerhouse Info");
foreach ($ph_info as $i => $v)
    final_out("* **" . $i . ":** " . $v);
final_out();
final_out("### const.php");
if ($constOK) {
    final_out(PHP_EOL . "<details>" . PHP_EOL . "<summary>const.php</summary>" . PHP_EOL);
    foreach ($actualConst as $i => $v)
        final_out("* **" . $i . ":** `" . $v . "`");
    final_out(PHP_EOL . "</details>");
}

final_out();
final_out("### env.php");
if ($envOK) {
    final_out(PHP_EOL . "<details>" . PHP_EOL . "<summary>env.php</summary>" . PHP_EOL);
    foreach ($actualEnv as $i => $v)
        final_out("* **" . $i . ":** `" . $v . "`");
    final_out(PHP_EOL . "</details>");
}
final_out();
outr(50, "=");
ln();
ln();

// Cleaning up...
shutdown:

if (in_array("-f", $argv)) {
    outln("Writing to file...");
    if (!isset($argv[array_search("-f", $argv) + 1]))
        outln("Invalid output file path. Please specify a path.");

    $outFile = $argv[array_search("-f", $argv) + 1];

    outln("Writing to " . $outFile . "...");
    file_put_contents($outFile, $finalOut);
}

outln("Exiting...");
restore_error_handler();

