<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Entity\User;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RatingController extends AbstractController
{
    /**
     * @Route("/add_rate", name="add_rate")
     */
    public function add_rate(Request $request, ValidatorInterface $validator): Response
    {
        if(!$request->request->has('user_giver_id') || !$request->request->has('user_recepient_id') || !$request->request->has('rate')){
            throw new DomainException('one of property doesnt set');
        }

        $giverId = $request->request->get('user_giver_id');
        $recepientId = $request->request->get('user_recepient_id');
        $rate = $request->request->get('rate');

        $giver = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($giverId);

        $recepient = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($recepientId);

//        dd($user_giver, $user_recepient);

        $rating = new Rating($giver, $recepient, $rate);

        // validations
        $errors = $validator->validate($rating);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }

        // save to database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rating);
        $entityManager->flush();

        return $this->redirect('/user_profile/' . $recepientId);
    }
}
