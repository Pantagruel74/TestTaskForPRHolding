<?php

namespace backend\app\apples;

use backend\source\apples\ApplesService;

/**
 * Класс содержащий основные конфигурации, которыми может быть проинициализирован ApplesService
 */
class ApplesServiceConfigurator
{
    public static function getDefaultInitializedByAr(): ApplesService
    {
        return ApplesService::createAndValidateStrictly([
            ApplesService::_unixTime => time(),
            ApplesService::_applesRepository => ApplesArRepository::createAndValidateStrictly(),
        ]);
    }
}