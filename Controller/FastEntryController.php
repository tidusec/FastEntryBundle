<?php

namespace KimaiPlugin\FastEntryBundle\Controller;

use App\Controller\AbstractController;
use App\Entity\Timesheet;
use App\Repository\ActivityRepository;
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
    private ActivityRepository $activityRepository;

    public function __construct(EntityManagerInterface $entityManager, TimesheetRepository $timesheetRepository, ActivityRepository $activityRepository)
    {
        $this->entityManager = $entityManager;
        $this->timesheetRepository = $timesheetRepository;
        $this->activityRepository = $activityRepository;
    }

    #[Route(path: '/', name: 'fast_entry', methods: ['GET', 'POST'])]
    public function indexAction(Request $request): Response
    {
        $form = $this->createForm(FastEntryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entriesData = $form->get('entries')->getData();
            $user = $this->getUser();
            $activity = $this->activityRepository->find(2); // Set activity with ID 2

            foreach ($entriesData as $entryData) {
                $timesheet = new Timesheet();
                $timesheet->setUser($user);

                // Parse date and duration
                $begin = $entryData['date'];
                list($hours, $minutes) = explode(':', $entryData['duration']);
                $durationInSeconds = ($hours * 3600) + ($minutes * 60);

                $timesheet->setBegin($begin);
                $timesheet->setDuration($durationInSeconds);
                $timesheet->setDescription($entryData['description']);
                $timesheet->setBillable($entryData['billable']);
                $timesheet->setProject($entryData['project']);
                $timesheet->setActivity($activity); // Set the activity

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