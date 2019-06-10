<?php

/**
 * This file contains core utilities.
 *
 * PHP VERSION 5.3.6
 *
 * @category  Core Utilites
 * @package   CoreUtilites
 * @author    Daniel Mbugua <daniel.mbugua@cellulant.com>
 * @author    Titus Luyo <titus.luyo@ecellulant.com>
 * @author    Dennis Wambua <dennis.wambua@cellulant.com>
 * @author    Brian Ngure <brian.ngure@cellulant.com>
 * @copyright 2013 Cellulant Ltd
 * @license   Proprietory License
 * @link      http://www.cellulant.com
 */
class CoreUtils {

	/**
	 * Receives the post from API and decodes the JSON string.
	 *
	 * @return array returns the decoded JSON string or an error message and
	 *               appropriate status code if there is an error
	 *
	 * @author Daniel Mbugua <daniel.mbugua@cellulant.com>
	 */
	public static function receivePost() {
		$post = file_get_contents("php://input");

		if ($post == null) {
			// No post
			$status['statusCode'] = Config::GENERAL_ERROR_CODE;
			$status['statusDescription']
			= "Payload not posted successfully to "
				. " the post script.";

			return $status;
		} else {

			return $post;
		}
	}

	/**
	 * Sends the request to Beep.
	 *
	 * @param string $url $url the Beep Hub API url
	 * @param string $fields_string $postFields the post data string
	 * @param array $fields
	 *
	 * @return mixed the retrieved status and/or response
	 */
	public static function httpPostSend($url, $fields, $fields_string) {
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_MUTE,1);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		$result = curl_exec($ch);

		$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($httpStatus == 200) {
			$response = $result;
		} else {
			$response = false;
		}
		//close connection
		curl_close($ch);
		return $response;
	}

	/**
	 * Sends the request to Beep.
	 *
	 * @param string $url $url the Beep Hub API url
	 * @param string $fields_string $postFields the post data string
	 * @param array $fields
	 *
	 * @return mixed the retrieved status and/or response
	 */
	public static function httpSslGetSend($send, $certFile, $certPassword) {

		$ch = curl_init($send);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSLCERT, $certFile);
		//curl_setopt($ch,CURLOPT_SSLCERTPASSWD,$certPassword) ;
		$result = curl_exec($ch);

		$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$response['result'] = $result;
		$response['httpStatusCode'] = $httpStatus;

		curl_close($ch);

		return $response;
	}

	/**
	 * Sends the request to Beep.
	 *
	 * @param string $url $url the Beep Hub API url
	 * @param string $fields_string $postFields the post data string
	 * @param array $fields
	 *
	 * @return mixed the retrieved status and/or response
	 */
	public static function httpGetSend($send) {

		$ch = curl_init($send);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$result = curl_exec($ch);

		$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$response['result'] = $result;
		$response['httpStatusCode'] = $httpStatus;

		curl_close($ch);

		return $response;
	}

	public static function xmlRpcPost($logging, $url, $function, $payload) {
		$client = new IXR_Client($url);
		$client->debug = false;

		try {
			if (!$client->query($function, $payload)) {
				$logging->error(
					Config::ERROR,
					-1,
					"Query failed: " . $client->getErrorMessage()
				);
				return -1;
			} else {
				$response = $client->getResponse();
				if ($response == null || $response == false || !$response) {
					return false;
				} else {
					return $response;
				}
			}
		} catch (Exception $e) {
			$logging->error(
				Config::ERROR,
				-1,
				"Exception occured: " . $e->getMessage()
			);
			return -2;
		}
	}

	public static function xmlRpcSSLPost($logging, $url, $function, $payload, $certificate) {

		$client = new IXR_ClientSSL($url);
		//Tell the client where the client certificates and keys are
		//$client->setCertificate('myPublicCert.pem', 'myPrivateKey.pem', 'my_secret_password');
		//Tell the client where the CA certificate is (to validate the server's certificate)
		$client->setCACertificate($certificate);
		$client->debug = false;

		try {
			if (!$client->query($function, $payload)) {
				$logging->error(
					Config::ERROR,
					-1,
					"Query failed: " . $client->getErrorMessage()
				);
				return -1;
			} else {

				$response = $client->getResponse();
				if ($response == null || $response == false || !$response) {
					return false;
				} else {
					return $response;
				}
			}
		} catch (Exception $e) {
			$logging->error(
				Config::ERROR,
				-1,
				"Exception occured: " . $e->getMessage()
			);
			return -2;
		}
	}

	/**
	 * POST the request to Beep Core using JSON.
	 *
	 * @param string $url         the Beep Hub API url
	 * @param string $jsonString  the post data string
	 *
	 * @return mixed The response data on success or FALSE on failure
	 *
	 * @author Titus <titus.luyo@cellulant.com>
	 */
	public static function httpJsonPost($logging, $url, $jsonString) {

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt(
			$curl,
			CURLOPT_HTTPHEADER,
			array("Content-type: application/json")
		);
		curl_setopt($curl, CURLOPT_USERAGENT, "eSale_Client/v1.2.0");
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonString);

		$jsonResponse = curl_exec($curl);

		$logging->debug(
			Config::DEBUG,
			-1,
			"Response from invocation function is: "
			. $logging->printArray($jsonResponse)
		);

		try {
			if (!$jsonResponse) {
				$logging->error(
					Config::ERROR,
					-1,
					"Post failed: " . $logging->printArray(curl_getinfo($curl))
				);
				curl_close($curl);
				return false;
			} else {
				if ($jsonResponse == null || $jsonResponse == false || !$jsonResponse) {
					curl_close($curl);
					return -1;
				} else {
					$postResponseArray = json_decode($jsonResponse, true);
					if ($postResponseArray) {
						$response = $postResponseArray;
					} else {
						$response = false;
					}
					curl_close($curl);
					return $response;
				}
			}
		} catch (Exception $e) {
			$logging->error(
				Config::ERROR,
				-1,
				"Exception occured: " . $e->getMessage()
			);
			curl_close($curl);
			return false;
		}
		curl_close($curl);
		return $jsonResponse;
	}
	/**
	 * Replaces the ? with the right parameter for logging purposes.
	 *
	 * @param string $query the parameterised SQL query
	 * @param array $params the SQL query parameters
	 *
	 * @return string the complete query for logging purposes
	 */
	public static function formatQueryForLogging($query, $params) {
		try {
			/*
				             * Divide the string using the ? delimeter so we can replace
				             * correctly.
			*/
			$buffer = explode('?', $query);

			$c = count($params);
			for ($index = 1; $index < $c; $index++) {
				/*
					                 * Starts from index 1 to ignore the first param. Append back
					                 * the ? after it was removed by the explode method.
				*/
				$sub = $buffer[$index - 1] . '?';

// In each sub string replace the ?
				$buffer[$index - 1] = str_replace('?', $params[$index], $sub);
			}

// Recontruct the string
			return implode("", $buffer);
		} catch (Exception $ex) {
// If any thing goes wrong return the original string
			return $query;
		}
	}

}