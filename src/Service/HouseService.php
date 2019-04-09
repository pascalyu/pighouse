<?php

namespace App\Service;

use App\Entity\Action;
use App\Entity\House;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class HouseService {

    private $objectManager;
    private $context;
    private $houseRepository;
    private $actionRepository;
    private $houseEntity;
    private $actionEntity;

    public function __construct(EntityManagerInterface $entitymanager, ObjectManager $objectManager) {
        $this->houseRepository = $entitymanager->getRepository(House::class);
        $this->actionRepository = $entitymanager->getRepository(Action::class);
        $this->objectManager = $objectManager;
    }

    public function init($pig, $houseId) {
        $this->pig = $pig;
        $this->houseEntity = $this->houseRepository->find($houseId);
    }

    public function addAmount($amountToAdd) {
        $this->changeHouseAmount($this->houseEntity->getAmount() + $amountToAdd);
        $this->insertAction($amountToAdd, "ADD");
        $this->save();
    }

    public function substractAmount($amountToSubstract) {
        $this->changeHouseAmount($this->houseEntity->getAmount() - $amountToSubstract);
        $this->insertAction($amountToSubstract, "SUBSTRACT");
        $this->save();
    }

    public function changeHouseAmount($amount) {
        $this->houseEntity->setAmount($amount);
    }

    public function insertAction($amount, $actionType) {
        $action = new Action();

        $todayDatetime = new DateTime();

        $action->setAmount($amount);
        $action->setActionType($actionType);
        $action->setCreatedAt($todayDatetime);
        $action->setDate($todayDatetime);
        $action->setLastUpdatedAt($todayDatetime);

        $action->setPig($this->pig);
        $action->setHouse($this->houseEntity);

        $this->actionEntity = $action;
    }

    public function getActionJsonFormat($action) {
        $result = $action;



        $encoders = [new JsonEncoder()];

        $normalizer = new ObjectNormalizer();

        $normalizer->setIgnoredAttributes(['house']);

// all callback parameters are optional (you can omit the ones you don't use)
        $normalizer->setCircularReferenceHandler(function ($object, string $format = null, array $context = []) {
            return $object->getId();
        });

        $callback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format('Y-m-d H:i:s') : '';
        };
        $callbackPig = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \App\Entity\Pig ? $innerObject->getPseudoName() : '';
        };
        $dateArrayCallback=['createdAt' => $callback,'date' => $callback,'lastUpdatedAt' => $callback,'pig'=> $callbackPig];
        
       
        
        if ($result->getDeletedAt() !== null) {
            $dateArrayCallback['deletedAt']=$callback;
        }
         $normalizer->setCallbacks($dateArrayCallback);

        $serializer = new Serializer([$normalizer], $encoders);

        $jsonContent = $serializer->serialize($result, 'json');

        $decoded = json_decode($jsonContent);





        return json_encode($decoded);
    }
    
    

    public function setHouseEntityById($houseId) {
        $this->houseEntity = $this->houseRepository->find($houseId);
    }

    public function setHouseEntity($houseEntity) {
        $this->houseEntity = $houseEntity;
    }

    public function getHouseEntity() {
        return $this->houseEntity;
    }

    public function getActionEntity() {
        $truc = $this->actionEntity;
        return $truc;
    }

    public function setPigEntity($houseEntity) {
        $this->houseEntity = $houseEntity;
    }

    public function save() {
        $this->objectManager->persist($this->houseEntity);
        $this->objectManager->persist($this->actionEntity);
        $this->objectManager->flush();
    }

    public function testze() {
        var_dump("test service ok");
    }

}
