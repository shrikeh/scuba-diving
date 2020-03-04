<?php

declare(strict_types=1);

/**
 * This is an automatically generated baseline for Phan issues.
 * When Phan is invoked with --load-baseline=path/to/baseline.php,
 * The pre-existing issues listed in this file won't be emitted.
 *
 * This file can be updated by invoking Phan with --save-baseline=path/to/baseline.php
 * (can be combined with --load-baseline)
 */

return [
    // # Issue statistics:
    // PhanUnreferencedUseNormal : 3 occurrences
    // PhanTypeInvalidThrowsIsInterface : 2 occurrences
    // PhanParamSignatureRealMismatchReturnType : 1 occurrence

    // Currently, file_suppressions and directory_suppressions are the only supported suppressions
    'file_suppressions' => [
        'application/app/Kit/Handler/QueryKitItem.php' => ['PhanUnreferencedUseNormal'],
        'application/app/Kit/Query/Result/SimpleItem.php' => ['PhanUnreferencedUseNormal'],
        'application/app/Kit/Repository/Item/ItemApi.php' => ['PhanTypeInvalidThrowsIsInterface'],
        'application/app/Kit/Repository/Item/ModelFactory/ItemResolver.php' => ['PhanUnreferencedUseNormal'],
        'application/app/Kit/Repository/Manufacturer/ManufacturerApi.php' => ['PhanTypeInvalidThrowsIsInterface'],
        'application/app/Kit/Repository/Manufacturer/ResponseParser/ItemManufacturer.php' => ['PhanParamSignatureRealMismatchReturnType'],
    ],
    // 'directory_suppressions' => ['src/directory_name' => ['PhanIssueName1', 'PhanIssueName2']] can be manually added if needed.
    // (directory_suppressions will currently be ignored by subsequent calls to --save-baseline, but may be preserved in future Phan releases)
];
