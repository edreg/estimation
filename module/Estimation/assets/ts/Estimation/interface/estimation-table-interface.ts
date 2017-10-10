import {AbstractAjaxJsonModelInterface} from "../../library/interface/abstract-ajax-json-model-interface";

export interface EstimationTableInterface extends AbstractAjaxJsonModelInterface
{
    optimisticEstimation : any;

    realisticEstimation : number;

    pessimisticEstimation : number;

    probability : number;

    uncertainty : number;

    threePoint : number;

    average : number;

    pert : number;
}