<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/bag", name="bag")
     */
    public function bolsaBolasAction(Request $request)
    {

        $arrayBolas = $this->crearArrayConBolas(100);
        // front array bolas
        return $this->render('default/bolsabolas.html.twig', ['arraybolas' => $arrayBolas]);
    }

    /**
     * @param Request $request
     * @Route("/askBall", name="askBall", options={"expose"=true})
     */
    public function askBallAction(Request $request)
    {
        $bola = $request->get('val');
        $arraySinBola = $this->crearArrayConBolas(100, false);
        $arrayOrdenExtraccionBolas =  $this->crearArrayConBolas(100, true);
        $ordenExtraccionBolas = array();

        //quito la bola (si es la nº0 es aleatoria)
        if ($bola == 0){
            $bola = array_rand($arraySinBola, 1);
        }
        unset($arraySinBola[array_search($bola,$arraySinBola)]);


        //busco la bola - una a una todas las bolas de la bolsa
        foreach ($arrayOrdenExtraccionBolas as $key => $b){
            if ((array_search($b, $arraySinBola)) !== false) {
                unset($arrayOrdenExtraccionBolas[$key]);

                $ordenExtraccionBolas[] = $b;
            }
        }
        $bolaGanadora = $arrayOrdenExtraccionBolas[array_key_first($arrayOrdenExtraccionBolas)];


        return new JsonResponse([
            'arrayConBolaExtraida' => $bola,
            'bolaGanadora' => $bolaGanadora,
            'ordenExtraccionBolas' => $ordenExtraccionBolas,
            'aaa' => $arrayOrdenExtraccionBolas,

            'responseText' => 'error'
        ]);
    }

    private function crearArrayConBolas($n, $mezclar = true){

        $arr = range(1,$n);
        if ($mezclar){
            shuffle($arr);
        }
        return $arr;
    }
}
