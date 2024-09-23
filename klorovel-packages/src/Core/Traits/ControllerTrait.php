<?php

namespace AyatKyo\Klorovel\Core\Traits;

trait ControllerTrait
{
    public function view($view = null, $data = [], $mergeData = [])
    {
        return view(($this->viewPath ?? '') . $view, $data, $mergeData);
    }

    public function debugThrowable($throwable)
    {
        if (config('app.debug')) {
            return $this->jsonError($throwable->getMessage(), [
                'error' => [
                    'type' => 'exception',
                    'data' => [
                        'code' => $throwable->getCode(),
                        'file' => $throwable->getFile(),
                        'line' => $throwable->getLine(),
                        'trace' => $throwable->getTrace(),
                    ]
                ]
            ])->send() && exit;
        }
        return false;
    }

    public function responseFailsValidation($validasi)
    {
        if ($validasi->fails()) {
            return $this->jsonError('Masukan anda tidak valid', [
                'error' => [
                    'type' => 'input_validation',
                    'data' => [
                        'errors' => $validasi->errors()->getMessages(),
                    ]
                ]
            ])->send() && exit;
        }
        return false;
    }

    public function responseValidationErrors($errors)
    {
        foreach ($errors as $errorKey => $errorValue) {
            if (! is_array($errorValue)) {
                $errors[$errorKey] = [$errorValue];
            }
        }

        return $this->jsonError('Masukan anda tidak valid', [
            'error' => [
                'type' => 'input_validation',
                'data' => [
                    'errors' => $errors,
                ]
            ]
        ]);
    }

    public function responseInvalidToken($pesan = 'Token Invalid')
    {
        return $this->jsonError($pesan, [
            'error' => [
                'type' => 'invalid_token',
            ]
        ], 401)->send();
    }

    public function jsonResponse($success, $data = []) 
    {
        $jsonData = [
            'success' => $success,
            'message' => $data['message'] ?? '',
        ];
        $status = 200;

        foreach ([
            'data',
            'redir',
            'error'
        ] as $kata) {
            if (isset($data[$kata])) {
                $jsonData[$kata] = $data[$kata];
            }
        }

        if (isset($data['status_code'])) {
            $status = $data['status_code'];
        }

        return response($jsonData, $status);
    }

    public function jsonSuccess($message, $data = [])
    {
        $data['message'] = $message;

        return $this->jsonResponse(true, $data);
    }

    public function jsonError($message, $data = [], $status_code = 400)
    {
        $data['message'] = $message;

        if (is_array($message) && config('app.debug') === true) {
            $data['message'] = collect($message)->map(function ($item) {
                return is_a($item, \Throwable::class) ? $item->getMessage() : $item;
            })->implode(" :: ");
        }

        $data['status_code'] = $status_code;

        return $this->jsonResponse(false, $data);
    }
}