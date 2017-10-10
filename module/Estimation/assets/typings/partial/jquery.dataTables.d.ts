declare module DataTables  {
    //export module DataTables {
        export interface DataTable  {
            api(): DataTable;
            draw(reset?: boolean|string);
        }
    //}

    export interface Settings {
        buttons?: boolean | Array<string> | ButtonsSettings;
        rowsGroup?: Array<number>;
    }

    interface ButtonsSettings {
        name?: string;
        buttons: Array<string>;
    }
}
