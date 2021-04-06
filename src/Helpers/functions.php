<?php

namespace Milebits\Helpers\Helpers;

use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

if (!function_exists('constExists')) {
    /**
     * @param object|string $class
     * @param string $constant
     * @return bool
     */
    #[Pure] function constExists(object|string $class, string $constant): bool
    {
        if (is_object($class)) $class = get_class($class);
        return defined(sprintf("%s::%s", $class, $constant));
    }
}

if (!function_exists('propVal')) {
    /**
     * @param object $object
     * @param string $name
     * @param null $default
     * @return mixed
     */
    #[Pure] function propVal(object $object, string $name, $default = null): mixed
    {
        if (!property_exists($object, $name)) return $default;
        return isset($object->{$name}) ? $object->{$name} : $default;
    }
}

if (!function_exists('staticPropVal')) {
    /**
     * @param string $class
     * @param string $name
     * @param null $default
     * @return mixed
     */
    #[Pure] function staticPropVal(string $class, string $name, $default = null): mixed
    {
        if (!property_exists($class, $name)) return $default;
        return isset($class::$$name) ? $class::$$name : $default;
    }
}

if (!function_exists('constVal')) {
    /**
     * @param $class
     * @param string $constant
     * @param null $default
     * @return mixed
     */
    #[Pure] function constVal($class, string $constant, $default = null): mixed
    {
        if (!constExists($class, $constant)) return $default;
        return constant(sprintf("%s::%s", $class, $constant)) ?? $default;
    }
}

if (!function_exists('hasTrait')) {
    /**
     * @param string|object $model
     * @param string $trait
     * @return bool
     */
    function hasTrait(object|string $model, string $trait): bool
    {
        if (is_object($model)) $model = get_class($model);
        return in_array($trait, class_uses_recursive($model), true);
    }
}

if (!function_exists('society')) {
    /**
     * @param string|null $repository
     * @param mixed|Model $user
     * @return mixed
     */
    function society(string $repository = null, Model $user = null): mixed
    {
        if (is_null($user)) $user = request()->user();
        if (!hasTrait($user->getMorphClass(), "Milebits\\Society\\Concerns\\Sociable")) return null;
        if (is_null($repository)) return $user->society();
        return $user->society()->buildRepository($repository);
    }
}

if (!function_exists('array_wrap')) {
    /**
     * @param $item
     * @return array
     */
    #[Pure] function array_wrap($item): array
    {
        return is_array($item) ? $item : [$item];
    }
}