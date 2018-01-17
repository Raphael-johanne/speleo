<?php
/**
 * @package     racol
 * @subpackage  com_booking
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Controller for booking
 *
 * @since  1.5.19
 */
class BookingControllerBooking extends JControllerForm
{
    const HOWMUCH_TPL   = 'howmuch';
    const DATE_TPL      = 'date';
    const PERIOD_TPL    = 'period';
    const FORM_TPL      = 'form';
    const SUCCESS_TPL   = 'success';
    const MAIL_TPL      = 'mail';

    /**
     * @var null
     * @since version 
     */
    private $formule = null;

    /**
     * @since version
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->formule = $this->getModel('formule')->getFormule(
            (int) $this->input->getInt('formule_id')
        );
    }

    /**
     *
     *
     * @since version
     */
    public function howmuch() {
        $data = [];
        $view = $this->getBookingView();
        $data['html'] =  $view->loadTemplate(self::HOWMUCH_TPL);

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function savehowmuch() {
        $data = [
            'howmuch' => (int) $this->input->getInt('howmuch')
        ];

        $data['errors'] = $this->isValid($data);

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function date() {
        $data = [
            'howmuch' => (int) $this->input->getInt('howmuch')
        ];

        $data['errors'] = $this->isValid($data);

        if (empty($data['errors'])) {
            $view = $this->getBookingView();
            $data['available_date'] =  $this->getModel('booking')->getAvailableDates($this->formule->id, $data['howmuch']);
            $data['html'] =  $view->loadTemplate(self::DATE_TPL);
        }

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function savedate() {
        $data = [
            'howmuch'   => (int) $this->input->getInt('howmuch'),
            'date'      => $this->input->getString('date')
        ];

        $data['errors'] = $this->isValid($data);

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function period() {
        $howMuch    = (int) $this->input->getInt('howmuch');
        $date       = $this->input->getString('date');

        $data = [
            'howmuch' => $howMuch,
            'date' => $date
        ];

        $data['errors'] = $this->isValid($data);

        if (empty($data['errors'])) {
            $view = $this->getBookingView();
            $view->periods = $this->getModel('booking')->getAvailabePeriods(
                $this->formule->id,
                date("Y-m-d", strtotime($date)
                )
            );

            $data['html'] =  $view->loadTemplate(self::PERIOD_TPL);
        }

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function saveperiod() {
        $data = [
            'howmuch'   => (int) $this->input->getInt('howmuch'),
            'date'      => $this->input->getString('date'),
            'period'    => $this->input->getInt('period')
        ];

        $data['errors'] = $this->isValid($data);

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function form() {
        $data = [
            'howmuch'   => (int) $this->input->getInt('howmuch'),
            'date'      => $this->input->getString('date'),
            'period'    => (int) $this->input->getInt('period'),
        ];

        $data['errors'] = $this->isValid($data);

        if (empty($data['errors'])) {
            $view = $this->getBookingView();
            $data['html'] =  $view->loadTemplate(self::FORM_TPL);
        }

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function saveform() {
        $data = [
            'formule_id'    => (int) $this->formule->id,
            'howmuch'       => (int) $this->input->getInt('howmuch'),
            'date'          => $this->input->getString('date'),
            'period'        => (int) $this->input->getInt('period'),
            'form' => [
                'firstname' =>  $this->input->getString('firstname'),
                'lastname'  =>  $this->input->getString('lastname'),
                'email'     =>  $this->input->getString('email'),
                'phone'     =>  $this->input->getString('phone')
            ]
        ];

        $data['errors'] = $this->isValid($data);

        if (empty($data['errors'])) {
            $bookingModel = $this->getModel('booking');

            $data['price'] = $data['howmuch'] * $this->formule->price;
            $encryptionKey = BookingHelperEncrypt::encrypt(
                time() . $data['form']['firstname'] . $data['form']['lastname'] . $data['form']['email']
            );

            $bookingModel->saveSubscription(
                $data,
                $this->input->server->get('REMOTE_ADDR'),
                $encryptionKey
            );

            $view = $this->getBookingView();
            $view->comfirmLink = 'index.php?option=com_booking&task=comfirmation.check&key=' . $encryptionKey;
            $view->booking = $bookingModel->getByKey($encryptionKey);
            $view->isComfirmed = false;

            try {
                BookingHelperMailer::send(
                    'Your subscription comfirmation',
                    $data['form']['email'],
                    $view->loadTemplate(self::MAIL_TPL)
                );
            } catch (Exception $e) {
                $data['errors'] = [
                    'An error append during sending mail please contact administrator to comfirmed your subscription'
                ];
            }

            $view = $this->getBookingView(); // need to reinit all properties of view object for security reason
            $data['html'] =  $view->loadTemplate(self::SUCCESS_TPL);
        }

        return $this->sendResonse($data);
    }

    /**
     *
     *
     * @since version
     */
    public function success() {
        $data = [];
        $view = $this->getBookingView();
        $data['html'] =  $view->loadTemplate(self::SUCCESS_TPL);

        return $this->sendResonse($data);
    }

    /**
     *
     * @return mixed
     *
     * @since version
     */
    private function getBookingView() {
        $view = parent::getView('booking','raw');
        $view->formule = $this->formule;
        return $view;
    }

    /**
     * @param array $data
     *
     * @since version
     */
    private function sendResonse(array $data) {

        $app = JFactory::getApplication();
        $app->mimeType = 'application/json';

        // Send the JSON response.
        $app->setHeader('Content-Type', $app->mimeType . '; charset=' . $app->charSet);
        $app->sendHeaders();
        echo json_encode($data);

        // Close the application.
        $app->close();
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @since version
     */
    private function isValid(array $data) {
        $errors = [];

        if (isset($data['howmuch'])) {
            if ($data['howmuch'] < $this->formule->min_person_allowed
                || $data['howmuch'] > $this->formule->max_person_allowed ) {
                $errors[] = JText::_('COM_BOOKING_ERROR_HOW_MUCH');
            }
        }

        if (isset($data['date'])) {
            if (empty($data['date'])) {
                $errors[] = JText::_('COM_BOOKING_ERROR_WHEN');
            } else {
                $date = new DateTime($data['date']);

                $availableDates = $this->getModel('booking')->getAvailableDates($this->formule->id, $data['howmuch']);
                if (!in_array($date->format('Y-m-d'), $availableDates)) {
                    $errors[] = JText::_('COM_BOOKING_ERROR_WHEN');
                }
            }
        }

        if (isset($data['period'])) {
            $period =  $this->getModel('period')->getPeriod($data['period']);
            if (null === $period->id) {
                $errors[] = JText::_('COM_BOOKING_ERROR_WHEN_PERIOD');
            }
        }

        if (isset($data['form'])) {
            $subscriber = $data['form'];
            if (empty($subscriber['firstname'])) {
                $errors[] = JText::_('COM_BOOKING_ERROR_FIRSTNAME');
            }

            if (empty($subscriber['lastname'])) {
                $errors[] = JText::_('COM_BOOKING_ERROR_LASTNAME');
            }

            if (empty($subscriber['email'])
            || !filter_var($subscriber['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = JText::_('COM_BOOKING_ERROR_EMAIL');
            }

            if (empty($subscriber['phone'])) {
                $errors[] = JText::_('COM_BOOKING_ERROR_PHONE');
            }
        }

        return $errors;
    }
}
