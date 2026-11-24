<?php
namespace App\Exceptions;

use Exception;

/** Indica que s'intenta retornar un material sense préstec actiu. */
class MaterialNoPrestatException extends Exception
{
}
