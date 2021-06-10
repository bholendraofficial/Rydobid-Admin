<?php

namespace app\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RestController extends CController {

    protected $RequestData = array();
    protected $AllowedContentTypes = array(
        'application/x-www-form-urlencoded',
        'multipart/form-data'
    );
    protected $APICredentials = array(
        "username" => "api_usr01@rydobid.xyz",
        "password" => "rydobid@123"
    );

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            // $this->_checkAuthorization();
            $ContentType = explode(";", $_SERVER['CONTENT_TYPE']);
            if (in_array(array_shift($ContentType), $this->AllowedContentTypes)) {
                if (Yii::$app->request->post('data')) {
                    $this->RequestData = Yii::$app->request->post('data');
                    return true;
                } else {
                    $this->_sendResponse(400);
                }
            } else {
                $this->_sendResponse(400);
            }
        } else {
            throw new NotFoundHttpException('The Requested page could\'nt be found. ');
        }
    }

    protected function _getStatusCodeMessage($status) {
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented'
        );
        return (array_key_exists($status, $codes) ? $codes[$status] : '');
    }

    protected function _sendResponse($status = 200, $body = '', $invalidAuth = '') {
        $statusMessage = $this->_getStatusCodeMessage($status);
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $statusMessage;
        $responseBody = array(
            "meta" => array(
                "status" => $status,
                "message" => $statusMessage . ($invalidAuth != '' ? " - " . $invalidAuth : "")
            ),
            "response" => array()
        );
        header($status_header);
        $responseBody["response"] = ($body != '') ? $body : [];
        Yii::$app->response->data = $responseBody;
        Yii::$app->end();
    }

    protected function _checkAuthorization() {
        if (!array_key_exists('PHP_AUTH_USER', $_SERVER) || !array_key_exists('PHP_AUTH_PW', $_SERVER)) {
            $this->_sendResponse(401);
        }
        if ($_SERVER['PHP_AUTH_USER'] !== $this->APICredentials["username"]) {
            $this->_sendResponse(401, '', 'Error: User Name is invalid');
        } else if ($_SERVER['PHP_AUTH_PW'] !== $this->APICredentials["password"]) {
            $this->_sendResponse(401, '', 'Error: User Password is invalid');
        }
    }

    protected function _validateRequest(array $PostKeyArray = []) {
        if (is_array($this->RequestData) && count($this->RequestData) > 0) {
            $KeyDifferenceArray = array_diff($PostKeyArray, array_keys($this->RequestData));
            if (count($KeyDifferenceArray) > 0) {
                $this->_sendResponse(400, [
                    "task_status" => 0,
                    "task_message" => "Error: '" . implode(", ", $KeyDifferenceArray) . "' key(s) are missing", "task_data" => []
                ]);
                Yii::$app->end();
                return false;
            }
        } else {
            $this->_sendResponse(400);
        }
    }

    protected function _generateUploadedFileName($extension) {
        return uniqid("IMG_", true) . "." . $extension;
    }

    protected function parseValidationError(array $error = []) {
        return implode(", ", array_values(array_map(function ($v) {
                            return str_replace('"', "'", $v[0]);
                        }, $error)));
    }

}
