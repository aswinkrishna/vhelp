<?php
/**
 * This file has been @generated by a phing task by {@link BuildMetadataPHPFromXml}.
 * See [README.md](README.md#generating-data) for more information.
 *
 * Pull requests changing data in these files will not be accepted. See the
 * [FAQ in the README](README.md#problems-with-invalid-numbers] on how to make
 * metadata changes.
 *
 * Do not modify this file directly!
 */


return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '1\\d{4,9}|(?:[2-478]\\d\\d|550)\\d{6}',
    'PossibleLength' => 
    array (
      0 => 5,
      1 => 6,
      2 => 7,
      3 => 8,
      4 => 9,
      5 => 10,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '[237]\\d{8}|8(?:51(?:0(?:0[03-9]|[1247]\\d|3[2-9]|5[0-8]|6[1-9]|8[0-6])|1(?:1[69]|[23]\\d|4[0-4]))|[6-8]\\d{4}|9(?:[02-9]\\d{3}|1(?:[0-57-9]\\d{2}|6[0135-9]\\d)))\\d{3}',
    'ExampleNumber' => '212345678',
    'PossibleLength' => 
    array (
      0 => 9,
    ),
    'PossibleLengthLocalOnly' => 
    array (
      0 => 8,
    ),
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '4(?:[0-3]\\d|4[047-9]|5[0-25-9]|6[6-9]|7[02-9]|8[0-2457-9]|9[017-9])\\d{6}',
    'ExampleNumber' => '412345678',
    'PossibleLength' => 
    array (
      0 => 9,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '180(?:0\\d{3}|2)\\d{3}',
    'ExampleNumber' => '1800123456',
    'PossibleLength' => 
    array (
      0 => 7,
      1 => 10,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '19(?:0[0126]\\d|[679])\\d{5}',
    'ExampleNumber' => '1900123456',
    'PossibleLength' => 
    array (
      0 => 8,
      1 => 10,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '13(?:00\\d{3}|45[0-4]|\\d)\\d{3}',
    'ExampleNumber' => '1300123456',
    'PossibleLength' => 
    array (
      0 => 6,
      1 => 8,
      2 => 10,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'personalNumber' => 
  array (
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '(?:14(?:5\\d|71)|550\\d)\\d{5}',
    'ExampleNumber' => '550123456',
    'PossibleLength' => 
    array (
      0 => 9,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => '16\\d{3,7}',
    'ExampleNumber' => '1612345',
    'PossibleLength' => 
    array (
      0 => 5,
      1 => 6,
      2 => 7,
      3 => 8,
      4 => 9,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'uan' => 
  array (
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'voicemail' => 
  array (
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '1(?:3(?:00\\d{3}|45[0-4]|\\d)\\d{3}|80(?:0\\d{6}|2\\d{3}))',
    'PossibleLength' => 
    array (
      0 => 6,
      1 => 7,
      2 => 8,
      3 => 10,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'id' => 'AU',
  'countryCode' => 61,
  'internationalPrefix' => '(?:14(?:1[14]|34|4[17]|[56]6|7[47]|88)0011)|001[14-689]',
  'preferredInternationalPrefix' => '0011',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([2378])(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2378]',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '14|[45]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    2 => 
    array (
      'pattern' => '(16)(\\d{3,4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '16',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    3 => 
    array (
      'pattern' => '(16)(\\d{3})(\\d{2,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '16',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    4 => 
    array (
      'pattern' => '(1[389]\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[389]0',
        1 => '1(?:[38]0|9)0',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    5 => 
    array (
      'pattern' => '(180)(2\\d{3})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '180',
        1 => '1802',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    6 => 
    array (
      'pattern' => '(19\\d)(\\d{3})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '19[13]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    7 => 
    array (
      'pattern' => '(19\\d{2})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '19[679]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
    8 => 
    array (
      'pattern' => '(13)(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '13[1-9]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
      'nationalPrefixOptionalWhenFormatting' => false,
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => true,
  'leadingZeroPossible' => false,
  'mobileNumberPortableRegion' => true,
);
