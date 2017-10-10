<?php
/**
 * Class ClassFinder
 *
 * @author      Gerald Lippert <gerald.lippert@logsol.de>
 * @copyright   Copyright(c) 09/2017 Logsol GmbH (http://www.logsol.de)
 *
 */

namespace Estimation\Helper;

class ClassFinder
{
//This value should be the directory that contains composer.json
    const APP_ROOT = DIR;

    public static function getClassesInNamespace($namespace)
    {
        $files = scandir(self::getNamespaceDirectory($namespace), 0);

        $list = [];

        foreach ($files as $file)
        {
            if (strpos($file, '.php') !== false)
            {
                $list[str_replace('.php', '', $file)] = $namespace . '\\' . str_replace('.php', '', $file);
            }
        }

        return $list;
    }

    private static function getDefinedNamespaces()
    {
        $composerJsonPath = self::APP_ROOT . 'composer.json';
        $composerConfig = json_decode(file_get_contents($composerJsonPath));

        //Apparently PHP doesn't like hyphens, so we use variable variables instead.
        $psr4 = 'psr-4';
        return (array) $composerConfig->autoload->$psr4;
    }

    private static function getNamespaceDirectory($namespace)
    {
        $composerNamespaces = self::getDefinedNamespaces();

        $namespaceFragments = explode('\\', $namespace);
        $undefinedNamespaceFragments = [];

        while($namespaceFragments) {
            $possibleNamespace = implode('\\', $namespaceFragments) . '\\';

            if(array_key_exists($possibleNamespace, $composerNamespaces)){
                return realpath(self::APP_ROOT . $composerNamespaces[$possibleNamespace] . implode('/', $undefinedNamespaceFragments));
            }

            $undefinedNamespaceFragments[] = array_pop($namespaceFragments);
        }

        return false;
    }
}