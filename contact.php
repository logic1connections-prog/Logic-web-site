<?php
/**
 * Logic Connections — contactformulier
 * Ontvangt het formulier van index.html en stuurt het door naar Birger.
 * Antwoordt in JSON, zodat de pagina niet herlaadt.
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

const ONTVANGER   = 'birger@logic-connections.be';
const AFZENDER    = 'website@logic-connections.be';  // moet op het eigen domein staan
const MIN_SECONDEN = 3;                               // sneller ingevuld = bot

function stop($code, $bericht) {
    http_response_code($code);
    echo json_encode(['ok' => false, 'bericht' => $bericht], JSON_UNESCAPED_UNICODE);
    exit;
}

function kort($tekst, $max) {
    return function_exists('mb_substr') ? mb_substr($tekst, 0, $max) : substr($tekst, 0, $max);
}

function schoon($waarde, $max) {
    // \r en \n eruit: voorkomt dat iemand extra mailheaders injecteert
    $waarde = str_replace(["\r", "\n", "\0"], ' ', $waarde);
    return kort(trim($waarde), $max);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    stop(405, 'Alleen POST.');
}

// ── Spamfilters ──────────────────────────────────────────────
// Honeypot: een veld dat onzichtbaar is voor mensen. Ingevuld = bot.
if (trim((string)($_POST['website'] ?? '')) !== '') {
    // Doe alsof het gelukt is; een bot hoeft niet te weten dat hij herkend is.
    echo json_encode(['ok' => true, 'bericht' => 'Bericht verzonden.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$geopend = (int)($_POST['ts'] ?? 0);
if ($geopend > 0 && (time() - $geopend) < MIN_SECONDEN) {
    stop(422, 'Even rustig — probeer het opnieuw.');
}

// ── Velden ───────────────────────────────────────────────────
$naam    = schoon((string)($_POST['naam']    ?? ''), 120);
$email   = schoon((string)($_POST['email']   ?? ''), 180);
$school  = schoon((string)($_POST['school']  ?? ''), 160);
$bericht = trim((string)($_POST['bericht']   ?? ''));
$bericht = kort(str_replace("\0", '', $bericht), 5000);

if ($naam === '' || $email === '' || $bericht === '') {
    stop(422, 'Vul je naam, e-mail en bericht in.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    stop(422, 'Dat e-mailadres klopt niet.');
}

// ── Mail opbouwen ────────────────────────────────────────────
$onderwerp = 'Logic Connections — bericht van ' . $naam;

$inhoud = "Nieuw bericht via logic-connections.be\n"
        . str_repeat('-', 46) . "\n\n"
        . "Naam:    {$naam}\n"
        . "E-mail:  {$email}\n"
        . "School:  " . ($school !== '' ? $school : '(niet ingevuld)') . "\n\n"
        . "Bericht:\n{$bericht}\n\n"
        . str_repeat('-', 46) . "\n"
        . 'Verzonden: ' . date('d/m/Y H:i') . "\n"
        . 'IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'onbekend') . "\n";

$headers = [
    'From: Logic Connections <' . AFZENDER . '>',
    'Reply-To: ' . $naam . ' <' . $email . '>',   // antwoorden gaat rechtstreeks naar de afzender
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . phpversion(),
];

$verzonden = @mail(
    ONTVANGER,
    '=?UTF-8?B?' . base64_encode($onderwerp) . '?=',
    $inhoud,
    implode("\r\n", $headers),
    '-f' . AFZENDER
);

if (!$verzonden) {
    stop(500, 'De mail vertrok niet.');
}

echo json_encode(['ok' => true, 'bericht' => 'Bericht verzonden.'], JSON_UNESCAPED_UNICODE);
