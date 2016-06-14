<?php

/**
* Klasse um den Service Bing-Translator verwenden zu koennen.
*
* @author Sebastian Brosch <sebastian.brosch@brosch-software.de>
* @copyright (c) 2012-2013, Sebastian Brosch & Brosch Software
* @package Service
* @version 1.0.0
*/
class BingTranslator {
/**
* Eigenschaft um die ID der Anwendung speichern zu koennen.
* @since 1.0.0
* @var string
*/
private $_client_id = '';

/**
* Eigenschaft um den Schluessel des Benutzers speichern zu koennen.
* @since 1.0.0
* @var string
*/
private $_client_secret = '';

/**
* Eigenschaft um die Berechtigungen speichern zu koennen.
* @since 1.0.0
* @var string
*/
private $_grant_type = 'client_credentials';

/**
* Eigenschaft um die URL des Service speichern zu koennen.
* @since 1.0.0
* @var string
*/
private $_scope_url = 'http://api.microsofttranslator.com';

/**
* Konstruktor der Klasse.
* @param string $clientID Die ID der Anwendung.
* @param string $clientSecret Der Sicherheitsschluessel des Benutzers.
* @since 1.0.0
*/
public function __construct($clientID, $clientSecret) {
$this->_client_id = $clientID;
$this->_client_secret = $clientSecret;
}

/**
* Methode um eine Antwort vom Bing-Service erhalten zu koennen.
* @param string $url Die Anfrage-URL um die Antwort ermitteln zu koennen.
* @return string Die Antwort des Service.
* @since 1.0.0
*/
public function getResponse($url) {

//CURL-Handler initialisieren.
$curlHandler = curl_init();

//Optionen fuer CURL setzen.
curl_setopt($curlHandler, CURLOPT_URL, $url);
curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$this->getToken(), 'Content-Type: text/xml'));
curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);

//CURL Session ausfuehren.
$response = curl_exec($curlHandler);

//CURL Session beenden.
curl_close($curlHandler);

//Zurueckgeben der Antwort.
return $response;
}

/**
* Methode um den Token zur Anmeldung erzeugen zu koennen.
* @param string $clientID Die ID der Anwendung.
* @param string $key Der Schluessel fuer den Benutzer-Account.
* @return string Der Anmeldeschluessel.
* @since 1.0.0
*/
public function getToken($clientID = '', $clientSecret = '') {

//ID des Benutzer-Accounts und Schluessel des Benutzers ermitteln.
$clientID = (trim($clientID) === '') ? $this->_client_id : $clientID;
$clientSecret = (trim($clientSecret) === '') ? $this->_client_secret : $clientSecret;

//CURL-Handler initialisieren.
$curlHandler = curl_init();

//Parameter-URL setzen.
$request = 'grant_type='.urlencode($this->_grant_type).'&scope='.urlencode($this->_scope_url).'&client_id='.urlencode($clientID).'&client_secret='.urlencode($clientSecret);

//CURL-Optionen setzen.
curl_setopt($curlHandler, CURLOPT_URL, 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/');
curl_setopt($curlHandler, CURLOPT_POST, true);
curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $request);
curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);

//CURL Session ausfuehren.
$response = curl_exec($curlHandler);

//CURL Session beenden.
curl_close($curlHandler);

//JSON String dekodieren.
$responseObject = json_decode($response);

//Zugangsschluessel zurueckgeben.
return $responseObject->access_token;
}

/**
* Methode um eine Uebersetzung ausfuehren zu koennen.
* @param string $fromLanguage Die Sprache von welcher uebersetzt werden soll.
* @param string $toLanguage Die Sprache in welche uebersetzt werden soll.
* @param string $text Der Text welcher uebersetzt werden soll.
* @return string Der uebersetzte Text.
* @since 1.0.0
*/
public function getTranslation($fromLanguage, $toLanguage, $text) {
$response = $this->getResponse($this->getURL($fromLanguage, $toLanguage, $text));

//Nur Wert ermitteln und zurueckgeben.
return strip_tags($response);
}

/**
* Methode um die URL fuer die Abfrage der Informationen erzeugen zu koennen.
* @param string $fromLanguage Die Sprache welche uebersetzt werden soll.
* @param string $toLanguage Die Sprache in welche uebersetzt werden soll.
* @param string $text Der Text welcher uebersetzt werden soll.
* @return string Die URL welche zur Uebersetzung verwendet werden kann.
* @since 1.0.0
*/
public function getURL($fromLanguage, $toLanguage, $text) {
return 'http://api.microsofttranslator.com/v2/Http.svc/Translate?text='.urlencode($text).'&to='.$toLanguage.'&from='.$fromLanguage;
}
}
?>
