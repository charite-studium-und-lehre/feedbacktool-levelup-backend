<?php

namespace Common\Application\DomainEvent;

use Common\Application\AbstractEvent\AbstractEventTrait;
use Common\Application\Command\DomainCommand;
use ConvenientImmutability\Immutable;
use RuntimeException;

trait DomainEventTrait
{
    use AbstractEventTrait;
//    use Immutable; // Nicht kompatibel mit PHP 7.4

    /** @return self */
    public function fromCommand(DomainCommand $command) {

        $object = new static();

        if (!is_a($command, get_class($object))) {
            throw new RuntimeException("Command and Event do not match: "
                                        . get_class($object)
                                        . " - "
                                        . get_class($command));
        }

        $all_properties = get_object_vars($command);

        foreach ($all_properties as $propertyName => $propertyValue) {
            $object->$propertyName = $propertyValue;
        }

        return $object;
    }

}