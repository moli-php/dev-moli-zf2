<?php

namespace CalendarScheduler\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use CalendarScheduler\Model\Calendar;

class CalendarSchedulerController extends AbstractActionController {

    public function indexAction() {
        $layout_template = $this->params()->fromRoute('layout_template', null);
        $this->layout()->setTemplate($layout_template);
        $form = $this->getServiceLocator()->get('calendarForm');
        $viewModel = new ViewModel(array('form' => $form));
        return $viewModel;
    }

    public function getCalendarAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        if ($request->isGet() && $request->isXmlHttpRequest()) {
            $calendarTable = $sm->get('Calendar\Model\CalendarTable');
            $response = $calendarTable->getCalendar()->toArray();
        } else {
            $this->getResponse()->setStatusCode(404);
            $viewModel = new ViewModel();
            $viewModel->setTemplate('error/404');
            return $viewModel;
        }

        return new JsonModel($response);
    }

    public function getByDateCalendarAction() {
        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        if ($request->isGet() && $request->isXmlHttpRequest()) {
            $calendarTable = $sm->get('Calendar\Model\CalendarTable');
            $response = $calendarTable->
                            getByDateCalendar($this->params()->fromQuery())->toArray();
        } else {
            $this->getResponse()->setStatusCode(404);
            $viewModel = new ViewModel();
            $viewModel->setTemplate('error/404');
            return $viewModel;
        }

        return new JsonModel($response);
    }

    public function updateCalendarAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        $id = $this->params()->fromRoute('id', null);
        $response = array('response' => 100, 'status' => 'continue', 'message' => 'no change');
        if ($request->isPut() && $request->isXmlHttpRequest() && $id) {
            parse_str(file_get_contents('php://input'), $data);
            $calendar = new Calendar();
            $calendar->exchangeArray($data);
            $data = $calendar->getArrayCopy();
            unset($data['id']);
            unset($data['date']);
            $calendarTable = $sm->get('Calendar\Model\CalendarTable');
            if ($calendarTable->updateCalendar($id, $data)) {
                $response = array('response' => 200, 'status' => 'ok', 'message' => 'success');
            }
        } else {
            $this->getResponse()->setStatusCode(404);
            $viewModel = new ViewModel();
            $viewModel->setTemplate('error/404');
        }
        return new JsonModel($response);
    }
    
    public function addCalendarAction() {

        $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        
        if ($request->isPost() && $request->isXmlHttpRequest()) {
            $data = $request->getPost();
            $calendar = new Calendar();
            $calendar->exchangeArray($data);
            $data = $calendar->getArrayCopy();
            $calendarTable = $sm->get('Calendar\Model\CalendarTable');
            if ($calendarTable->addCalendar($data)) {
                $response = array('response' => 200, 'status' => 'ok', 'message' => 'success');
            }else{
                $response = array('response' => 500, 'status' => 'Internal error', 'message' => 'Data not saved.');
            }
        } else {
            $this->getResponse()->setStatusCode(404);
            $viewModel = new ViewModel();
            $viewModel->setTemplate('error/404');
        }
        return new JsonModel($response);
    }
    
    public function deleteCalendarAction() {
        
         $sm = $this->getServiceLocator();
        $request = $this->getRequest();
        if ($request->isDelete() && $request->isXmlHttpRequest()) {
            parse_str(file_get_contents('php://input'), $data);
            $calendarTable = $sm->get('Calendar\Model\CalendarTable');
            if ($calendarTable->deleteCalendar($data['id'])) {
                $response = array('response' => 200, 'status' => 'ok', 'message' => 'success');
            }
        } else {
            $this->getResponse()->setStatusCode(404);
            $viewModel = new ViewModel();
            $viewModel->setTemplate('error/404');
        }
        return new JsonModel($response);
    }

}
