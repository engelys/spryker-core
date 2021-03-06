<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Storage\Business\Model;

interface StorageExporterInterface
{
    /**
     * @param string $destination
     *
     * @return bool
     */
    public function export($destination);
}
