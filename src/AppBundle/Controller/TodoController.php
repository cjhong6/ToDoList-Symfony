<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        //create a form
        $form = $this->createForm('AppBundle\Form\ToDoItemType');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //get the data and call setter and getter automatically!!!!
            $toDoItem1 = $form->getData();

            $toDoItem1 -> setCreateDate(new\DateTime('now'));

            //persist to the database
            $em = $this -> getDoctrine() -> getManager();
            $em -> persist($toDoItem1);
            $em -> flush();

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