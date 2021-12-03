<?php

declare(strict_types=1);

namespace Pwd\DTO;

use Bitrix\Main\HttpRequest;

/**
 * Class TestFilterDTO
 * @package Pwd\DTO
 */
final class TestFilterDTO
{
    /**
     * @var int|int[]
     */
    public $id;

    /**
     * @var string|string[]
     */
    public $name;

    /**
     * @var string|string[]
     */
    public $code;

    /**
     * @param HttpRequest $request
     * @return static
     */
    public static function fromRequest(HttpRequest $request): self
    {
        $filter = new self();

        $data = $request->toArray();

        $name = trim($data['name'] ?? '') ?: '';
        if (!empty($name)) {
            $filter->name = $name;
        }

        $code = trim($data['code'] ?? '') ?: '';
        if (!empty($code)) {
            $filter->code = $code;
        }

        return $filter;
    }
}
