<?php

namespace App\Controller;

use App\Repository\HouseRepository;
use App\Repository\InvitationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController {

    /**
     * @Route("/update", name="update")
     */
    public function index() {
        return $this->render('update/index.html.twig', [
                    'controller_name' => 'UpdateController',
        ]);
    }

    /**
     * @Route("/updateGenerateUniqueIdForHouses", name="updateGenerateUniqueIdForHouses")
     */
    public function generateUniqueIdForHouses(ObjectManager $manager, HouseRepository $houseRepository) {
        $resultmessage = array();
        $housesNoUniqueId = $houseRepository->findBy(
                ['houseUniqueId' => null]
        );

        $usedUniquesId = \App\Service\UtilService::makeSQLArrayToOneArray($houseRepository->findByUniqueIdNotNull());


        foreach ($housesNoUniqueId as $house) {
            do {
                $uniqueId = \App\Service\UtilService::generateRandomString(8);
            } while (in_array($uniqueId, $usedUniquesId));
            $house->setHouseUniqueId($uniqueId);
            
            $resultmessage[$house->getName()] = $uniqueId;
            $manager->persist($house);
        }
        $manager->flush();

        return new JsonResponse($resultmessage);
    }

}
