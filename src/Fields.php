<?php

namespace Precious;

use Iterator;

class Fields implements Iterator
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var array<Field>
     */
    private $fields;

    /**
     * @var array<Field> $fields
     * @throws NameClashFieldException
     * @returns self
     */
    public function __construct(array $fields) {
        $this->position = 0;
        $this->fields = $fields;
        self::ensureUniqueNames(
            array_map(function($field) { return $field->name(); }, $fields)
        );
    }

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->fields[$this->position];
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->fields[$this->position]);
    }

    /**
     * @throws NameClashFieldException
     */
    private static function ensureUniqueNames(array $declaredNames) : void
    {
        $uniqueNames = array_unique($declaredNames);
        if (count($declaredNames) !== count($uniqueNames)) {
            [$duplicateFieldName] = array_values(array_diff_assoc($declaredNames, $uniqueNames));
            throw new NameClashFieldException(
                "Cannot redeclare field `{$duplicateFieldName}`"
            );
        }
    }
}
