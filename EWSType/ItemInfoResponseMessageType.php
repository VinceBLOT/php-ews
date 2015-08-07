<?php
/**
 * Contains EWSType_ItemInfoResponseMessageType.
 */

use jamesiarmes\PEWS\Type\ResponseMessageType;

/**
 * Represents the status and result of a single item operation request.
 *
 * @package php-ews\Types
 */
class EWSType_ItemInfoResponseMessageType extends ResponseMessageType
{
    /**
     * Currently unused and reserved for future use.
     *
     * This element contains a value of 0.
     *
     * @since Exchange 2007
     *
     * @var integer
     */
    public $DescriptiveLinkKey;

    /**
     * Contains an array of created items.
     *
     * @since Exchange 2007
     *
     * @var EWSType_ArrayOfRealItemsType
     */
    public $Items;

    /**
     * Provides a text description of the status of the response.
     *
     * @since Exchange 2007
     *
     * @var string
     */
    public $MessageText;

    /**
     * Provides additional error response information.
     *
     * @since Exchange 2007
     *
     * @var string
     *
     * @todo Determine if we can use SimpleXML or DOMDocument here.
     */
    public $MessageXml;

    /**
     * Describes the status of the response.
     *
     * @since Exchange 2007
     *
     * @var \jamesiarmes\PEWS\Enumeration\ResponseClassType
     */
    public $ResponseClass;

    /**
     * Provides an error code that identifies the specific error that the
     * request encountered.
     *
     * @since Exchange 2007
     *
     * @var \jamesiarmes\PEWS\Enumeration\ResponseCodeType
     */
    public $ResponseCode;
}
