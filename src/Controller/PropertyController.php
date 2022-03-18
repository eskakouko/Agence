<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    #[Route('/properties', name: 'app_property')]
    public function index(): Response
    {

        $property = new Property();
        $property->setTitle('Mon Bien 1')
                 ->setDescription('Description de mon bien 1')
                 ->setSurface(600)
                 ->setRooms(9)
                 ->setBedrooms(6)
                 ->setFloor(2)
                 ->setCountry('France')
                 ->setCity('Nice')
                 ->setAddress('rue de paris')
                 ->setPostalCode('06200')
                 ->setParking(4)
                 ->setStatus(1)
                 ->setType(2)
                 ->setPrice(212.000);
        $em = $this->getDoctrine()->getManager();
        $em->persist($property);

        $property1 = new Property();
        $property1->setTitle('Mon Bien 2')
                 ->setDescription('Description de mon bien 2')
                 ->setSurface(300)
                 ->setRooms(4)
                 ->setBedrooms(3)
                 ->setFloor(2)
                 ->setCountry('France')
                 ->setCity('paris')
                 ->setAddress('118 Boulevard Saint-Germain')
                 ->setPostalCode('75006')
                 ->setParking(4)
                 ->setStatus(0)
                 ->setType(1)
                 ->setPrice(80000);
        $em = $this->getDoctrine()->getManager();
        $em->persist($property1);

        $property2 = new Property();
        $property2->setTitle('Mon Bien 3')
                 ->setDescription('Description de mon bien 1')
                 ->setSurface(600)
                 ->setRooms(9)
                 ->setBedrooms(6)
                 ->setFloor(2)
                 ->setCountry('Gabon')
                 ->setCity('Libreville')
                 ->setAddress('Bord de Mer Immeuble BICP')
                 ->setPostalCode('943')
                 ->setParking(4)
                 ->setStatus(1)
                 ->setType(0)
                 ->setPrice(200000000);
        $em = $this->getDoctrine()->getManager();
        $em->persist($property2);
        $em->flush();
        $property = $this->repository->findAllVisible();
        dump($property);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id<[0-9]+>}", name="app_property_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug): Response
    {
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('app_property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
            ], 301);
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'corrent_menu' => 'properties',
        ]);
    }
}
