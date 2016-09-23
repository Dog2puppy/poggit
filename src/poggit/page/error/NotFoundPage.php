<?php

/*
 * Copyright 2016 poggit
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace poggit\page\error;

use poggit\page\Page;
use function poggit\getRootPath;
use function poggit\headIncludes;

class NotFoundPage extends Page {
    public function getName() :string {
        return "err";
    }

    public function output() {
        http_response_code(404);
        ?>
        <html>
        <head>
            <?php headIncludes() ?>
            <title>404 Not Found</title>
        </head>
        <body>
        <h1>404 Not Found</h1>
        <p>Path <code class="code"><span class="verbose"><?= getRootPath() ?></span><?= $this->getQuery() ?></code>,
            does not exist or is not visible to you.</p>
        <p>Referrer: <?= $_SERVER["HTTP_REFERER"] ?? "<em>nil</em>" ?></p>
        </body>
        </html>
        <?php
    }
}
