<?php

function methodIsAllowed(string $action): bool {
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($action) {
        case 'update':
            return $method == 'PATCH';
        case 'create':
            return $method == 'PUT';
        case 'read':
            return $method == 'GET';
        case 'delete':
            return $method == 'DELETE';
        default:
            return false;
    }
}

function returnError(string $message, string $page, int $code): void {
    http_response_code($code);
    header('location:' . $page . '?error=' . $message);
    exit();
}

function validateMandatoryParams(array $data, array $mandatoryParams): bool {
    foreach ($mandatoryParams as $param) {
        if (!isset($data[$param])) {
            return false;
        }
    }
    return true;
}
