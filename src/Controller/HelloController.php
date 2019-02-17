<?php

namespace App\Controller;

use App\Entity\Produto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends Controller
{
    /**
     * @return Response
     *
     * @Route("hello-world")
     */
    public function world()
    {
        return new Response(
            "<html><body><h1>Hello World!</h1></body></html>"
        );
    }

    /**
     * @return Response
     *
     * @Route("mostrar-mensagem")
     */
    public function mensagem()
    {
        return $this->render("hello/mensagem.html.twig", [
            'mensagem' => "Olá School of net!"
        ]);
    }

    /**
     * @return Response
     *
     * @Route("cadastrar-produto")
     *
     */
    public function produto()
    {
        $em = $this->getDoctrine()->getManager();

        $produto = new Produto();
        $produto->setNome("Xbox")
            ->setPreco(2300.00);

        $em->persist($produto);
        $em->flush();

        return new Response("O produto " . $produto->getId() . " foi criado!");
    }

    /**
     * @return Response
     *
     * @Route("formulario")
     */
    public function formulario(Request $request)
    {
        $produto = new Produto();

        $form = $this->createFormBuilder()
            ->add('nome', TextType::class, ['required' => true])
            ->add('preco', TextType::class)
            ->add('enviar', SubmitType::class, ['label' => "Salvar"])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            return new Response("Formulario está ok!");
        }

        return $this->render("hello/formulario.html.twig", [
            'form' => $form->createView()
        ]);
    }

}