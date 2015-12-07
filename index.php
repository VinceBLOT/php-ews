<?php
ini_set('max_execution_time', 0);

require_once('ExchangeWebServices.php');
require_once('NTLMSoapClient.php');
require_once('NTLMSoapClient/Exchange.php');
require_once('EWS_Exception.php');
require_once('EWSType.php');

spl_autoload_register(
        function ($class) {
            $class = explode('_', $class);
            if ($class[0] == 'EWSType')
                require_once $class[0] . '/' . $class[1] . '.php';
        }
);



$ews = new ExchangeWebServices($host, $username, $password);

$request = new EWSType_FindItemType();

$request->ItemShape = new EWSType_ItemResponseShapeType();
$request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::DEFAULT_PROPERTIES;

$request->Traversal = EWSType_ItemQueryTraversalType::SHALLOW;

$request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();

$request->ParentFolderIds->FolderId = new EWSType_FolderIdType();
$request->ParentFolderIds->FolderId->Id = 'AAAUAHYtYmxvdEBsZWdhbGxhaXMuY29tAC4AAAAAAMPesS06BSxGv2vT074n9t0BAGVrQK4Od55NofVQDQdf3qoAAWioEzQAAA==';
$request->ParentFolderIds->FolderId->ChangeKey = 'AQAAABYAAABla0CuDneeTaH1UA0HX96qAAFosmUp';

// request
$result = $ews->FindItem($request);
if ($result->ResponseMessages->FindItemResponseMessage->ResponseCode == 'NoError' && $result->ResponseMessages->FindItemResponseMessage->ResponseClass == 'Success')
{
    $count = $result->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView;
    for ($i = 0; $i < $count; $i++){
        $message_id = $result->ResponseMessages->FindItemResponseMessage->RootFolder->Items->Message[$i]->ItemId->Id;
        $request = new EWSType_GetItemType();

        $request->ItemShape = new EWSType_ItemResponseShapeType();
        $request->ItemShape->BaseShape = EWSType_DefaultShapeNamesType::ALL_PROPERTIES;

        $request->ItemIds = new EWSType_NonEmptyArrayOfBaseItemIdsType();
        $request->ItemIds->ItemId = new EWSType_ItemIdType();
        $request->ItemIds->ItemId->Id = $message_id;

        $response = $ews->GetItem($request);
        //print_r($response);exit;
        if( $response->ResponseMessages->GetItemResponseMessage->ResponseCode == 'NoError' &&
            $response->ResponseMessages->GetItemResponseMessage->ResponseClass == 'Success' ) {

            $message = $response->ResponseMessages->GetItemResponseMessage->Items->Message;

            if($message) {
                //if(date("Y-m-d",strtotime($message->DateTimeReceived)) == date("Y-m-d")) {

                    if(!empty($message->Attachments->FileAttachment)) {
                        // FileAttachment attribute can either be an array or instance of stdClass...
                        $attachments = array();
                        if(is_array($message->Attachments->FileAttachment) === FALSE ) {
                            $attachments[] = $message->Attachments->FileAttachment;
                        }
                        else {
                            $attachments = $message->Attachments->FileAttachment;
                        }

                        foreach($attachments as $attachment) {
                            $request = new EWSType_GetAttachmentType();
                            $request->AttachmentIds = new EWSType_NonEmptyArrayOfRequestAttachmentIdsType();
                            $request->AttachmentIds->AttachmentId = new EWSType_RequestAttachmentIdType();
                            $request->AttachmentIds->AttachmentId->Id = $attachment->AttachmentId->Id;
                            $response = $ews->GetAttachment($request);

                            // Assuming response was successful ...
                            $attachments = $response->ResponseMessages->GetAttachmentResponseMessage->Attachments;
                            $content = $attachments->FileAttachment->Content;

                            if($message->Subject == "Export - Liste des lots") {
                                file_put_contents('MARCHE/'.$attachment->Name, $content);
                            }
                            if($message->Subject == "Export - Liste des groupes") {
                                file_put_contents('GROUPE/'.$attachment->Name, $content);
                            }
                            if($message->Subject == "Export - Liste des chantiers") {
                                file_put_contents('CHANTIER/'.$attachment->Name, $content);
                            }
                        }
                    }
                //}
            }
        }
    }
}
