<?php
namespace LittleElephantClient\Model;

/**
 * Document factory
 *
 * @author g.rombalski@unit27.net
 *
 */
class DocumentFactory
{
    /**
     * Static class, dont initialize factory
     * @codeCoverageIgnore
     */
    private function __construct() {
    }

    /**
     * Create document instance
     * TODO: check if library is up to date
     *
     * @param array $jsonData
     * @throws \LittleElephantClient\Exception\MappingException
     * @return \LittleElephantClient\Model\DocumentInterface
     */
    public static function create(array $data): ?\LittleElephantClient\Model\DocumentInterface {
        if (! isset($data['type'])) {
            throw new \LittleElephantClient\Exception\MappingException('Document type is missing');
        }

        if ('AUTOMATIC' === $data['type']) {
            // auto still not resolved
            return null;
        }

        // build class name
        $nameParts = \explode('_', \mb_strtolower($data['type']));
        $name = '';
        foreach ($nameParts as $part) {
            $name .= ucfirst($part);
        }

        $className = '\\LittleElephantClient\\Model\\' . $name;

        if (! \class_exists($className)) {
            throw new \LittleElephantClient\Exception\MappingException('Invalid document type');
        }

        // create model
        $model = new $className;

        // set data
        unset($data['type']);

        if (empty ($data)) {
            // no data = not parsed, yet type was set by owner
            return null;
        }

        foreach ($data as $key => $value) {
            $method = 'set' . \ucfirst($key);
            if (\method_exists($model, $method) && null !== $value) {
                $model->$method($value);
            }
        }

        return $model;
    }

    /**
     *
     * @param \LittleElephantClient\Model\DocumentInterface $model
     * @return array
     */
    public static function toArray(\LittleElephantClient\Model\DocumentInterface $model): array {
        return self::__toArray($model);
    }

    /**
     *
     * @param object $object
     * @return array
     */
    private static function __toArray($object): array {
        $reflection = new \ReflectionClass($object);
        $array = [];
        foreach ($reflection->getProperties() as $property) {
            $getter = 'get' . \ucfirst($property->getName());
            $value = $object->{$getter}();
            if ($value instanceof \DateTime || $value instanceof \DateTimeImmutable) {
                $value = $value->format('Y-m-d H:i:s');
            } elseif ('items' === $property->getName()) {
                $items = [];
                foreach ($object->{$getter}() as $item) {
                    $items[] = self::__toArray($item);
                }
                $value = $items;
            }
            $array[$property->getName()] = $value;
        }

        return $array;
    }
}