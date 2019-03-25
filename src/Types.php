<?php
namespace LittleElephantClient;

/**
 * Available document types
 *
 * @author g.rombalski@unit27.net
 *
 */
class Types {
    public const AUTOMATIC = 'AUTOMATIC';

    public const RECEIPT = 'RECEIPT';

    public const INVOICE = 'INVOICE';

    public const BUSINESS_CARD = 'BUSINESS_CARD';

    public const PAGE = 'PAGE';

    /**
     * Available types
     *
     * @var string[]
     */
    public static $availableTypes = [
        self::AUTOMATIC,
        self::RECEIPT,
        self::INVOICE,
        self::BUSINESS_CARD
    ];
}