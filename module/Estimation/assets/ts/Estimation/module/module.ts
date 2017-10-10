import DataTable = DataTables.DataTable;
import {SupplierSelectSettingsInterface} from "../interface/settings-interface";
import {EstimationTableInterface} from "../interface/estimation-table-interface";
import {EstimationTableColumnInterface} from "../interface/estimation-table-column-interface";

export class EstimationModel {

    /**
     * Settings
     */
    public _settings: SupplierSelectSettingsInterface;

    constructor(settingContainerId: string) {
        this._settings = JSON.parse($('#' + settingContainerId).html());
    }

    /**
     * Initialize
     */
    public init(): void {
        this.initDataTable();
    }

    public initDataTable(): void {
        let dataTableSelector: JQuery = $('#' + this._settings.dataTableId);
        let classInstance = this;
        let columnList = classInstance._settings.columnList;
        let filterValue = classInstance._settings.tableFilterValue;

        $(dataTableSelector).DataTable({
            data: classInstance._settings.dataList,
            columns: [
                {data: 'optimisticEstimation', title: columnList.optimisticEstimation},
                {data: 'realisticEstimation', title: columnList.realisticEstimation},
                {data: 'pessimisticEstimation', title: columnList.pessimisticEstimation},
                {data: 'probability', title: columnList.probability},
                {data: 'uncertainty', title: columnList.uncertainty},
                {data: 'threePoint', title: columnList.threePoint},
                {data: 'average', title: columnList.average},
                {data: 'pert', title: columnList.pert},
            ],
            //orderFixed: [ 0, 'asc' ],
            paging: true,
            pagingType: 'simple_numbers',
            pageLength: 15,
            ordering: true,
            info: true,
            searching: true,
            rowsGroup: [ 0, 1 ],
            //order: [[4, 'asc'], [3, 'desc']],
            search: {
                search: filterValue
            },
            initComplete: function () {
                $(this).show();
            }
        });
    }
}
