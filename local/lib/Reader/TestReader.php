<?php
declare(strict_types=1);

namespace Pwd\Reader;

use Bitrix\Main\ORM\Query\Filter\ConditionTree;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\SystemException;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Application;
use RuntimeException;
use spaceonfire\Collection\Collection;
use spaceonfire\Collection\CollectionInterface;
use spaceonfire\Collection\TypedCollection;
use Pwd\DTO\TestDTO;
use Pwd\DTO\TestFilterDTO;
use Pwd\Iblock\Test\TestTable;


/**
 * Class TestReader
 * @package Pwd\Reader
 */
final class TestReader
{
    /**
     * @var array|mixed
     */
    private $getters = [];

    /**
     * @var array|null
     */
    private $nominations;

    /**
     * TestReader constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        if (array_key_exists('getters', $params)) {
            $this->getters = $params['getters'];
        }
    }

    /**
     * @param int $id
     * @return TestDTO|null
     */
    public function readOne(int $id): ?TestDTO
    {
        try {
            $element = TestTable::getByPrimary($id, [
                'select' => $this->getSelect(),
            ])->fetch();
            if ($element) {
                return $this->createDto([$element]);
            }

            return null;
        } catch (SystemException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param TestFilterDTO $filter
     * @param PageNavigation $pageNavigation
     * @return CollectionInterface
     */
    public function readAll(TestFilterDTO $filter, PageNavigation $pageNavigation): CollectionInterface
    {
        try {
            $condition = $this->buildCondition($filter);
            $orderBy = $this->getOrder();

            $pageNavigation->setRecordCount(TestTable::getCount($condition));
            if ($pageNavigation->getRecordCount() === 0) {
                return $this->createCollection();
            }

            $ids = TestTable::getList([
                'select' => ['ID'],
                'filter' => $condition,
                'order' => $orderBy,
                'limit' => (int)$pageNavigation->getLimit(),
                'offset' => (int)$pageNavigation->getOffset(),
            ])->fetchAll();
            $ids = array_column($ids, 'ID');

            $items = [];
            if ($ids) {
                $rawItems = TestTable::getList([
                    'select' => $this->getSelect(),
                    'filter' => (new ConditionTree())->whereIn('ID', $ids),
                    'order' => $orderBy,
                ])->fetchAll();

                $items = (new Collection($rawItems))
                    ->groupBy('ID')
                    ->map(function (CollectionInterface $items) {
                        return $this->createDto($items->all());
                    });
            }

            return $this->createCollection($items);
        } catch (SystemException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param TestFilterDTO $filter
     * @return ConditionTree
     */
    private function buildCondition(TestFilterDTO $filter): ConditionTree
    {
        $condition = (new ConditionTree())->where('ACTIVE', 'Y');

        if (!empty($filter->id)) {
            if (is_array($filter->id)) {
                $condition->whereIn('ID', $filter->id);
            } else {
                $condition->where('ID', $filter->id);
            }
        }

        if (!empty($filter->code)) {
            if (is_array($filter->code)) {
                $condition->whereIn('CODE', $filter->code);
            } else {
                $condition->where('CODE', $filter->code);
            }
        }

        if ($filter->name !== null && $filter->name !== '') {
            $query = Query::filter()->logic('or');

            $query->whereLike('NAME', '%' . $filter->name . '%');

            $condition->where($query);
        }

        return $condition;
    }


    /**
     * @param array $items
     * @return CollectionInterface
     */
    private function createCollection($items = []): CollectionInterface
    {
        return new TypedCollection($items, TestDTO::class);
    }

    /**
     * @return array
     */
    private function getOrder(): array
    {
        return ['ID' => 'DESC'];
    }

    /**
     * @return array
     */
    private function getSelect(): array
    {
        return [
            'ID',
            'NAME',
            'PREVIEW_TEXT',
            'CODE',
            'PROPERTY' => 'PROPERTY_SIMPLE.TEST_PROPERTY',
        ];
    }

    /**
     * @param array $items
     * @return TestDTO
     */
    private function createDto(array $items): TestDTO
    {
        $items = array_values($items);

        $firstItem = $items[0];

        $dto = new TestDTO();

        $dto->id = (int)$firstItem['ID'];
        $dto->name = $firstItem['NAME'];
        $dto->text = $firstItem['PREVIEW_TEXT'];
        $dto->code = $firstItem['CODE'];
        $dto->property = $firstItem['PROPERTY'];

        return $dto;
    }
}
