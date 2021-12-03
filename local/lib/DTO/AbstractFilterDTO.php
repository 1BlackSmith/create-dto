<?php

declare(strict_types=1);

namespace Pwd\DTO;

/**
 * Abstract class AbstractFilterDTO
 * @package Pwd\DTO
 */
abstract class AbstractFilterDTO
{
    /**
     * @var string|null
     */
    public $scope;

    final protected function parseSort(string $sortString): array
    {
        if (strpos($sortString, '-') === 0) {
            return [substr($sortString, 1) => SORT_DESC];
        }

        return [$sortString => SORT_ASC];
    }

    final public function getHtmlName(string $field): string
    {
        return $this->scope ? sprintf('%s[%s]', $this->scope, $field) : $field;
    }

    final public function getHtmlId(string $field, ?string $uniqueId = null): string
    {
        return implode('-', array_filter([$this->scope, $field, $uniqueId]));
    }
}