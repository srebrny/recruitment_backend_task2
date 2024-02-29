<?php

namespace App\Controller;

use App\Form\TimeZoneType;
use DateTime;
use DateTimeZone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;

class TimeZoneController extends AbstractController
{
    /**
     * @Route("/time/zone", name="app_time_zone")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TimeZoneType::class, [], ['attr' => ['id' => 'timezone_form']]);
        $form->handleRequest($request);
        $inputTimeZone = "";
        $timeZoneOffset = "";
        $numberOfDaysInFebruary = "";
        $fullCurrentMonthName = "";
        $numDaysOfCurrentMonth = "";
        if ($form->isSubmitted()) {
            $timeZoneForm = $form->getData();
            $inputTimeZone = $timeZoneForm["timezone"];

            if (!in_array($timeZoneForm["timezone"], DateTimeZone::listIdentifiers(), true)) {
                $form
                    ->get('timezone')
                    ->addError(new FormError('Wrong timezone!'));
            }
            $dtTimeZone = new DateTimeZone($inputTimeZone);
            $dt = DateTime::createFromFormat("Y-m-d 23:59:59", $timeZoneForm["date"]."23:59:59", $dtTimeZone);
            if (!$dt || array_sum($dt::getLastErrors())) {
                $form
                    ->get('date')
                    ->addError(new FormError('Wrong date format use Y-m-d'));
            }
            $timeZoneOffset = $dt->getOffset() / 60;
            $fullCurrentMonthName = $dt->format('F');
            $dt->modify("last day of ". $fullCurrentMonthName);
            $numDaysOfCurrentMonth = $dt->format("d");

            $dt->modify("last day of February");
            $numberOfDaysInFebruary = $dt->format("d");
        }

        return $this->render('time_zone/index.html.twig', [
            'controller_name' => 'TimeZoneController',
            'form' => $form->createView(),
            "input_timezone" => $inputTimeZone,
            "timeZoneOffset" => $timeZoneOffset,
            "numberOfDaysInFebruary" => $numberOfDaysInFebruary,
            "fullCurrentMonthName" => $fullCurrentMonthName,
            "numDaysOfCurrentMonth" => $numDaysOfCurrentMonth,
        ]);
    }
}
