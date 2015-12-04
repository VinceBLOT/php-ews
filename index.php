<?php
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
$response = $ews->FindItem($request);

echo '<pre>'; var_dump($response);

/*
[13] => stdClass Object
  (
      [FolderId] => stdClass Object
          (
              [Id] => AAAUAHYtYmxvdEBsZWdhbGxhaXMuY29tAC4AAAAAAMPesS06BSxGv2vT074n9t0BAGVrQK4Od55NofVQDQdf3qoAAWioEzQAAA==
              [ChangeKey] => AQAAABYAAABla0CuDneeTaH1UA0HX96qAAFosmUp
          )

      [ParentFolderId] => stdClass Object
          (
              [Id] => AAAUAHYtYmxvdEBsZWdhbGxhaXMuY29tAC4AAAAAAMPesS06BSxGv2vT074n9t0BAGVrQK4Od55NofVQDQdf3qoAAAAAAQkAAA==
              [ChangeKey] => AQAAAA==
          )

      [FolderClass] => IPF.Note
      [DisplayName] => Export SARA
      [TotalCount] => 3
      [ChildFolderCount] => 0
      [UnreadCount] => 0
  )*/
