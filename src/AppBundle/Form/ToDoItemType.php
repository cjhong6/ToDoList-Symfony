<?php
/**
 * Created by PhpStorm.
 * User: chengjiu
 * Date: 3/26/17
 * Time: 1:03 AM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ToDoItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           -> add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Pick Up Kid, Do HW, etc.')))
           -> add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Family, Errand, etc.')))
           -> add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Pick kid at 5pm, etc.')))
           -> add('priorty', ChoiceType::class, array('placeholder' => 'Choose an option','choices' => array('low' => 'low', 'mid' => 'mid', 'high' => 'high'), 'attr' => array('class' => 'form-control', 'margin-bottom:15px')))
           -> add('due_date', DateTimeType::class)
           -> add('save', SubmitType::class, array('label' => 'Create To Do Item', 'attr' => array('class' => 'btn btn-primary', 'margin-bottom:15px')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TodoItem'
        ));
    }
}