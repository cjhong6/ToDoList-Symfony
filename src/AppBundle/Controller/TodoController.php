<?php

namespace AppBundle\Controller;


use AppBundle\Entity\TodoItem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller{
    /**
     * @Route("/", name = "todo_list")
     */
    public function listAction(){
        $toDoItemList = $this -> getDoctrine() -> getRepository('AppBundle:TodoItem') -> findAll();

        return $this->render('todo/index.html.twig', array(
            'todoItems' => $toDoItemList
        ));
    }

    /**
     * @Route("/todos/detail/{id}", name = "todo_detail")
     */
    public function detailAction($id){
        return $this->render('todo/detail.html.twig');
    }

    /**
     * @Route("/todos/edit/{id}", name = "todo_edit")
     */
    public function editAction($id, Request $request){
        return $this->render('todo/edit.html.twig');
    }

    /**
     * @Route("/todos/create", name = "todo_create")
     */
    public function createAction(Request $request){
        //create a toDoItem Object give it a variable name
        $toDoItem1 = new TodoItem;

        //create a form
        $form = $this -> createFormBuilder($toDoItem1)
            -> add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px','placeholder' => 'Pick Up Kid, Do HW, etc.')))
            -> add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Family, Errand, etc.')))
            -> add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px', 'placeholder' => 'Pick kid at 5pm, etc.')))
            -> add('priorty', ChoiceType::class, array('placeholder' => 'Choose an option','choices' => array('low' => 'low', 'mid' => 'mid', 'high' => 'high'), 'attr' => array('class' => 'form-control', 'margin-bottom:15px')))
            -> add('due_date', DateTimeType::class)
            -> add('save', SubmitType::class, array('label' => 'Create To Do Item', 'attr' => array('class' => 'btn btn-primary', 'margin-bottom:15px')))
            -> getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name'] -> getData();
            $category = $form['category'] -> getData();
            $description = $form['description'] -> getData();
            $priorty = $form['priorty'] -> getData();
            $due_date = $form['due_date'] -> getData();

            $nowDate = new\DateTime('now');

            $toDoItem1 -> setName($name);
            $toDoItem1 -> setCategory($category);
            $toDoItem1 -> setDescription($description);
            $toDoItem1 -> setPriorty($priorty);
            $toDoItem1 -> setDueDate($due_date);
            $toDoItem1 -> setCreateDate($nowDate);

            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($toDoItem1);
            $em -> flush();

            $this -> addFlash('notice', 'New To Do Item Created');

            return $this->redirectToRoute("todo_list");

        }

        return $this->render('todo/create.html.twig', array(
            "form" => $form -> createView()
        ));
    }

    /**
     *
     * @Route("/todos/delete/{id}", name = "todo_delete")
     */
    public function deleteAction($id, Request $request){
        return $this->render('todo/delete.html.twig');
    }

}