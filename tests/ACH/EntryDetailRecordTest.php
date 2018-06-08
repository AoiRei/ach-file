<?php
/**
 * Created by PhpStorm.
 * User: mcasiro
 * Date: 2018-06-01
 * Time: 13:14
 */

namespace RW\Tests\ACH;


use PHPUnit\Framework\TestCase;
use RW\ACH\EntryDetailRecord;
use RW\ACH\ValidationException;

class EntryDetailRecordTest extends TestCase
{
    private const VALID_TRANSIT_ABA_NUMBER = '123456789';
    private const VALID_DFI_ACCOUNT_NUMBER = '01234-567-891011';
    private const VALID_AMOUNT             = '11.00';
    private const VALID_INDIVIDUAL_NAME    = 'A Valid Company Name';
    private const VALID_ADDENDA_INDICATOR  = '1';
    private const VALID_TRACE_NUMBER       = '12345678';
    private const VALID_ID_NUMBER          = 'AF34B52';
    private const VALID_DRAFT_INDICATOR    = '1*';

    // region Data Providers
    public function missingRequiredFieldInputsProvider()
    {
        return [
            [
                [
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                \InvalidArgumentException::class,
            ],
            [
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                \InvalidArgumentException::class,
            ],
            [
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                \InvalidArgumentException::class,
            ],
            [
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                \InvalidArgumentException::class,
            ],
            [
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                \InvalidArgumentException::class,
            ],
            [
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                ],
                \InvalidArgumentException::class,
            ],
        ];
    }

    public function invalidInputsProvider()
    {
        return [
            [
                // Invalid Transaction Code
                [
                    EntryDetailRecord::TRANSACTION_CODE   => '21',
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Empty Transaction Code
                [
                    EntryDetailRecord::TRANSACTION_CODE   => '',
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Null Transaction Code
                [
                    EntryDetailRecord::TRANSACTION_CODE   => null,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Transit ABA Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => 'A2345678',
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long Transit ABA Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => '1234567890',
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Short Transit ABA Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => '12345678',
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Empty Transit ABA Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => '',
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Null Transit ABA Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => null,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid DFI Account Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => '1234.56789.1234',
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long DFI Account Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => '012345678901234567',
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Empty DFI Account Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => '',
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Null DFI Account Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => null,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Amount
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => 'A2345.67',
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long Amount
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => '123456789',
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Another Long Amount
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => '123456789.12',
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Empty Amount
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => '',
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Null Amount
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => null,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Id Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::ID_NUMBER          => 'ABC123*&^',
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long Id Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::ID_NUMBER          => '1234567890ABCDEF',
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Individual Name
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => 'A b*d name',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long Individual Name
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => 'This name is toooo long',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Empty Individual Name
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => '',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Null Individual Name
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => null,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Bank Draft Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::DRAFT_INDICATOR    => '11',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long Bank Draft Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::DRAFT_INDICATOR    => '   ',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Short Bank Draft Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::DRAFT_INDICATOR    => '1',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Addenda Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => '2',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Long Addenda Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => '01',
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                ValidationException::class,
            ],
            [
                // Invalid Trace Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => self::VALID_ADDENDA_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => 'A2345678',
                ],
                ValidationException::class,
            ],
            [
                // Long Trace Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => self::VALID_ADDENDA_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => '123456789',
                ],
                ValidationException::class,
            ],
            [
                // Short Trace Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => self::VALID_ADDENDA_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => '1234567',
                ],
                ValidationException::class,
            ],
            [
                // Empty Trace Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => self::VALID_ADDENDA_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => '',
                ],
                ValidationException::class,
            ],
            [
                // Null Trace Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => self::VALID_ADDENDA_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => null,
                ],
                ValidationException::class,
            ],
        ];
    }

    public function validInputsProvider()
    {
        return [
            [
                // Standard Entries
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                '62212345678901234-567-891011 0000001100               A VALID COMPANY NAME    0123456780000001',
            ],
            [
                // Custom Id Number
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::ID_NUMBER          => self::VALID_ID_NUMBER,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                '62212345678901234-567-891011 0000001100AF34B52        A VALID COMPANY NAME    0123456780000001',
            ],
            [
                // Custom Draft Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::DRAFT_INDICATOR    => self::VALID_DRAFT_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                '62212345678901234-567-891011 0000001100               A VALID COMPANY NAME  1*0123456780000001',
            ],
            [
                // Custom Addenda Indicator
                [
                    EntryDetailRecord::TRANSACTION_CODE   => EntryDetailRecord::CHECKING_CREDIT_DEPOSIT,
                    EntryDetailRecord::TRANSIT_ABA_NUMBER => self::VALID_TRANSIT_ABA_NUMBER,
                    EntryDetailRecord::DFI_ACCOUNT_NUMBER => self::VALID_DFI_ACCOUNT_NUMBER,
                    EntryDetailRecord::AMOUNT             => self::VALID_AMOUNT,
                    EntryDetailRecord::INDIVIDUAL_NAME    => self::VALID_INDIVIDUAL_NAME,
                    EntryDetailRecord::ADDENDA_INDICATOR  => self::VALID_ADDENDA_INDICATOR,
                    EntryDetailRecord::TRACE_NUMBER       => self::VALID_TRACE_NUMBER,
                ],
                '62212345678901234-567-891011 0000001100               A VALID COMPANY NAME    1123456780000001',
            ],
        ];
    }
    // endregion

    /**
     * @param $input
     * @param $output
     * @dataProvider  missingRequiredFieldInputsProvider
     */
    public function testMissingRequiredFieldThrowsInvalidArgumentException($input, $output)
    {
        $e = null;
        try {
            new EntryDetailRecord($input, 1);
        } catch (\Exception $e) {
        }

        $this->assertNotNull($e);
        $this->assertEquals($output, get_class($e));
    }

    /**
     * @param $input
     * @param $output
     * @dataProvider invalidInputsProvider
     */
    public function testInvalidInputThrowsValidationException($input, $output)
    {
        $e = null;
        try {
            new EntryDetailRecord($input, 1);
        } catch (\Exception $e) {
        }

        $this->assertNotNull($e);
        $this->assertEquals($output, get_class($e));
    }

    /**
     * @param $input
     * @param $output
     * @throws \RW\ACH\ValidationException
     * @dataProvider validInputsProvider
     */
    public function testValidInputGeneratesCorrectEntryDetailRecord($input, $output)
    {
        $this->assertEquals($output, (new EntryDetailRecord($input, 1))->toString());
    }
}