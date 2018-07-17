<?php
/*
Copyright (c) 2017 Jorge Matricali <jorgematricali@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

namespace Matricali\Http;

use ReflectionClass;

/**
 * Enumerador basico.
 *
 * @author Jorge Matricali <jmatricali@dlatv.net>
 */
abstract class Enum
{
    private static $constCache = null;

    /**
     * Obtiene una lista con las constantes definidas.
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    protected static function getConstants()
    {
        if (self::$constCache == null) {
            self::$constCache = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCache)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCache[$calledClass] = $reflect->getConstants();
        }
        return self::$constCache[$calledClass];
    }

    /**
     * Comprueba si el nombre dado corresponde a un elemento enumerado.
     *
     * @param string $name
     * @param bool $strict
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();
        if ($strict) {
            return array_key_exists($name, $constants);
        }
        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    /**
     * Comprueba si el valor dado corresponde a un elemento enumerado.
     *
     * @param string $value
     *
     * @throws \ReflectionException
     *
     * @return bool
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, true);
    }

    /**
     * Obtiene un valor en base a un nombre dado.
     *
     * @param string $name
     *
     * @throws \ReflectionException
     *
     * @return mixed
     */
    public static function getByName($name)
    {
        $name = strtoupper($name);
        $values = self::getConstants();

        return in_array($name, array_keys($values)) ? $values[$name] : null;
    }
}
