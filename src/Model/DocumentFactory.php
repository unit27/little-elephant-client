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
            if (\method_exists($model, $method)) {
                $model->$method($value);
            }
        }

        return $model;
    }
}