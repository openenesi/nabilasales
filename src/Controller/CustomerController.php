<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use App\Entity\Customer;
use App\Form\CustomerType;

class CustomerController extends AbstractController {

    /**
     * @Route("/client", name="customer")
     */
    public function index(Request $request) {
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $customers = $rep->findAll();

        return $this->render('customer/index.html.twig', [
                    'controller_name' => 'CustomerController',
                    'page' => 'listcustomer',
                    'customers' => $customers
        ]);
    }

    /**
     * @Route("/client/add", name="addcustomer")
     */
    public function addCustomer(Request $request) {
        $arrdata = array('page' => 'addcustomer');
        $customer = new Customer();
        $rep = $this->getDoctrine()->getRepository(Customer::class);
        $lastcustomerarr = $rep->findBy(array(), array('cid' => 'DESC'), 1);
        $lastcid = 0;
        if (count($lastcustomerarr)) {
            $lastcustomer = $lastcustomerarr[0];
            $lastcid = $lastcustomer->getCid();
        }
        $newcid = ++$lastcid;
        $customer->setCid($newcid);
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            return $this->redirectToRoute("customer");
        }
        $arrdata['form'] = $form->createView();
        return $this->render('customer/add.html.twig', $arrdata);
    }

}
