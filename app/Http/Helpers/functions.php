<?php

function _saveImageFolder($image, $folderName, $imageName = null)
{
    $date = date('FY');
    $imageName = $imageName ?? uniqid() . '.' . $image->getClientOriginalExtension();
    $folderPath = 'uploads/' . $folderName . '/' . $date;

    $image->storeAs($folderPath, $imageName, 'public');

    return ($folderName == 'products/others' ? 'others/' : '') . $date . '/' . $imageName;
}

function _formatDateToDB($date)
{
    return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
}

function _formatDateToBR($date)
{
    return date('d/m/Y', strtotime($date));
}

function _formatRealToDolar($value)
{
    if (!$value) {
        return false;
    }

    return number_format(str_replace(['.', ','], ['', '.'], $value), 2, '.', '');
}

function _formatDolarToReal($value)
{
    return number_format($value, 2, ',', '.');
}

function _formatCellphone($number)
{
    if (!$number) {
        return false;
    }

    return sprintf('(%s) %s %s-%s',
        substr($number, 0, 3),
        substr($number, 3, 1),
        substr($number, 4, 4),
        substr($number, 8, 4)
    );
}

function _formatCep($value)
{
    return sprintf('%s-%s',
        substr($value, 0, 5),
        substr($value, 5, 8));
}

function _removeNonNumericCharacters($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}

function _getFirstWord($string)
{
    return strtok($string, ' ');
}

function _defaultErrorMessage()
{
    return 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.';
}

function _separationPrice()
{
    return 5.00;
}
