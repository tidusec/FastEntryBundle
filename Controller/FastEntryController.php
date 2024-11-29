<?php

namespace KimaiPlugin\FastEntryBundle\Controller;

use App\Controller\AbstractController;
use App\Entity\Timesheet;
use App\Repository\TimesheetRepository;
use Doctrine\ORM\EntityManagerInterface;
use KimaiPlugin\FastEntryBundle\Form\FastEntryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/fast-entry')]
final class FastEntryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private TimesheetRepository $timesheetRepository;

    public function __construct(EntityManagerInterface $entityManager, TimesheetRepository $timesheetRepository)
    {
        $this->entityManager = $entityManager;
        $this->timesheetRepository = $timesheetRepository;
    }

    #[Route(path: '/', name: 'fast_entry', methods: ['GET', 'POST'])]
    public function indexAction(Request $request): Response
    {
        $form = $this->createForm(FastEntryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Process the submitted data and create timesheet entries
            $entriesData = $form->get('entries')->getData();
            $user = $this->getUser();

            foreach ($entriesData as $entryData) {
                $timesheet = new Timesheet();
                $timesheet->setUser($user);
                $timesheet->setBegin(new \DateTime()); // Adjust as needed
                $timesheet->setDuration($entryData['duration'] * 60); // Duration in seconds
                $timesheet->setDescription($entryData['description']);
                $timesheet->setBillable($entryData['billable']);
                $timesheet->setActivity($entryData['activity']);
                $timesheet->setProject($entryData['project']);

                $this->entityManager->persist($timesheet);
            }

            $this->entityManager->flush();

            $this->addFlash('success', 'Entries have been added successfully.');

            return $this->redirectToRoute('fast_entry');
        }

        return $this->render('@FastEntry/fast-entry/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}