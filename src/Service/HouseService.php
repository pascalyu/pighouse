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

    public function __construct(EntityManagerInterface $entitymanager,ObjectManager $objectManager) {
        $this->houseRepository = $entitymanager->getRepository(House::class);
        $this->actionRepository = $entitymanager->getRepository(Action::class);
        $this->objectManager = $objectManager;
    }

    public function init($pig,$houseId) {
        $this->pig=$pig;
        $this->houseEntity = $this->houseRepository->find($houseId);
      
    }

    public function addAmount($amountToAdd) {
        $this->changeHouseAmount($this->houseEntity->getAmount() + $amountToAdd);
        $this->insertAction($amountToAdd, "ADD") ;
        $this->save();
       
    }

    public function subsctractAmount($amountToSubstract) {

        $this->changeHouseAmount($this->houseEntity->getAmount() - $amountToSubstract);
        $pig = $context->get('security.token_storage')->getToken()->getUser();
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
       
        $this->actionEntity=$action;
    }
     public  function getActionJsonFormatListPage($action) {
        $result= $action;
      
        $result->setPig(NULL);
        $result->setHouse(NULL);
      
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
          
        $serializer = new Serializer($normalizers, $encoders);
         
        $jsonContent = $serializer->serialize($result, 'json');
   
        $decoded=json_decode($jsonContent);
          
        $decoded->date= $result->getDate()->format('Y-m-d H:i:s');
        $decoded->lastUpdatedAt=$result->getLastUpdatedAt()->format('Y-m-d H:i:s');
        
        $t=json_encode($decoded);
       
        return $t;
    }
    public function setHouseEntityById($houseId) {
        $this->houseEntity = $this->houseRepository->find($houseId);
    }

    public function setHouseEntity($houseEntity) {
        $this->houseEntity = $houseEntity;
    }
    public function getHouseEntity() {
        return $this->houseEntity ;
    }
     public function getActionEntity() {
         $truc=$this->actionEntity;
         return $truc; 
    }
    public function setPigEntity($houseEntity) {
        $this->houseEntity = $houseEntity;
    }
    public function save(){
        $this->objectManager->persist( $this->houseEntity);
        $this->objectManager->persist( $this->actionEntity);
        $this->objectManager->flush();

        
        
    }

    public function testze() {
        var_dump("test service ok");
    }

}
