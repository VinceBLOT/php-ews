<?php
/**
 * Contains \jamesiarmes\PEWS\Type\ResponseObjectCoreType;
 */

namespace jamesiarmes\PEWS\Type;

/**
 * Internal abstract base type for reply objects.
 *
 * @package php-ews\Types
 */
abstract class ResponseObjectCoreType extends MessageType
{
    /**
     * The name of this reply object class as an English string.
     *
     * The client application is required to translate it if it's running in a
     * different locale.
     *
     * @since Exchange 2007
     *
     * @var string
     */
    public $ObjectName;
}
