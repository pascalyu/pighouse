<?php

namespace App\MyBundle\Repository;

use Doctrine\ORM\Query\Filter\SQLFilter;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class DeletedFilter  {

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias) {
        if ($targetEntity->hasField("deletedAt")) {
            $date = date("Y-m-d H:i:s");
            return $targetTableAlias . ".deletedAt < '" . $date . "' OR " . $targetTableAlias . ".deletedAt IS NULL";
        }
        return "";
    }

}
