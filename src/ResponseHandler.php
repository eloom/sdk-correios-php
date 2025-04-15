<?php

namespace Eloom\SdkCorreios;

use Eloom\SdkCorreios\Exceptions\CorreiosException;
use Eloom\SdkCorreios\Exceptions\InvalidJsonException;
use Eloom\SdkCorreios\Exceptions\UnauthorizedException;
use GuzzleHttp\Exception\ClientException;

class ResponseHandler {

	/**
	 * @param string $payload
	 *
	 * @return \ArrayObject
	 * @throws InvalidJsonException
	 */
	public static function success($payload) {
		return self::toJson($payload);
	}

	/**
	 * @param ClientException $originalException
	 *
	 * @return void
	 * @throws PagarMeException
	 */
	public static function failure(\Exception $originalException) {
		throw self::parseException($originalException);
	}

	/**
	 * @param ClientException $guzzleException
	 *
	 * @return CorreiosException|ClientException
	 */
	private static function parseException(ClientException $guzzleException) {
		$response = $guzzleException->getResponse();

		die(print_r($response, true));

		if (is_null($response)) {
			return $guzzleException;
		}

		if ($response->getStatusCode() == 401) {
			return new UnauthorizedException('401 Unauthorized', date("d/m/Y"), '/v1/autentica/cartaopostagem');
		}

		if ($response->getStatusCode() == 400) {
			$error = null;

			if (is_array($jsonError)) {
				$error = $jsonError[0];
			} else {
				$error = $jsonError;
			}
			if (null != $error) {
				if ($error->txErro) {
					return new CorreiosException($error->txErro, date("d/m/Y"), '');
				}
			}
		}

		$body = $response->getBody()->getContents();

		$jsonError = null;

		try {
			$jsonError = self::toJson($body);
		} catch (InvalidJsonException $invalidJson) {
			return $guzzleException;
		}

		return new CorreiosException($jsonError->msgs, $jsonError->date, $jsonError->path);
	}

	/**
	 * @param string $json
	 * @return \ArrayObject
	 */
	private static function toJson($json) {
		$result = json_decode($json);

		if (json_last_error() != \JSON_ERROR_NONE) {
			throw new InvalidJsonException(json_last_error_msg());
		}

		return $result;
	}
}
