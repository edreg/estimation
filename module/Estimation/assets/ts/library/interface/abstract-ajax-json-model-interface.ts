export interface AbstractAjaxJsonModelInterface
{
    requestData: any;
    success: boolean;
    errorList: [string];
    content: string;
    redirectUrl: string;
}
