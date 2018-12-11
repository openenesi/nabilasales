<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\{
    Response,
    Request
};
use Symfony\Component\Form\Extension\Core\Type\{
    TextType,
    SubmitType
};
use App\Form\{
    LoadingType
};
use App\Entity\{
    Product,
    Loading
};
Use Doctrine\ORM\EntityManagerInterface;

class LoadingController extends Controller {

    /**
     * @Route("/loading", name="productloading")
     */
    public function productLoading() {
        //$this->denyAccessUnlessGranted('ROLE_SALES_PERSONNEL');
        $arrdata = array("page" => "productloading");

        $em = $this->getDoctrine()->getRepository(\App\Entity\Loading::class);
        $loadings = $em->findBy(array(), array("loadingDate" => "DESC"), 10, 0);
        $arrdata['loadings'] = $loadings;
        return $this->render("loading/productloading.html.twig", $arrdata);
    }

    /**
     * @Route("/loading/list", name="listloading")
     */
    public function listLoading() {
        //$this->denyAccessUnlessGranted('ROLE_SALES_PERSONNEL');
        $arrdata = array("page" => "listloading");

        $em = $this->getDoctrine()->getRepository(\App\Entity\Loading::class);
        $loadings = $em->findBy(array(), array("loadingDate" => "DESC"));
        $arrdata['loadings'] = $loadings;
        return $this->render("loading/listloading.html.twig", $arrdata);
    }

    /**
     * @Route("/loading/add", name="addloading")
     */
    public function addLoading(Request $request, Swift_Mailer $mailer) {
        //$this->denyAccessUnlessGranted('ROLE_SALES_PERSONNEL');
        // replace this line with your own code!

        $arr_options = array("page" => "addloading");
        $loading = new Loading();
        $doct = $this->getDoctrine();
        $loading->setCreatedBy($this->getUser());
        $form = $this->createForm(LoadingType::class, $loading);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loading->setCreatedBy($this->getUser());
            $loading->setDateCreated(new \DateTime());
            $em = $doct->getManager();
            $em->persist($loading);
            $em->flush();
            $form = $this->createForm(LoadingType::class, new Loading());
            $arr_options['loadingid'] = $loading->getId();
        }
        $arr_options['form'] = $form->createView();
        return $this->render("loading/addloading.html.twig", $arr_options);
    }

    /**
     * @Route("/loading/delete/{loadingid}", name="deleteloading", requirements={"loadingid":"\d+"})
     */
    public function deleteLoading(EntityManagerInterface $emi, Request $request, $loadingid) {
        //$this->denyAccessUnlessGranted('ROLE_SALES_MANAGER');
        $loading = $emi->getRepository(Loading::class)->find($loadingid);
        if ($loading && null !== $loading) {
            $this->addFlash("loadingdeletion", "Cannot delete loading!");
        }
        $lid = $loading->getLid();
        if (count($loading->getLoadingRecords())) {
            $this->addFlash("loadingdeletion", "Cannot delete loading '$lid'!");
        } else {

            $repo = $emi->getRepository(Loading::class);
            $result = $repo->deleteLoading($loadingid);

            if ($result) {
                $this->addFlash("loadingdeletion", "Loading '$lid' was deleted successfull!");
            } else {
                $this->addFlash("loadingdeletion", "Cannot delete loading '$lid'!");
            }
        }

        return $this->redirectToRoute("listloading");
    }

    /**
     * @Route("/loading/edit/{loadingid}", name="editloading", requirements={"loadingid":"\d+"})
     */
    public function editLoading(EntityManagerInterface $emi, Request $request, $loadingid) {
        //$this->denyAccessUnlessGranted('ROLE_SALES_PERSONNEL');
        $loading = $emi->getRepository(Loading::class)->find($loadingid);
        if (!$loading && null === $loading) {
            throw new \InvalidArgumentException("Loading entry does not exist!");
        }

        $form = $this->createForm(LoadingType::class, $loading);

        $form->handleRequest($request);
        $arrdata = array("page" => "editloading");
        if ($form->isSubmitted() && $form->isValid()) {
            if (count($loading->getLoadingRecords(array("delivered", "delivered with dispute")))) {
                $form->addError(new \Symfony\Component\Form\FormError("One or more loading records have been delivered on this loading entry"));
            } else {
                /*
                 * COMPARE THE TOTAL LOADING RECORD QUANTITY WITH THE QUANTITY OF LOADING
                 * 
                 */
                $loadingrecords = $loading->getLoadingRecords();
                $totalquantity = 0;
                foreach ($loadingrecords as $lr) {
                    $totalquantity += $lr->getQuantity();
                }

                if ($totalquantity > $loading->getQuantity()) {
                    $form->addError(new \Symfony\Component\Form\FormError("The total quantity loaded from loading depot is less than the total quantity loaded into trucks."));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($loading);
                    $em->flush();
                    $this->addFlash("modificationsuccess", "Loading modification was successful!");
                    $arrdata['loadingid'] = $loading->getId();
                }
            }
        }

        $arrdata["form"] = $form->createView();

        return $this->render("loading/editloading.html.twig", $arrdata);
    }

    /**
     * @Route("/loading/view/{loadingid}", name="viewloading", requirements={"loadingid":"\d+"})
     */
    public function viewLoading(Request $request, $loadingid) {
        //$this->denyAccessUnlessGranted('ROLE_SALES_PERSONNEL');
        // replace this line with your own code!
        $arrdata = array("page" => "viewloading");

        $em = $this->getDoctrine();
        $rep = $em->getRepository(Loading::class);

        $loading = $rep->find($loadingid);

        if (!$loading) {
            $loading = $rep->findByLid($loadingid);
        }

        if ($loading) {
            if (is_array($loading)) {
                $loading = $loading[0];
            }
            $arrdata['loading'] = $loading;
        }
        $form = $this->createFormBuilder(new \App\Utility\LoadingFind())
                ->setAction($this->generateUrl('vloading'))
                ->add('lid', TextType::class, array("label" => "Loading ID:", "data" => ($loading) ? $loading->getLid() : "", "attr" => array("placeholder" => "Loading ID")))
                ->add('Load', SubmitType::class, array('label' => 'Load'))
                ->getForm();
        if (!$loading) {
            $form->addError(new \Symfony\Component\Form\FormError("Loading not found!"));
        }

        $arrdata['form'] = $form->createView();



        return $this->render("loading/viewloading.html.twig", $arrdata);
    }

    /**
     * @Route("/loading/view", name="vloading")
     */
    public function vLoading(Request $request) {
        //$this->denyAccessUnlessGranted('ROLE_SALES_PERSONNEL');
        // replace this line with your own code!
        $form = $this->createFormBuilder(new \App\Utility\LoadingFind())
                ->setAction($this->generateUrl('vloading'))
                ->add('lid', TextType::class, array("label" => "Loading ID:", "attr" => array("placeholder" => "Loading ID")))
                ->add('Load', SubmitType::class, array('label' => 'Load'))
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $loadingid = $form->get('lid')->getData();
            return $this->forward('App\Controller\LoadingController::viewLoading', array("loadingid" => $loadingid));
        }
        return $this->render("loading/viewloading.html.twig", array("form" => $form->createView(), "page" => "viewloading"));
    }

    /* Utilities */
}
