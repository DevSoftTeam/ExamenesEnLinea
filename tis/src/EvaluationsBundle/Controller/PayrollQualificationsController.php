<?php

namespace EvaluationsBundle\Controller;


class PayrollQualificationsController
{
    public function showPayrollQualificationsAction() {
        return $this->render('area/show.html.twig', array(
            'area' => $area,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function newPayrollQualificationsAction() {

    }

    public function editPayrollQualificationsAction() {

    }
}