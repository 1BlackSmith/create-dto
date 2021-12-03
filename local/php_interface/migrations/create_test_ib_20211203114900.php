<?php
declare(strict_types=1);

namespace Sprint\Migration;

final class create_test_ib_20211203114900 extends Version
{
    protected $description = 'Add new test Iblock';

    public function up()
    {
        $helper = $this->getHelperManager();

        $helper->Iblock()->saveIblockType([
            'ID' => 'test',
            'LANG' => [
                'ru' => [
                    'NAME' => 'Тест',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Элементы',
                ],
            ],
        ]);

        $test = $helper->Iblock()->saveIblock([
            'NAME' => 'Тестовый инфоблок',
            'CODE' => 'test',
            'LID' => ['s1'],
            'IBLOCK_TYPE_ID' => 'test',
        ]);

        $helper->Iblock()->saveIblockFields($test, [
            'CODE' => [
                'IS_REQUIRED' => 'Y',
                'DEFAULT_VALUE' => [
                    'TRANSLITERATION' => 'Y',
                    'UNIQUE' => 'Y',
                ],
            ],
        ]);

        $helper->Iblock()->saveProperty($test, [
            'NAME' => 'Тестовое свойство',
            'PROPERTY_TYPE' => 'S',
            'MULTIPLE' => 'N',
            'CODE' => 'TEST_PROPERTY',
            'IS_REQUIRED' => 'N',
            'SORT' => '500',
        ]);

        $helper->Iblock()->addElementIfNotExists(
            $test,
            [
                'NAME' => 'Тест1',
                'CODE' => 'test1',
                'ACTIVE' => 'Y',
                'PREVIEW_TEXT' => 'Test text',
            ],
            [
                'TEST_PROPERTY' => '123',
            ],
        );

        $helper->Iblock()->addElementIfNotExists(
            $test,
            [
                'NAME' => 'Тест2',
                'CODE' => 'test2',
                'ACTIVE' => 'Y',
                'PREVIEW_TEXT' => 'Цена',
            ],
            [
                'TEST_PROPERTY' => 'test prop',
            ],
        );

        $helper->Iblock()->addElementIfNotExists(
            $test,
            [
                'NAME' => 'Тест3',
                'CODE' => 'test3',
                'ACTIVE' => 'Y',
            ],
        );
    }

    public function down()
    {
    }
}
