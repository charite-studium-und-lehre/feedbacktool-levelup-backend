<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

if (!isset($_SERVER['GITHUB_SECRET'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__.'/../.env');
}

file_put_contents("/tmp/server", print_r($_SERVER, 1));


$parameters = (array) json_decode($_POST["payload"], TRUE);

$headers = getallheaders();
$githubHmacHashFromRequest = $headers["X-Hub-Signature"];
$algo = explode("=", $githubHmacHashFromRequest)[0];

if (!$githubHmacHashFromRequest) {
    die ("Kein Hash 'X-Hub-Signature' im Request-Header gegeben");
}

$httpBody = file_get_contents('php://input');

$githubSecret = $_SERVER['GITHUB_SECRET'] ?? NULL;
if (!$githubSecret) {
    die ("FEHLER: kein SECRET festgelegt...");
}

$githubDeployPrefix = $_SERVER['GITHUB_DEPLOY_PREFIX'] ?? NULL;
if (!$githubDeployPrefix) {
    die ("FEHLER: kein GITHUB_DEPLOY_PREFIX festgelegt...");
}

$githubDeployScript = $_SERVER['GITHUB_DEPLOY_SCRIPT'] ?? NULL;
if (!$githubDeployScript) {
    die ("FEHLER: kein GITHUB_DEPLOY_SCRIPT festgelegt...");
}

$slackDeployMessageUrl = $_SERVER['SLACK_DEPLOY_MESSAGE_URL'] ?? NULL;

$gitHubHmacHash = $algo . "=" . hash_hmac($algo, $httpBody, $githubSecret);

if ($githubHmacHashFromRequest != $gitHubHmacHash) {
    die ("Fehler bei Prüfung des Hashes");
}

$comittedBranch = explode("/", $parameters["ref"])[2];
$pathToScript = $githubDeployPrefix . DIRECTORY_SEPARATOR . $comittedBranch;
if (!is_dir($pathToScript)) {
    die ("FEHLER: Verzeichnis existiert nicht auf Server: $pathToScript");
}

if (!is_dir($pathToScript)) {
    die ("FEHLER: Verzeichnis existiert nicht auf Server: $pathToScript");
}

$scriptToRun = $pathToScript . DIRECTORY_SEPARATOR . $githubDeployScript;

if (!is_executable($scriptToRun)) {
    die ("FEHLER: Skript ist nicht vorhanden oder nicht ausführbar: $scriptToRun");
}

echo "STARTE DEPLOYMENT: $scriptToRun\n";

if ($slackDeployMessageUrl) {
    putenv("SLACK_URL=$slackDeployMessageUrl");
}

$systemProxy = $_SERVER["https_proxy"] ?? NULL;
if ($systemProxy) {
    putenv("https_proxy=$systemProxy");
    putenv("http_proxy=$systemProxy");
}

$commit = $parameters["commits"][0];
$commiter = $commit["committer"]["name"];
$commitMessage = $commit["message"];
$commitTime = $commit["timestamp"];
$pusher = $parameters["pusher"]["name"];
$deployMessage = "Deployment aus GitHub: Branch $comittedBranch, Commit von $commiter, "
    . " Zeit: $commitTime, Push ausgeführt von $pusher,  Commit-Nachricht: $commitMessage ";
$deployMessage = str_replace( '"', "", $deployMessage);
$deployMessage = str_replace( '\\', '\\\\', $deployMessage);

putenv("DEPLOY_MESSAGE=$deployMessage");
echo $deployMessage;

$output = [];
$exitCode = 0;
$result = exec("$scriptToRun", $output, $exitCode);
$result = implode("\n", $result) . "---" . implode("\n", $output);

if ($exitCode !== 0) {
    $fehlerText = "Fehler beim Deployment über GitHub: Befehl: $scriptToRun\n Code: $exitCode\n Ausgabe: $result";
    if ($slackDeployMessageUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $slackDeployMessageUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "payload=" . json_encode(["text" => $fehlerText]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($systemProxy) {
            $shortProxyUrl = parse_url($systemProxy, PHP_URL_HOST) . ":"
                . parse_url($systemProxy, PHP_URL_PORT);
            curl_setopt($ch, CURLOPT_PROXY, $shortProxyUrl);
            echo("\nSHORT:$shortProxyUrl\n");
        }
        echo("\nSLACK: $slackDeployMessageUrl\n");
        echo curl_exec($ch);
    }
}

echo "Ergebnis des Deployments:\nExit-Code $exitCode\n$result";
file_put_contents("/tmp/githubDeployHook.txt", "Ergebnis des Deployments:\nExit-Code $exitCode\n$result");