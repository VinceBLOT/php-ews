$request = new EWSType_FindItemType();
  $itemProperties = new EWSType_ItemResponseShapeType();
  $itemProperties->BaseShape = EWSType_DefaultShapeNamesType::ID_ONLY;
  $itemProperties->BodyType = EWSType_BodyTypeResponseType::BEST;
  $request->ItemShape = $itemProperties;

  $fieldType = new EWSType_PathToUnindexedFieldType();
  $fieldType->FieldURI = 'message:IsRead';

  $constant = new EWSType_FieldURIOrConstantType();
  $constant->Constant = new EWSType_ConstantValueType();
  $constant->Constant->Value = "0";

  $IsEqTo = new EWSType_IsEqualToType();
  $IsEqTo->FieldURIOrConstant = $constant;
  $IsEqTo->Path = $fieldType;

  $request->Restriction = new EWSType_RestrictionType();
  $request->Restriction->IsEqualTo = new EWSType_IsEqualToType();
  $request->Restriction->IsEqualTo->FieldURI = $fieldType;
  $request->Restriction->IsEqualTo->FieldURIOrConstant = $constant;

  $request->IndexedPageItemView = new EWSType_IndexedPageViewType();
  $request->IndexedPageItemView->BasePoint = 'Beginning';
  $request->IndexedPageItemView->Offset = 0;

  $request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();
  $request->ParentFolderIds->DistinguishedFolderId = new EWSType_DistinguishedFolderIdType();
  $request->ParentFolderIds->DistinguishedFolderId->Id = EWSType_DistinguishedFolderIdNameType::INBOX;

  $request->Traversal = EWSType_ItemQueryTraversalType::SHALLOW;

  $request->ParentFolderIds = new EWSType_NonEmptyArrayOfBaseFolderIdsType();

    $request->ParentFolderIds->FolderId = new EWSType_FolderIdType();
    $request->ParentFolderIds->FolderId->Id = 'AAAUAHYtYmxvdEBsZWdhbGxhaXMuY29tAC4AAAAAAMPesS06BSxGv2vT074n9t0BAGVrQK4Od55NofVQDQdf3qoAAWioEzQAAA==';
    $request->ParentFolderIds->FolderId->ChangeKey = 'AQAAABYAAABla0CuDneeTaH1UA0HX96qAAFosmUp';

  $result = new EWSType_FindItemResponseMessageType();
  $result = $ews->FindItem($request);
  /*echo '<pre>';
  print_r($result);exit;*/
  if ($result->ResponseMessages->FindItemResponseMessage->ResponseCode == 'NoError' && $result->ResponseMessages->FindItemResponseMessage->ResponseClass == 'Success'){
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

              //process the message data.
              echo '<pre>'; var_dump($message);

          }

      }

  }
