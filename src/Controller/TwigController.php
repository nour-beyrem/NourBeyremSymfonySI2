<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    /**
     * @Route("/twig/{n?5<\d+>}", name="twig")
     */
    public function index($n)
    {
        $tab = [];
        for ($i = 0; $i < $n; $i++) {
            $tab[$i] = rand(0, 20);
        }
        return $this->render('twig/index.html.twig', [
            'table1' => $tab
        ]);
    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/colortab", name="twig.colorTab")
     */
    public function tabColor()
    {
        $users = [
            ['name' => 'beyrem', 'firstname' => 'nour', 'age' => 24],
            ['name' => 'beyrem', 'firstname' => 'marah', 'age' => 22],
            ['name' => 'mansour', 'firstname' => 'amine', 'age' => 31]
        ];
        return $this->render('twig/colorTab.html.twig', [
            'user' => $users
        ]);
    }

    /**

     * @Route("layout", name="base.layout")
     */
    public function layout()
    {

        return $this->render('twig/layout.html.twig');
    }

    /**

     * @Route("page1", name="page1")
     */
    public function page1()
    {

        return $this->render('twig/page1.html.twig');
    }

    
}
