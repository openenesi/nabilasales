<?php

namespace App\Form;

use App\Entity\{
    Product,
    Loading,
    LoadingDepot,
    Truck
};
use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface,
    FormEvent,
    FormEvents
};
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{
    DateTimeType,
    MoneyType,
    IntegerType,
    SubmitType,
    TextareaType,
    TelType,
    TextType,
    HiddenType,
    ChoiceType
};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LoadingType extends AbstractType {

    use \App\Utility\Utils;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if ($options['stage'] == 'loading') {
            $builder
                    ->add('loadingDate', DateTimeType::class, array("label" => "Loading Date: ",
                        "date_format" => "yyyy-MM-dd",
                        "date_widget" => "single_text",
                        "format" => "yyyy-MM-dd HH:mm:ss",
                        "html5" => false,
                        "time_widget" => "single_text",
                        "widget" => "single_text",
                        "attr" => array("class" => "date")
                    ))
                    ->add('loadingDepot', EntityType::class, array("label" => "Depot: ",
                        "attr" => array("class" => "custom-select"),
                        'class' => LoadingDepot::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('t')
                                    ->orderBy('t.depotName', 'ASC');
                        },
                        'choice_label' => function ($depot) {
                            return $depot->getDepotName();
                        },
                        "placeholder" => "Select Depot"))
                    ->add('meterTicket', textType::class, array("label" => "Meter Ticket: ", "required" => true))
                    ->add('product', EntityType::class, array("label" => "Product: ",
                        "attr" => array("class" => "custom-select"),
                        'class' => Product::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('t')
                                    ->orderBy('t.productName', 'ASC');
                        },
                        'choice_label' => function ($product) {
                            return $product->getProductName();
                        },
                        'choice_attr' => function ($product) {
                            return ["data-price" => $product->getUnitPrice()];
                        },
                        "placeholder" => "Select Product"))
                    ->add('quantity', IntegerType::class, array("label" => "Quantity: ", "scale" => 0))
                    ->add('purchaseRate', MoneyType::class, array("label" => "Purchase Rate: ", "currency" => "NGN", "grouping" => true))
                    ->add('oh', TextType::class, array("label" => "O/H: ", "required" => true))
                    ->add('lh', TextType::class, array("label" => "L/H: ", "required" => true))
                    ->add('ullage', TextType::class, array("label" => "Ullage: ", "required" => true))
                    ->add('truckEntryChoice', ChoiceType::class, array("expanded" => true,
                        "multiple" => true,
                        "choices" => array("Select from list of managed trucks" => true),
                        "mapped" => false,
                        "required" => false,
                        "label" => false,
                        "data" => array(true)
                    ))
                    ->add('truckChoice', EntityType::class, array("mapped" => false, "label" => "Select Truck: ",
                        "attr" => array("class" => "custom-select"),
                        'class' => Truck::class,
                        'query_builder' => function (EntityRepository $er) use ($options) {
                            $qb = $er->createQueryBuilder('t');
                            $qb = $qb->orderBy('t.truckNumber', 'DESC');
                            return $qb;
                        },
                        'choice_label' => function ($truck) {
                            return $truck->getTruckNumber();
                        },
                        'choice_attr' => function ($truck) {
                            return ["data-truckNo" => $truck->getTruckNumber(), "data-driverName" => $truck->getDriverName(), "data-driverNo" => $truck->getDriverMobileNo()];
                        },
                        "placeholder" => "Select Truck"))
                    ->add('truckNumber1', TextType::class, array("label" => "Truck No.: ", "required" => false, "mapped" => false))
                    ->add('truckNumber', HiddenType::class, array("required" => true, "attr" => array("class" => "driverinfo")))
                    ->add('driverName', TextType::class, array("label" => "Driver's Name: ", "required" => false, "attr" => array("class" => "driverinfo")))
                    ->add('driverMobileNo', TelType::class, array("label" => "Driver's Mobile No.: ", "required" => false, "attr" => array("class" => "driverinfo")))
                    ->add('destination', TextareaType::class, array("label" => "Destination: ", "required" => true));
        } else {
            $builder->add('quantityReceived', IntegerType::class, array("label" => "Quantity Received: ", "required" => true))
                    ->add('ohReceived', TextType::class, array("label" => "O/H on Reception: ", "required" => true))
                    ->add('lhReceived', TextType::class, array("label" => "L/H on Reception: ", "required" => true))
                    ->add('ullageReceived', TextType::class, array("label" => "Ullage on Reception: ", "required" => true));
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            // ... adding the name field if needed
            $loading = $event->getData();
            $form = $event->getForm();

            if (!$loading || null === $loading->getId()) {
                $form->add('Add Loading Details', SubmitType::class, array("label" => "Add Loading Details"));
            } else {
                if ($options['stage'] == 'loading') {
                    $form->add('Update Loading Details', SubmitType::class, array("label" => "Update Loading Details"));
                } else if ($loading->getLoadingStatus() == "on-transit") {
                    $form->add('Add Product Received Details', SubmitType::class, array("label" => "Add Product Received Details"));
                } else {
                    $form->add('Update Product Received Details', SubmitType::class, array("label" => "Update Product Received Details"));
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Loading::class,
            'stage' => 'loading',
        ));
    }

}
