<?php

namespace App\Form;

use App\Entity\{
    Order,
    Customer,
    Product,
    FuelStation
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
    TextType,
    ChoiceType,
    FormType
};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class OrderItemType extends AbstractType {

    use \App\Utility\Utils;

    public function buildForm(FormBuilderInterface $builder, array $options) {
        switch ($options['stage']) {
            case 'entry': {
                    if ($options['is_first_entry'] == true) {
                        $builder->add('order', FormType::class, array("action" => "", "by_reference" => false, "label" => false));
                    } else {
                        $builder->add('order', HiddenType::class, array("data" => $options['order']->getId()));
                    }
                    $builder->add('product', EntityType::class, array("label" => "Product: ",
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
                                    return ['data-price' => $product->getUnitPrice()];
                                },
                                "placeholder" => "Select Product"))
                            ->add('unitPrice', MoneyType::class, array("label" => "Unit Price: ", "currency" => "NGN", "grouping" => true))
                            ->add('quantityOrdered', IntegerType::class, array("label" => "Quantity: ", "scale" => 0))
                            ->add('fromstation', ChoiceType::class, array("expanded" => true,
                                "multiple" => true,
                                "choices" => array("Select from list of managed fuel stations" => false),
                                "mapped" => false,
                                "required" => false,
                                "label" => false
                            ))
                            ->add('locationname', EntityType::class, array("mapped" => false, "label" => "Deliver Product To: ",
                                "attr" => array("class" => "custom-select"),
                                'class' => FuelStation::class,
                                'query_builder' => function (EntityRepository $er) use ($options) {
                                    $qb = $er->createQueryBuilder('t');
                                    $qb = $qb->orderBy('t.stationName', 'DESC');
                                    return $qb;
                                },
                                'choice_label' => function ($station) {
                                    return $station->getStationName();
                                },
                                'choice_attr' => function ($station) {
                                    return ["data-station" => $station->getStationName()];
                                },
                                "placeholder" => "Select Fuel Station"))
                            ->add('deliveryLocation', TextareaType::class, array("label" => "Delivery Address: ", "required" => true));
                    break;
                }
            case 'delivery': {
                    $builder->add('deliveryRemark', TextareaType::class, array("label" => "Delivery Remark: ", "required" => true));
                    break;
                }
            case 'cancellation': {
                    $builder->add('cancellationRemark', TextareaType::class, array("label" => "Delivery Remark: ", "required" => true));
                    break;
                }
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
// ... adding the name field if needed
            $orderitem = $event->getData();
            $form = $event->getForm();

            if (!$orderitem || null === $orderitem->getId()) {
                $form->add('Add Order Item', SubmitType::class, array("label" => "Add Order Item"));
            } else {
                switch ($options['stage']) {
                    case 'delivery':
                        $form->add('quantityDelivered', IntegerType::class, array("label" => "Quantity Delivered: ", "scale" => 0, "data" => $orderitem->getQuantityOrdered()))
                                ->add('Modify Order Item Delivery', SubmitType::class, array("label" => "Modify Order Item Delivery"));
                        break;
                    case 'entry':
                        $form->add('Modify Order Item', SubmitType::class, array("label" => "Modify Order Item"));
                        break;
                    case 'cancellation':
                        $form->add('Remove Order Item', SubmitType::class, array("label" => "Remove Order Item"));
                        break;
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => OrderItem::class,
            'order' => null,
            'is_first_entry' => true, /* or false */
            'stage' => 'entry' /* or 'delivery' or 'cancellation' */
        ));
    }

}
