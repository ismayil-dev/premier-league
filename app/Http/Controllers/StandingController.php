<?php

namespace App\Http\Controllers;

use App\Http\Repositories\StandingRepository;
use App\Services\Prediction\Prediction;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class StandingController extends Controller
{
    /**
     * @var StandingRepository $standingRepository
     */
    protected StandingRepository $standingRepository;

    /**
     * @var Prediction
     */
    protected Prediction $prediction;

    /**
     * StandingController constructor
     * @param StandingRepository $standingRepository
     * @param Prediction $prediction
     */
    public function __construct(StandingRepository $standingRepository, Prediction $prediction)
    {
        $this->standingRepository = $standingRepository;
        $this->prediction = $prediction;
    }

    /**
     * Return rendered standings table
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function fetch(Request $request): string
    {
        throw_if(!$request->ajax(), new BadRequestHttpException('Request should be AJAX'));

        $standings = $this->standingRepository->getByScore();
        return view('standing', compact('standings'))->render();
    }

    /**
     * Return rendered predictions
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function fetchPredictions(Request $request): string
    {
        throw_if(!$request->ajax(), new BadRequestHttpException('Request should be AJAX'));

        $predictions = $this->prediction::calculate();
        return view('championship_prediction', compact('predictions'))->render();
    }
}
