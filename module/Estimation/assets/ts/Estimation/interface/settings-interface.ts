import {EstimationTableInterface} from "estimation-table-interface";
import {EstimationTableColumnInterface} from "estimation-table-column-interface";

export interface SupplierSelectSettingsInterface
{
    dataTableId: string;

    dataList: Array<EstimationTableInterface>;

    columnList: EstimationTableColumnInterface;

    tableFilterValue: string;
}