<?php


namespace App\core\support;


use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use JetBrains\PhpStorm\Pure;

trait Str
{
    /** @var array $snakeCache (this_is_snake_case) */
    protected static array $snakeCache = [];
    public static array $uncountable = [
        'audio',
        'bison',
        'cattle',
        'chassis',
        'compensation',
        'coreopsis',
        'data',
        'deer',
        'education',
        'emoji',
        'equipment',
        'evidence',
        'feedback',
        'firmware',
        'fish',
        'furniture',
        'gold',
        'hardware',
        'information',
        'jedi',
        'kin',
        'knowledge',
        'love',
        'metadata',
        'money',
        'moose',
        'news',
        'nutrition',
        'offspring',
        'plankton',
        'pokemon',
        'police',
        'rain',
        'recommended',
        'related',
        'rice',
        'series',
        'sheep',
        'software',
        'species',
        'swine',
        'traffic',
        'wheat',
    ];
    /** Convert String to snake case
     * @param $value
     * @param string $delimiter
     * @return string
     */
    public static function snake($value,$delimiter='_'):string
    {
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (! ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
        }
        return $value;
    }
    public static function lower($value): array|bool|string
    {
        return mb_strtolower($value, 'UTF-8');
    }
    public static function pluralStudly($value, $count = 2): string
    {
        $parts = preg_split('/(.)(?=[A-Z])/u', $value, -1, PREG_SPLIT_DELIM_CAPTURE);

        $lastWord = array_pop($parts);

        return implode('', $parts).InflectorFactory::create()->build()->pluralize($lastWord);
    }
//    public static function plural($value, $count = 2)
//    {
//        if ((int) abs($count) === 1 || static::uncountable($value) || preg_match('/^(.*)[A-Za-z0-9\x{0080}-\x{FFFF}]$/u', $value) == 0) {
//            return $value;
//        }
//
//        $plural = static::inflector()->pluralize($value);
//
//        return static::matchCase($plural, $value);
//    }
//    #[Pure] protected static function uncountable($value): bool
//    {
//        return in_array(strtolower($value), static::$uncountable);
//    }
//    protected static function matchCase($value, $comparison)
//    {
//        $functions = ['mb_strtolower', 'mb_strtoupper', 'ucfirst', 'ucwords'];
//
//        foreach ($functions as $function) {
//            if ($function($comparison) === $comparison) {
//                return $function($value);
//            }
//        }
//
//        return $value;
//    }
}